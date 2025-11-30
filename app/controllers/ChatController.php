<?php
// app/controllers/ChatController.php
require_once __DIR__ . '/../models/ChatModel.php';

class ChatController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new ChatModel($pdo);
    }

    // Hiển thị trang chat

    public function load()
    {
        // Ví dụ bạn có $couple_id từ session hoặc GET
        $couple_id = $_SESSION['couple_id'] ?? 1; // 1 là mặc định test

        // Lấy tin nhắn từ DB
        $messages = $this->model->getMessages($couple_id, 100);

        // Trả về JSON
        header('Content-Type: application/json');
        echo json_encode($messages);
        exit;
    }

    public function deleteMessage()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Phải POST']);
            return;
        }

        if (empty($_POST['message_id'])) {
            echo json_encode(['success' => false, 'error' => 'Thiếu message_id']);
            return;
        }

        $messageId = intval($_POST['message_id']);
        $userId = $_SESSION['user_id'] ?? 0;

        $success = $this->model->deleteMessageByUser($messageId, $userId);

        echo json_encode([
            'success' => $success,
            'error' => $success ? null : 'Không tìm thấy tin nhắn hoặc không đủ quyền'
        ]);
    }


    // Gửi tin nhắn AJAX
    public function send()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $coupleId = $_SESSION['couple_id'] ?? 0;

        header('Content-Type: application/json');

        // Lấy text từ POST
        $text = trim($_POST['text'] ?? '');

        // Lấy files upload, có thể là images[] hoặc voice
        $files = $_FILES; // $_FILES['images'], $_FILES['voice'], v.v.

        // Kiểm tra nếu không có text, không có ảnh và không có voice
        $noImages = empty($files['images']['tmp_name'] ?? []);
        $noVoice = empty($files['voice']['tmp_name'] ?? []);

        if (!$text && $noImages && $noVoice) {
            echo json_encode(['success' => false, 'message' => 'Tin nhắn rỗng']);
            return;
        }

        // Gọi model để lưu text + images + voice
        $saved = $this->model->addMixedMessage($coupleId, $userId, $text, $files);

        if ($saved) {
            echo json_encode([
                'success' => true,
                'body' => $saved // $saved là JSON body chứa text + images + voice
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lưu tin nhắn thất bại']);
        }
    }

    public function sendImages()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        if (empty($_FILES['images'])) {
            echo json_encode(['success' => false, 'message' => 'No files uploaded']);
            return;
        }

        $urls = $this->model->uploadImages($_SESSION['couple_id'], $_SESSION['user_id'], $_FILES['images']);

        if ($urls) {
            echo json_encode(['success' => true, 'urls' => $urls]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Upload failed']);
        }
    }
}
