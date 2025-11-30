<?php
class LoveMapModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Lấy tất cả điểm trên Love Map của 1 couple
     */
    public function getPointsByCouple($coupleId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            t.id,
            t.lng,
            t.lat,
            t.label,
            t.created_at
        FROM (
            SELECT 
                p.id,
                ST_X(p.position) AS lng,
                ST_Y(p.position) AS lat,
                p.label,
                p.created_at,
                ROW_NUMBER() OVER (
                    PARTITION BY ST_X(p.position), ST_Y(p.position)
                    ORDER BY (p.label IS NULL OR p.label = ''), p.created_at DESC
                ) AS rn
            FROM love_map_points p
            WHERE p.couple_id = :couple_id
        ) AS t
        WHERE t.rn = 1
        ORDER BY t.created_at DESC
    ");

        $stmt->execute(['couple_id' => $coupleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm điểm mới
    public function addPoint($coupleId, $lat, $lng, $label = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO love_map_points (couple_id, position, label)
            VALUES (:couple_id, ST_GeomFromText(:point), :label)
        ");
        $pointWKT = "POINT($lng $lat)"; // Lưu POINT(longitude latitude)
        $stmt->execute([
            'couple_id' => $coupleId,
            'point' => $pointWKT,
            'label' => $label
        ]);
        return $this->db->lastInsertId();
    }
}
