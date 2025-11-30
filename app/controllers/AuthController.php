<?php
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new AuthModel($pdo);
    }

    // 🔐 Đặt mật khẩu mới (AJAX)
    public function setPassword()
    {
        $userId = $_SESSION['user_id'] ?? $_POST['user_id'] ?? 0;
        $password = $_POST['password'] ?? '';

        if (!$userId || !$password) {
            echo json_encode(['success' => false, 'msg' => 'Thiếu dữ liệu']);
            return;
        }

        $ok = $this->model->setPassword($userId, $password);
        echo json_encode(['success' => $ok]);
    }

    // 🔒 AJAX: kiểm tra mật khẩu
    public function verifyPassword()
    {
        $tagParam = $_POST['tags'] ?? null;
        $password = $_POST['password'] ?? '';
        $userId   = $_SESSION['user_id'] ?? 0;

        if ((!$tagParam && !$userId) || !$password) {
            echo json_encode(['success' => false, 'msg' => 'Thiếu dữ liệu']);
            return;
        }

        $users = [];

        if ($tagParam) {
            // Có thể là 1 hoặc 2 tag, ví dụ "ABC123,DEF456"
            $tagUids = array_map('trim', explode(',', $tagParam));
            $users = $this->model->getUsersByTags($tagUids);
        } elseif ($userId) {
            $user = $this->model->getUserById($userId);
            if ($user) $users = [$user];
        }

        if (!$users || count($users) === 0) {
            echo json_encode(['success' => false, 'msg' => 'Không tìm thấy người dùng']);
            return;
        }

        foreach ($users as $user) {
            if (!empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
                echo json_encode(['success' => true]);
                return;
            }
        }

        echo json_encode(['success' => false, 'msg' => 'Mật khẩu không đúng!']);
    }

    public function hasPassword()
    {
        $tagParam = $_POST['tags'] ?? null;
        $userId   = $_POST['user_id'] ?? 0;

        if (!$tagParam && !$userId) {
            echo json_encode(['success' => false, 'error' => 'Thiếu tag_uid hoặc user_id']);
            return;
        }

        $users = [];

        if ($tagParam) {
            $tagUids = array_map('trim', explode(',', $tagParam));
            $users = $this->model->getUsersByTags($tagUids);
        } elseif ($userId) {
            $user = $this->model->getUserById($userId);
            if ($user) $users = [$user];
        }

        if (!$users || count($users) === 0) {
            echo json_encode(['success' => false, 'error' => 'Không tìm thấy người dùng']);
            return;
        }

        // ✅ Chỉ cần một user có mật khẩu là xem như “đã đặt mật khẩu”
        foreach ($users as $user) {
            if (!empty($user['password_hash'])) {
                echo json_encode(['success' => true, 'hasPassword' => true]);
                return;
            }
        }

        echo json_encode(['success' => true, 'hasPassword' => false]);
    }
}
