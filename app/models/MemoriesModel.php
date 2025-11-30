<?php
class MemoriesModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getMemoriesByCouple($coupleId)
    {
        $stmt = $this->db->prepare("
        SELECT m.id, m.title, m.description, m.event_date,
               GROUP_CONCAT(p.media_url) AS media_urls
        FROM memories m
        LEFT JOIN memory_photos p ON p.memory_id = m.id
        WHERE m.couple_id = :couple_id
        GROUP BY m.id
        ORDER BY m.event_date DESC, m.created_at DESC
    ");
        $stmt->execute(['couple_id' => $coupleId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Chuyển media_urls từ string -> array
        foreach ($rows as &$row) {
            $row['media_urls'] = $row['media_urls'] ? explode(',', $row['media_urls']) : [];
        }

        return $rows;
    }


    public function addMemory($coupleId, $userId, $title, $description, $eventDate)
    {
        $stmt = $this->db->prepare("
            INSERT INTO memories (couple_id, created_by, title, description, event_date)
            VALUES (:couple_id, :created_by, :title, :description, :event_date)
        ");
        $stmt->execute([
            'couple_id'   => $coupleId,
            'created_by'  => $userId,
            'title'       => $title,
            'description' => $description,
            'event_date'  => $eventDate
        ]);

        return $this->db->lastInsertId();
    }


    public function addPhoto($memoryId, $userId, $url, $caption = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO memory_photos (memory_id, uploaded_by, media_url, caption)
            VALUES (:memory_id, :uploaded_by, :media_url, :caption)
        ");
        $stmt->execute([
            'memory_id' => $memoryId,
            'uploaded_by' => $userId,
            'media_url' => $url,
            'caption' => $caption
        ]);
        return true;
    }
}
