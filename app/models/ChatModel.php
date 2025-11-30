<?php
// app/models/ChatModel.php
class ChatModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy danh sách tin nhắn theo cặp đôi
    public function getMessages($couple_id, $limit = 100)
    {
        $limit = (int)$limit; // ép kiểu an toàn
        $stmt = $this->pdo->prepare("
        SELECT m.*, u.display_name AS sender_name
        FROM messages m
        JOIN users u ON u.id = m.sender_id
        WHERE m.couple_id = :cid
        ORDER BY m.created_at ASC
        LIMIT $limit
    ");
        $stmt->bindValue(':cid', $couple_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lưu tin nhắn mới
    public function addMessage($couple_id, $sender_id, $body, $type = 'text')
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO messages (couple_id, sender_id, body, message_type)
            VALUES (:cid, :sid, :body, :type)
        ");
        return $stmt->execute([
            'cid' => $couple_id,
            'sid' => $sender_id,
            'body' => $body,
            'type' => $type
        ]);
    }
    public function deleteMessageByUser($messageId, $userId)
    {
        $sql = "DELETE FROM messages WHERE id = ? AND sender_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$messageId, $userId]);
        return $stmt->rowCount() > 0;
    }

    public function uploadImages($coupleId, $senderId, $files)
    {
        $uploadedUrls = [];

        if (empty($files['tmp_name'])) return $uploadedUrls;

        foreach ($files['tmp_name'] as $index => $tmpName) {
            $ext = pathinfo($files['name'][$index], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $target = __DIR__ . '/../../public/uploads/' . $filename;

            if (move_uploaded_file($tmpName, $target)) {
                $url = '/uploads/' . $filename;
                $uploadedUrls[] = $url;

                // Lưu DB
                $stmt = $this->pdo->prepare("
                    INSERT INTO messages (couple_id, sender_id, body, message_type)
                    VALUES (?, ?, ?, 'image')
                ");
                $stmt->execute([$coupleId, $senderId, $url]);
            }
        }

        return $uploadedUrls;
    }

    public function addMixedMessage($coupleId, $senderId, $text = '', $files = [])
    {
        $images = [];
        $voiceUrl = '';

        // 📷 Xử lý ảnh (có thể nhiều)
        if (!empty($files['images']['tmp_name'])) {
            foreach ($files['images']['tmp_name'] as $i => $tmpName) {
                if (!$tmpName) continue;
                $ext = strtolower(pathinfo($files['images']['name'][$i], PATHINFO_EXTENSION));
                $filename = uniqid('img_') . '.' . $ext;
                $target = __DIR__ . '/../../public/uploads/' . $filename;

                if (move_uploaded_file($tmpName, $target)) {
                    $images[] = '/uploads/' . $filename;
                }
            }
        }

        // 🎤 Xử lý voice (1 file)
        if (!empty($files['voice']['tmp_name'])) {
            $ext = strtolower(pathinfo($files['voice']['name'], PATHINFO_EXTENSION));
            $filename = uniqid('voice_') . '.' . $ext;
            $target = __DIR__ . '/../../public/uploads/' . $filename;

            if (move_uploaded_file($files['voice']['tmp_name'], $target)) {
                $voiceUrl = '/uploads/' . $filename;
            }
        }

        // Nếu không có gì cả → return false
        if (!$text && empty($images) && !$voiceUrl) return false;

        // Chuẩn bị body JSON trước khi insert
        $bodyArray = [
            'text' => $text,
            'images' => $images,
            'voice' => $voiceUrl
        ];
        $body = json_encode($bodyArray, JSON_UNESCAPED_UNICODE);

        // Lưu vào DB
        $stmt = $this->pdo->prepare("
        INSERT INTO messages (couple_id, sender_id, body, message_type)
        VALUES (?, ?, ?, 'mixed')
    ");
        $stmt->execute([$coupleId, $senderId, $body]);

        // Lấy ID vừa insert
        $id = $this->pdo->lastInsertId();

        // Thêm ID vào body và trả về
        $bodyArray['id'] = $id;

        return json_encode($bodyArray, JSON_UNESCAPED_UNICODE);
    }
}
