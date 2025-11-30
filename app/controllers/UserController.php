<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController extends Controller
{
    private $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel($this->pdo);
    }

    // ✅ Trang hiển thị thông tin cá nhân (cả 2 người trong cặp)
    public function showProfile()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->model->getUserById($userId);
        $partner = $this->model->getPartnerByUser($userId);

        $defaultAvatar = BASE_URL . '/images/default-avatar.png';

        // Chuẩn hóa đường dẫn avatar cho user
        if (empty($user['avatar_url'])) {
            $user['avatar_url'] = $defaultAvatar;
        } else {
            if (!preg_match('/^https?:\/\//', $user['avatar_url'])) {
                $user['avatar_url'] = BASE_URL . '/' . ltrim($user['avatar_url'], '/');
            }
        }

        // Chuẩn hóa đường dẫn avatar cho partner
        if (!empty($partner)) {
            if (empty($partner['avatar_url'])) {
                $partner['avatar_url'] = $defaultAvatar;
            } else {
                if (!preg_match('/^https?:\/\//', $partner['avatar_url'])) {
                    $partner['avatar_url'] = BASE_URL . '/' . ltrim($partner['avatar_url'], '/');
                }
            }
        }

        // Map giới tính
        $genderMap = [
            'male' => 'Nam',
            'female' => 'Nữ',
            'other' => 'Khác'
        ];

        if (!empty($partner['gender'])) {
            $partner['gender'] = $genderMap[$partner['gender']] ?? 'Khác';
        } else {
            $partner['gender'] = 'Khác';
        }

        $title = "Thông tin cá nhân";

        $viewPath = __DIR__ . '/../views/user/profile.php';
        require __DIR__ . '/../views/layout/private/index.php';
    }


    // ✅ Trang đổi mật khẩu
    public function showChangePassword()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $title = "Đổi mật khẩu";

        $viewPath = __DIR__ . '/../views/user/change_password.php';
        require __DIR__ . '/../views/layout/private/index.php';
    }

    // ✅ Xử lý đổi mật khẩu (AJAX)
    public function updatePassword()
    {
        header('Content-Type: application/json');
        if (empty($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'msg' => 'Chưa đăng nhập']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';

        if (strlen($new) < 6) {
            echo json_encode(['success' => false, 'msg' => 'Mật khẩu mới phải ít nhất 6 ký tự!']);
            return;
        }
        $user = $this->model->getUserById($userId);

        if (!$user || !password_verify($old, $user['password_hash'])) {
            echo json_encode(['success' => false, 'msg' => 'Mật khẩu cũ không đúng!']);
            return;
        }

        $this->model->updatePassword($userId, $new);
        echo json_encode(['success' => true, 'msg' => 'Đổi mật khẩu thành công!']);
    }

    // ✅ Trang cài đặt bảo mật
    public function showSecuritySettings()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $title = "Cài đặt";

        $viewPath = __DIR__ . '/../views/user/security_settings.php';
        require __DIR__ . '/../views/layout/private/index.php';
    }

    // ✅ Đăng xuất
    public function logout()
    {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }

    public function updateProfile()
    {
        header('Content-Type: application/json');

        if (empty($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'msg' => 'Bạn chưa đăng nhập!']);
            exit;
        }

        $userId = $_SESSION['user_id'];
        $display_name = trim($_POST['display_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $dob = $_POST['dob'] ?? null;
        $gender = $_POST['gender'] ?? 'other';
        $timezone = $_POST['timezone'] ?? 'Asia/Bangkok';

        $avatar_url = null;

        // Xử lý upload avatar
        if (!empty($_FILES['avatar']['name'])) {
            $file = $_FILES['avatar'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                echo json_encode(['success' => false, 'msg' => 'Chỉ chấp nhận ảnh JPG, PNG, GIF']);
                exit;
            }

            $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $fileName = uniqid('avatar_') . '.' . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $avatar_url = 'uploads/avatars/' . $fileName;
            } else {
                echo json_encode(['success' => false, 'msg' => 'Upload avatar thất bại!']);
                exit;
            }
        }

        // Cập nhật vào DB
        $update = $this->model->updateProfile($userId, [
            'display_name' => $display_name,
            'email'        => $email,
            'dob'          => $dob,
            'gender'       => $gender,
            'avatar_url'   => $avatar_url
        ]);


        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Cập nhật thông tin thất bại!']);
        }
    }
}
