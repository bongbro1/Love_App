<?php

class SettingsModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getSettings()
    {
        return $this->db->query("SELECT * FROM settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSettings($data)
    {
        $stmt = $this->db->prepare("
            UPDATE settings SET 
                site_name = :site_name,
                contact_email = :contact_email,
                hotline = :hotline,
                address = :address
            WHERE id = 1
        ");

        return $stmt->execute($data);
    }
}
