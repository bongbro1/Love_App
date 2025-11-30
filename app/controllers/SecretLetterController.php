<?php


require_once __DIR__ . '/../models/SecretLetterModel.php';

class SecretLetterController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new SecretLetterModel($pdo);
    }

    /**
     * Gửi thư bí mật mới
     */
    public function send()
    {
        $userId = $_SESSION['user_id'] ?? 0;

        header('Content-Type: application/json');

        $body = trim($_POST['text'] ?? '');
        $unlockAt = $_POST['open_date'] ?? '';

        if (!$userId || !$body || !$unlockAt) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $id = $this->model->addSecretLetter($userId, $body, $unlockAt);

        if ($id) {
            echo json_encode(['success' => true, 'id' => $id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lưu thư thất bại']);
        }
    }

    /**
     * Lấy danh sách thư bí mật
     */
    public function list()
    {
        $userId = $_SESSION['user_id'] ?? 0;

        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            return;
        }

        // model sẽ tự tìm couple_id và lọc thư gần nhất cần hiển thị
        $letter = $this->model->getLatestSecretLetter($userId);

        if ($letter) {
            echo json_encode(['success' => true, 'letter' => $letter]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Chưa có thư bí mật']);
        }
    }


    /**
     * Mở một thư (nếu đủ điều kiện)
     */
    public function open()
    {
        $letterId = $_POST['letter_id'] ?? 0;

        header('Content-Type: application/json');

        if (!$letterId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu ID thư']);
            return;
        }

        $result = $this->model->markAsOpened($letterId);
        echo json_encode($result);
    }


    // video/voice 
    public function sendMedia()
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? 0;
        $unlockAt = $_POST['unlock_at'] ?? '';
        $fileName = $_POST['uploaded_file'] ?? '';
        $type = $_POST['type'] ?? 'media';

        if (!$userId || !$unlockAt || !$fileName) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu gửi media']);
            return;
        }

        // Dữ liệu attachments chuẩn JSON
        $attachments = [
            'file' => '/uploads/' . $fileName,
            'type' => $type,
            'size' => filesize(__DIR__ . '/../../public/uploads/' . $fileName),
            'uploaded_at' => date('Y-m-d H:i:s')
        ];

        $id = $this->model->addSecretMedia($userId, $unlockAt, $attachments);

        if ($id) {
            echo json_encode([
                'success' => true,
                'id' => $id,
                'message' => 'Đã lưu thư video/voice thành công!',
                'attachments' => $attachments
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lưu media thất bại']);
        }
    }


    public function listMedia()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            return;
        }

        $letter = $this->model->getNextAvailableMediaLetter($userId);

        echo json_encode(['success' => true, 'letter' => $letter]);
    }
}
