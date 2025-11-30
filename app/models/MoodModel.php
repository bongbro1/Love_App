<?php
class MoodModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    // Thêm hoặc cập nhật mood của 1 người trong 1 ngày
    public function saveMood($coupleId, $userId, $mood, $note = null)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO mood_entries (couple_id, user_id, mood, note)
            VALUES (:couple_id, :user_id, :mood, :note)
            ON DUPLICATE KEY UPDATE
                mood = VALUES(mood),
                note = VALUES(note),
                created_at_ts = CURRENT_TIMESTAMP
        ");
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':user_id' => $userId,
            ':mood' => $mood,
            ':note' => $note
        ]);
    }

    // Lấy biểu đồ mood trung bình theo ngày (7 ngày gần nhất)
    public function getMoodStatsByDate($coupleId, $days = 7)
    {
        $sql = "
            SELECT 
                DATE(created_at_ts) AS date,
                AVG(mood_score) AS avg_score,
                COUNT(*) AS entries
            FROM mood_entries
            WHERE couple_id = :couple_id
              AND created_at_ts >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
            GROUP BY DATE(created_at_ts)
            ORDER BY date ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':days' => $days
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng hợp mood theo loại (để vẽ doughnut chart)
    public function getMoodSummary($coupleId, $filter = 'today')
    {
        // Chuyển filter thành số ngày
        switch ($filter) {
            case 'today':
                $dateFrom = date('Y-m-d'); // chỉ hôm nay
                break;
            case 'week':
                $dateFrom = date('Y-m-d', strtotime('-7 days'));
                break;
            case 'month':
                $dateFrom = date('Y-m-d', strtotime('-30 days'));
                break;
            default:
                $dateFrom = date('Y-m-d', strtotime('-7 days')); // mặc định 7 ngày
                break;
        }

        $sql = "
        SELECT mood, COUNT(*) as count
        FROM mood_entries
        WHERE couple_id = :couple_id
          AND created_at_ts >= :date_from
        GROUP BY mood
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':date_from' => $dateFrom
        ]);

        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Đảm bảo đủ tất cả mood keys
        $allMoods = ['very_happy', 'happy', 'neutral', 'sad', 'very_sad'];
        foreach ($allMoods as $m) {
            if (!isset($result[$m])) $result[$m] = 0;
        }

        return $result;
    }
}
