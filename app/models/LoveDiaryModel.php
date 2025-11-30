<?php
class LoveDiaryModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy nhật ký của cặp đôi, có thể filter theo thời gian
    public function getEntries($coupleId, $period = 'all')
    {
        $sql = "SELECT d.*, u.display_name AS author_name
            FROM love_diaries d
            JOIN users u ON d.author_id = u.id
            WHERE d.couple_id = :couple_id
              AND (d.visibility = 'both' OR d.author_id = :user_id)";

        $params = [
            ':couple_id' => $coupleId,
            ':user_id' => $_SESSION['user_id']
        ];

        if ($period === 'today') {
            $sql .= " AND DATE(d.created_at) = CURDATE()";
        } elseif ($period === 'week') {
            $sql .= " AND YEARWEEK(d.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        } elseif ($period === 'month') {
            $sql .= " AND MONTH(d.created_at) = MONTH(CURDATE())
                  AND YEAR(d.created_at) = YEAR(CURDATE())";
        }

        $sql .= " ORDER BY d.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lưu nhật ký mới
    public function saveEntry($coupleId, $authorId, $title, $content, $visibility = 'both')
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO love_diaries (couple_id, author_id, title, content, visibility)
            VALUES (:couple_id, :author_id, :title, :content, :visibility)
        ");
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':author_id' => $authorId,
            ':title' => $title,
            ':content' => $content,
            ':visibility' => $visibility
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getEntryById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM love_diaries WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEntry($id, $title, $content)
    {
        $stmt = $this->pdo->prepare("UPDATE love_diaries SET title = :title, content = :content WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':content' => $content
        ]);
    }

    public function deleteEntry($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM love_diaries WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
