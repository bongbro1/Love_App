<?php
class PushSubscriptionModel
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    // Lưu subscription (hoặc update nếu user đã có)
    public function saveSubscription($user_id, $subscription_json)
    {
        $stmt = $this->db->prepare("
            REPLACE INTO push_subscriptions (user_id, subscription) VALUES (?, ?)
        ");
        return $stmt->execute([$user_id, $subscription_json]);
    }

    // Lấy tất cả subscription của người khác (không bao gồm sender)
    public function getOtherSubscriptions($sender_id)
    {
        $stmt = $this->db->prepare("
            SELECT subscription FROM push_subscriptions WHERE user_id != ?
        ");
        $stmt->execute([$sender_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
