<?php

class AnniversaryModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAnniversaries($coupleId, $page = 1, $pageSize = 10)
    {
        $offset = ($page - 1) * $pageSize;

        $stmt = $this->db->prepare("
        SELECT *
        FROM anniversaries
        WHERE couple_id = :cid
        ORDER BY date ASC
        LIMIT :limit OFFSET :offset
    ");

        // Với LIMIT/OFFSET phải bindValue và dùng PDO::PARAM_INT
        $stmt->bindValue(':cid', $coupleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy 1 kỷ niệm theo id (dùng khi xem chi tiết)
    public function getAnniversaryById($id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM anniversaries
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm kỷ niệm mới
    public function addAnniversary($coupleId, $title, $date, $isRecurring = 1, $reminderDays = 1)
    {
        $stmt = $this->db->prepare("
            INSERT INTO anniversaries (couple_id, title, date, is_recurring, reminder_days_before)
            VALUES (:cid, :title, :date, :recurring, :reminder)
        ");
        return $stmt->execute([
            'cid' => $coupleId,
            'title' => $title,
            'date' => $date,
            'recurring' => $isRecurring,
            'reminder' => $reminderDays
        ]);
    }

    public function updateAnniversary($id, $coupleId, $title, $date, $isRecurring, $reminderDays)
    {
        $stmt = $this->db->prepare("
        UPDATE anniversaries
        SET title = :title, 
            date = :date,
            is_recurring = :recurring,
            reminder_days_before = :reminder
        WHERE id = :id AND couple_id = :cid
    ");

        return $stmt->execute([
            'title'     => $title,
            'date'      => $date,
            'recurring' => $isRecurring,
            'reminder'  => $reminderDays,
            'id'        => $id,
            'cid'       => $coupleId
        ]);
    }

    // Xóa kỷ niệm theo id và couple_id
    public function deleteAnniversary($id, $coupleId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM anniversaries
            WHERE id = :id AND couple_id = :cid
        ");
        return $stmt->execute([
            'id' => $id,
            'cid' => $coupleId
        ]);
    }
}
