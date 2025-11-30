<?php
require_once __DIR__ . '/../models/HeartbeatSignalModel.php';
require_once __DIR__ . '/../models/PushSubscriptionModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class HeartbeatController
{
    private $heartbeatModel;
    private $pushModel;

    public function __construct($dbConnection)
    {
        $this->heartbeatModel = new HeartbeatSignalModel($dbConnection);
        $this->pushModel = new PushSubscriptionModel($dbConnection);
    }

    // Xử lý AJAX gửi tín hiệu
    public function send()
    {
        header('Content-Type: application/json');

        $sender_id = $_POST['sender_id'] ?? null;
        $note = $_POST['note'] ?? null;
        if (!$sender_id) {
            echo json_encode(['success' => false, 'message' => 'User chưa login']);
            return;
        }

        // Lấy couple_id từ model
        $couple_id = $this->heartbeatModel->getCoupleIdByUser($sender_id);
        if (!$couple_id) {
            echo json_encode(['success' => false, 'message' => 'User chưa có couple']);
            return;
        }

        if ($this->heartbeatModel->send($sender_id, $couple_id, $note)) {
            $last = $this->heartbeatModel->getLastSignal($sender_id, $couple_id);
            // 🔔 Gửi Web Push cho các đối tác
            $this->sendPushNotification($sender_id, "Nhịp tim mới 💓", "Đối phương vừa gửi một nhịp tim!");
            echo json_encode([
                'success' => true,
                'last_sent' => date('h:i A, d/m/Y', strtotime($last['created_at']))
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gửi thất bại']);
        }
    }


    public function history()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        $couple_id = $this->heartbeatModel->getCoupleIdByUser($user_id);

        if (!$couple_id) {
            echo json_encode(['success' => false]);
            return;
        }

        $signals = $this->heartbeatModel->getLastSignals($couple_id);

        // Lấy lần gửi cuối của user hiện tại
        $last_signal = $this->heartbeatModel->getLastSignalByUser($user_id);

        echo json_encode([
            'success' => true,
            'signals' => $signals,
            'user_id' => $user_id,
            'last_sent' => $last_signal ? date('h:i A, d/m/Y', strtotime($last_signal['created_at'])) : null
        ]);
    }
    public function last_send()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        $couple_id = $this->heartbeatModel->getCoupleIdByUser($user_id);

        if (!$couple_id) {
            echo json_encode(['success' => false]);
            return;
        }

        // Lấy lần gửi cuối của user hiện tại
        $last_signal = $this->heartbeatModel->getLastSignalByUser($user_id);

        echo json_encode([
            'success' => true,
            'last_sent' => $last_signal ? date('h:i A, d/m/Y', strtotime($last_signal['created_at'])) : null
        ]);
    }

    private function sendPushNotification($sender_id, $title, $body)
    {
        $subscriptions = $this->pushModel->getOtherSubscriptions($sender_id);
        $config = include __DIR__ . '/../../config/config.php';

        $auth = [
            'VAPID' => [
                'subject' => $config['vapid']['subject'],
                'publicKey' => $config['vapid']['publicKey'],
                'privateKey' => $config['vapid']['privateKey'],
            ],
        ];

        $webPush = new WebPush($auth);

        foreach ($subscriptions as $row) {
            $sub = Subscription::create(json_decode($row['subscription'], true));
            $webPush->sendOneNotification($sub, json_encode([
                'title' => $title,
                'body' => $body
            ]));
        }
    }



    public function save_subscription()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'User chưa login']);
            return;
        }

        $subscription = $_POST['subscription'] ?? null;
        if (!$subscription) {
            echo json_encode(['success' => false, 'message' => 'No subscription']);
            return;
        }

        // Gọi Model để lưu
        $saved = $this->pushModel->saveSubscription($user_id, $subscription);

        echo json_encode(['success' => (bool)$saved]);
    }
}
