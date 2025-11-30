<?php
class SecretLetterModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function getCoupleIdByUser($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT couple_id 
            FROM couple_members 
            WHERE user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    /**
     * Thêm thư bí mật mới
     */
    public function addSecretLetter($userId, $body, $unlockAt)
    {
        $coupleId = $this->getCoupleIdByUser($userId);
        if (!$coupleId) return false;

        // Xác định giới tính để đặt title
        $stmt = $this->pdo->prepare("SELECT gender FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $gender = $stmt->fetchColumn();

        $title = match ($gender) {
            'male' => 'Thư từ Anh 💌',
            'female' => 'Thư từ Em 💌',
            default => 'Thư bí mật 💌',
        };

        $stmt = $this->pdo->prepare("
            INSERT INTO secret_letters (couple_id, sender_id, title, body, unlock_at)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$coupleId, $userId, $title, $body, $unlockAt]);

        return $this->pdo->lastInsertId();
    }

    public function getLatestSecretLetter($userId)
    {
        // Tìm couple_id mà user này thuộc về
        $stmt = $this->pdo->prepare("
        SELECT couple_id 
        FROM couple_members 
        WHERE user_id = ?
        LIMIT 1
    ");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        $coupleId = $row['couple_id'];

        // Lấy thư gần nhất TỪ đối phương (người cùng couple nhưng khác user_id)
        $stmt = $this->pdo->prepare("
        SELECT id, title, sender_id, body, unlock_at, is_opened, created_at
        FROM secret_letters
        WHERE couple_id = :couple_id
          AND sender_id != :sender_id
          AND is_opened = 0
          AND attachments IS NULL
        ORDER BY unlock_at ASC
        LIMIT 1
    ");
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':sender_id' => $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Mở thư (nếu đã đến ngày unlock)
     */
    public function markAsOpened($letterId)
    {
        // Kiểm tra xem thư có tồn tại không
        $stmt = $this->pdo->prepare("SELECT id FROM secret_letters WHERE id = ?");
        $stmt->execute([$letterId]);
        $exists = $stmt->fetchColumn();

        if (!$exists) {
            return ['success' => false, 'message' => 'Không tìm thấy thư'];
        }

        // Cập nhật trạng thái "đã mở"
        $stmt = $this->pdo->prepare("
        UPDATE secret_letters 
        SET is_opened = 1, opened_at = NOW()
        WHERE id = ?
    ");
        $stmt->execute([$letterId]);

        return ['success' => true];
    }

    // mdeia
    public function addSecretMedia($userId, $unlockAt, $attachments)
    {
        $coupleId = $this->getCoupleIdByUser($userId);
        if (!$coupleId) return false;

        // Lấy giới tính để đặt title
        $stmt = $this->pdo->prepare("SELECT gender FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $gender = $stmt->fetchColumn();

        $title = match ($gender) {
            'male' => 'Thư từ Anh 💌',
            'female' => 'Thư từ Em 💌',
            default => 'Thư bí mật 💌',
        };

        $stmt = $this->pdo->prepare("
            INSERT INTO secret_letters (couple_id, sender_id, title, attachments, unlock_at)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $coupleId,
            $userId,
            $title,
            json_encode($attachments, JSON_UNESCAPED_UNICODE),
            $unlockAt
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getNextAvailableMediaLetter($userId)
    {
        $coupleId = $this->getCoupleIdByUser($userId);
        if (!$coupleId) return null;

        $stmt = $this->pdo->prepare("
        SELECT id, title, sender_id, body, attachments, unlock_at, is_opened
        FROM secret_letters
        WHERE couple_id = :couple_id
          AND sender_id != :user_id
          AND (JSON_EXTRACT(attachments,'$.type') = 'video' OR JSON_EXTRACT(attachments,'$.type') = 'audio')
          AND is_opened = 0
        ORDER BY unlock_at ASC
        LIMIT 1
    ");
        $stmt->execute([':couple_id' => $coupleId, ':user_id' => $userId]);
        $letter = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$letter) return null;

        // Giải nén attachments JSON
        $letter['attachments'] = json_decode($letter['attachments'], true);
        $letter['type'] = $letter['attachments']['type'] ?? null;
        $letter['file_url'] = $letter['attachments']['file'] ?? null;

        return $letter;
    }
}
