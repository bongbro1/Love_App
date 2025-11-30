<?php
class HeartbeatSignalModel
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    // Lưu tín hiệu
    public function send($sender_id, $couple_id, $note = null)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO heartbeat_signals (couple_id, sender_id, note) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$couple_id, $sender_id, $note]);
    }

    // Lấy lần gửi cuối
    public function getLastSignal($sender_id)
    {
        $couple_id = $this->getCoupleIdByUser($sender_id);
        $stmt = $this->db->prepare(
            "SELECT created_at FROM heartbeat_signals WHERE couple_id = ? AND sender_id = ? ORDER BY created_at DESC LIMIT 1"
        );
        $stmt->execute([$couple_id, $sender_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy couple_id của user
    public function getCoupleIdByUser($user_id)
    {
        $stmt = $this->db->prepare(
            "SELECT couple_id FROM couple_members WHERE user_id = ? LIMIT 1"
        );
        $stmt->execute([$user_id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['couple_id'] ?? null;
    }

    public function getLastSignals($couple_id, $limit = 50)
    {
        $stmt = $this->db->prepare("
            SELECT sender_id, created_at 
            FROM heartbeat_signals 
            WHERE couple_id = ? 
            ORDER BY created_at ASC
            LIMIT $limit
        ");
        $stmt->execute([$couple_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastSignalByUser($user_id)
    {
        $stmt = $this->db->prepare(
            "SELECT created_at FROM heartbeat_signals WHERE sender_id = ? ORDER BY created_at DESC LIMIT 1"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
