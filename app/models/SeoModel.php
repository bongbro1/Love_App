<?php

class SeoModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getSeoConfig()
    {
        $stmt = $this->db->query("SELECT * FROM seo_config LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSeoConfig($data)
    {
        $stmt = $this->db->prepare("
            UPDATE seo_config SET 
                meta_title = :meta_title,
                meta_description = :meta_description,
                keywords = :keywords,
                og_image = :og_image
            WHERE id = 1
        ");

        return $stmt->execute($data);
    }
}
