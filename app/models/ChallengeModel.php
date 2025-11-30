<?php
class ChallengeModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // --- Fetch all challenge templates ---
    public function getAllChallenges()
    {
        $coupleId = $_SESSION['couple_id'] ?? 0;

        // Lấy tất cả challenge chưa có instance hoàn thành của couple này
        $stmt = $this->db->prepare("
        SELECT c.*
        FROM challenges c
        WHERE c.id NOT IN (
            SELECT ci.challenge_id 
            FROM challenge_instances ci
            WHERE ci.couple_id = :cid
              AND ci.status = 'completed'
        )
        ORDER BY c.created_at DESC
    ");
        $stmt->execute(['cid' => $coupleId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChallengeById($challengeId, $participantId = null)
    {
        // Lấy thông tin challenge
        $stmt = $this->db->prepare("SELECT id, title, description, points, is_offline FROM challenges WHERE id = :id");
        $stmt->execute(['id' => $challengeId]);
        $challenge = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$challenge) return null;

        // Lấy danh sách tasks
        $stmt = $this->db->prepare("SELECT id, seq, text, requirement FROM challenge_tasks WHERE challenge_id = :cid ORDER BY seq ASC");
        $stmt->execute(['cid' => $challengeId]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Nếu có participantId, lấy trạng thái task
        if ($participantId) {
            $stmt2 = $this->db->prepare("SELECT completed_tasks FROM challenge_participants WHERE id = :pid");
            $stmt2->execute(['pid' => $participantId]);
            $p = $stmt2->fetch(PDO::FETCH_ASSOC);
            $completedTasks = $p && $p['completed_tasks'] ? json_decode($p['completed_tasks'], true) : [];

            foreach ($tasks as &$task) {
                $task['completed'] = in_array($task['id'], $completedTasks);
            }
        }

        $challenge['tasks'] = $tasks;

        return $challenge;
    }

    // --- Fetch tasks of a challenge ---
    public function getTasks($challengeId)
    {
        $stmt = $this->db->prepare("SELECT * FROM challenge_tasks WHERE challenge_id = :cid ORDER BY seq ASC");
        $stmt->execute(['cid' => $challengeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Start a challenge instance for a couple ---
    public function startChallenge($coupleId, $challengeId, $userId)
    {
        $this->db->beginTransaction();
        try {
            // Tạo instance
            $stmt = $this->db->prepare("
            INSERT INTO challenge_instances (couple_id, challenge_id, created_by) 
            VALUES (:couple_id, :challenge_id, :created_by)
        ");
            $stmt->execute([
                'couple_id' => $coupleId,
                'challenge_id' => $challengeId,
                'created_by' => $userId
            ]);
            $instanceId = $this->db->lastInsertId();

            // Lấy tất cả users trong couple
            $stmt2 = $this->db->prepare("SELECT id FROM users WHERE couple_id = :cid");
            $stmt2->execute(['cid' => $coupleId]);
            $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $u) {
                $stmt3 = $this->db->prepare("
                INSERT INTO challenge_participants (instance_id, user_id)
                VALUES (:instance_id, :user_id)
            ");
                $stmt3->execute([
                    'instance_id' => $instanceId,
                    'user_id' => $u['id']
                ]);
            }

            $this->db->commit();
            return ['success' => true, 'instance_id' => $instanceId];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function markChallengeCompleted($participantId)
    {
        // 1. Lấy participant info
        $stmt = $this->db->prepare("
        SELECT cp.completed_tasks, cp.score_awarded, cp.instance_id, ci.couple_id
        FROM challenge_participants cp
        JOIN challenge_instances ci ON cp.instance_id = ci.id
        WHERE cp.id = :pid
    ");
        $stmt->execute(['pid' => $participantId]);
        $participant = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$participant) return ['success' => false, 'message' => 'Participant không tồn tại'];

        $instanceId = $participant['instance_id'];
        $coupleId = $participant['couple_id'];
        $completedTasks = json_decode($participant['completed_tasks'], true) ?: [];

        // 2. Lấy tất cả task của challenge
        $stmt2 = $this->db->prepare("
        SELECT id FROM challenge_tasks
        WHERE challenge_id = (SELECT challenge_id FROM challenge_instances WHERE id = :iid)
    ");
        $stmt2->execute(['iid' => $instanceId]);
        $allTasks = $stmt2->fetchAll(PDO::FETCH_COLUMN);

        // 3. Kiểm tra tất cả task đã hoàn tất chưa
        $allCompleted = !array_diff($allTasks, $completedTasks); // true nếu không còn task nào chưa hoàn thành

        if (!$allCompleted) {
            return ['success' => false, 'message' => 'Chưa hoàn thành tất cả task'];
        }

        // 4. Lấy points của challenge
        $stmt3 = $this->db->prepare("
        SELECT c.points 
        FROM challenge_instances ci
        JOIN challenges c ON ci.challenge_id = c.id
        WHERE ci.id = :iid
    ");
        $stmt3->execute(['iid' => $instanceId]);
        $challenge = $stmt3->fetch(PDO::FETCH_ASSOC);
        $score = $challenge['points'] ?? 0;

        // 5. Cập nhật participant score (chỉ 1 lần)
        if ($participant['score_awarded'] == 0) {
            $stmtUpd = $this->db->prepare("
            UPDATE challenge_participants
            SET score_awarded = :score
            WHERE id = :pid
        ");
            $stmtUpd->execute([
                'score' => $score,
                'pid' => $participantId
            ]);
        }
        $stmtAdd = $this->db->prepare("
            UPDATE couples
            SET total_score = total_score + :score
            WHERE id = :cid
        ");
        $stmtAdd->execute([
            'score' => $score,
            'cid' => $coupleId
        ]);

        // 6. Cập nhật instance là completed
        $stmtUpd2 = $this->db->prepare("
        UPDATE challenge_instances
        SET status = 'completed', completed_at = NOW()
        WHERE id = :iid AND status != 'completed'
    ");
        $stmtUpd2->execute(['iid' => $instanceId]);

        return [
            'success' => true,
            'instance_id' => $instanceId,
            'score_awarded' => $score
        ];
    }


    // --- Complete a task for a participant ---
    public function completeTask($taskId)
    {
        $this->db->beginTransaction();

        try {
            // Lấy task info + challenge_id + points (points sẽ dùng sau khi hoàn thành challenge)
            $stmt = $this->db->prepare("
            SELECT t.id AS task_id, t.challenge_id, c.points 
            FROM challenge_tasks t
            JOIN challenges c ON t.challenge_id = c.id
            WHERE t.id = :tid
        ");
            $stmt->execute(['tid' => $taskId]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$task) throw new Exception("Task không tồn tại");

            $challengeId = $task['challenge_id'];
            $challengeScore = $task['points'] ?? 0; // sẽ dùng sau

            // Lấy hoặc tạo challenge_instance cho couple
            $stmt = $this->db->prepare("
            SELECT id FROM challenge_instances 
            WHERE couple_id = :cid AND challenge_id = :chid
        ");
            $stmt->execute(['cid' => $_SESSION['couple_id'], 'chid' => $challengeId]);
            $instance = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$instance) {
                $stmtIns = $this->db->prepare("
                INSERT INTO challenge_instances (couple_id, challenge_id, created_by)
                VALUES (:cid, :chid, :uid)
            ");
                $stmtIns->execute([
                    'cid' => $_SESSION['couple_id'],
                    'chid' => $challengeId,
                    'uid' => $_SESSION['user_id']
                ]);
                $instanceId = $this->db->lastInsertId();
            } else {
                $instanceId = $instance['id'];
            }

            // Lấy hoặc tạo participant
            $stmt = $this->db->prepare("
            SELECT id, completed_tasks, score_awarded 
            FROM challenge_participants 
            WHERE instance_id = :iid AND user_id = :uid
        ");
            $stmt->execute(['iid' => $instanceId, 'uid' => $_SESSION['user_id']]);
            $participant = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$participant) {
                $stmtIns = $this->db->prepare("
                INSERT INTO challenge_participants (instance_id, user_id, completed_tasks, score_awarded)
                VALUES (:iid, :uid, '[]', 0)
            ");
                $stmtIns->execute(['iid' => $instanceId, 'uid' => $_SESSION['user_id']]);
                $participantId = $this->db->lastInsertId();
                $completedTasks = [];
            } else {
                $participantId = $participant['id'];
                $completedTasks = json_decode($participant['completed_tasks'], true) ?: [];
            }

            // Thêm task mới nếu chưa có
            if (!in_array($taskId, $completedTasks)) {
                $completedTasks[] = $taskId;
            }

            // Cập nhật chỉ completed_tasks, tạm bỏ qua score_awarded
            $stmtUpd = $this->db->prepare("
            UPDATE challenge_participants
            SET completed_tasks = :tasks
            WHERE id = :pid
        ");
            $stmtUpd->execute([
                'tasks' => json_encode($completedTasks),
                'pid' => $participantId
            ]);

            $this->db->commit();

            return [
                'success' => true,
                'completed_tasks' => $completedTasks,
                'participant_id' => $participantId
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getChallengeHistoryByCouple($coupleId, $page = 1, $pageSize = 10)
    {
        $offset = ($page - 1) * $pageSize;

        $stmt = $this->db->prepare("
        SELECT 
            ci.id AS instance_id,
            c.id AS challenge_id,
            c.title AS challenge_title,
            COALESCE(cp.score_awarded, 0) AS score,
            ci.status,
            ci.completed_at
        FROM challenge_instances ci
        INNER JOIN challenges c ON ci.challenge_id = c.id
        INNER JOIN challenge_participants cp ON cp.instance_id = ci.id
        WHERE ci.couple_id = :cid
          AND ci.completed_at IS NOT NULL
          AND cp.score_awarded > 0
        GROUP BY ci.id, c.id, c.title, cp.score_awarded, ci.status, ci.completed_at
        ORDER BY ci.completed_at DESC
        LIMIT :limit OFFSET :offset
    ");

        $stmt->bindParam(':cid', $coupleId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function logLoveScoreByInstance($instanceId, $delta, $taskId = null)
    {
        // Lấy thông tin couple_id từ instance
        $stmt = $this->db->prepare("SELECT couple_id FROM challenge_instances WHERE id = :iid");
        $stmt->execute(['iid' => $instanceId]);
        $instance = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$instance) return false;

        $coupleId = $instance['couple_id'];

        // Ghi log điểm
        $stmt2 = $this->db->prepare("
        INSERT INTO love_score_logs (couple_id, delta, reason, meta)
        VALUES (:couple_id, :delta, :reason, :meta)
    ");
        $stmt2->execute([
            'couple_id' => $coupleId,
            'delta' => $delta,
            'reason' => 'Hoàn thành task ' . $taskId,
            'meta' => json_encode([
                'task_id' => $taskId,
                'instance_id' => $instanceId,
                'timestamp' => date('Y-m-d H:i:s')
            ])
        ]);

        // Cập nhật tổng điểm
        $stmt3 = $this->db->prepare("
        UPDATE couples 
        SET total_score = total_score + :delta 
        WHERE id = :cid
    ");
        $stmt3->execute([
            'delta' => $delta,
            'cid' => $coupleId
        ]);

        return true;
    }



    // --- Get total LoveScore of a couple ---
    public function getTotalScore($coupleId)
    {
        $stmt = $this->db->prepare("SELECT total_score FROM couples WHERE id=:cid");
        $stmt->execute(['cid' => $coupleId]);
        return intval($stmt->fetchColumn() ?? 0);
    }


    public function addChallengeInstance($coupleId, $data)
    {
        try {
            $this->db->beginTransaction();

            // 1️⃣ Thêm vào bảng challenges
            $stmt1 = $this->db->prepare("
            INSERT INTO challenges (title, description, points, is_offline)
            VALUES (:title, :description, :points, :is_offline)
        ");
            $stmt1->execute([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'points' => $data['points'] ?? 0,
                'is_offline' => $data['is_offline'] ?? 1
            ]);
            $challengeId = $this->db->lastInsertId();

            // 2️⃣ Thêm vào bảng challenge_instances
            $stmt2 = $this->db->prepare("
            INSERT INTO challenge_instances (couple_id, challenge_id, created_by)
            VALUES (:couple_id, :challenge_id, :created_by)
        ");
            $stmt2->execute([
                'couple_id' => $coupleId,
                'challenge_id' => $challengeId,
                'created_by' => $_SESSION['user_id'] ?? null
            ]);
            $instanceId = $this->db->lastInsertId();

            // 3️⃣ Thêm các task nếu có
            if (!empty($data['tasks']) && is_array($data['tasks'])) {
                $stmt3 = $this->db->prepare("
                INSERT INTO challenge_tasks (challenge_id, seq, text, requirement)
                VALUES (:challenge_id, :seq, :text, :requirement)
            ");
                foreach ($data['tasks'] as $seq => $task) {
                    $stmt3->execute([
                        'challenge_id' => $challengeId,
                        'seq' => $seq + 1, // đảm bảo bắt đầu từ 1
                        'text' => $task['text'] ?? '',
                        'requirement' => isset($task['requirement'])
                            ? json_encode($task['requirement'], JSON_UNESCAPED_UNICODE)
                            : null
                    ]);
                }
            }

            $this->db->commit();
            return $instanceId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Lỗi khi thêm thử thách: ' . $e->getMessage());
            return false;
        }
    }

    // Chi tiết challenge theo instance
    public function getChallengeDetail($challengeId, $userId = null)
    {
        // Kiểm tra có instance chưa
        $stmt = $this->db->prepare("
        SELECT ci.id AS instance_id, ci.status
        FROM challenge_instances ci
        WHERE ci.challenge_id = :cid AND ci.couple_id = :couple_id
        ORDER BY ci.started_at DESC
        LIMIT 1
    ");
        $stmt->execute([
            'cid' => $challengeId,
            'couple_id' => $_SESSION['couple_id']
        ]);
        $instance = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy challenge gốc
        $stmt2 = $this->db->prepare("
        SELECT id AS challenge_id, title, description, points
        FROM challenges
        WHERE id = :cid
    ");
        $stmt2->execute(['cid' => $challengeId]);
        $challenge = $stmt2->fetch(PDO::FETCH_ASSOC);
        if (!$challenge) return false;

        $challenge['instance_id'] = $instance['instance_id'] ?? null;
        $challenge['status'] = $instance['status'] ?? 'not_started';
        $challenge['participant_id'] = null; // mặc định chưa có participant

        // Lấy tasks
        if ($challenge['instance_id'] && $userId) {
            $stmt3 = $this->db->prepare("
            SELECT ct.id, ct.text, ct.seq,
                   CASE 
                       WHEN FIND_IN_SET(ct.id, REPLACE(REPLACE(cp.completed_tasks,'[',''),']','')) THEN 1
                       ELSE 0
                   END AS completed,
                   cp.id AS participant_id
            FROM challenge_tasks ct
            LEFT JOIN challenge_participants cp 
                ON cp.instance_id = :iid AND cp.user_id = :uid
            WHERE ct.challenge_id = :cid
            ORDER BY ct.seq ASC
        ");
            $stmt3->execute([
                'iid' => $challenge['instance_id'],
                'uid' => $userId,
                'cid' => $challengeId
            ]);
            $tasks = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            // Lấy participant_id từ task đầu tiên nếu có
            if (!empty($tasks)) {
                $challenge['participant_id'] = $tasks[0]['participant_id'];
            }

            $challenge['tasks'] = $tasks;
        } else {
            // Chưa có instance => tất cả completed = 0
            $stmt3 = $this->db->prepare("
            SELECT id, text, seq, 0 AS completed
            FROM challenge_tasks
            WHERE challenge_id = :cid
            ORDER BY seq ASC
        ");
            $stmt3->execute(['cid' => $challengeId]);
            $challenge['tasks'] = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        }

        return $challenge;
    }
}
