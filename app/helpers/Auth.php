<?php
class Auth
{
    public static function check()
    {
        if (empty($_SESSION['user_id'])) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
                exit;
            }
            header('Location: ./');
            exit();
        }
        return $_SESSION['user_id'];
    }
}
