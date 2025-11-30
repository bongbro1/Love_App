<?php
require_once __DIR__ . '/../models/SepayModel.php';

class AdminSepayController
{
    private $sepayModel;

    public function __construct()
    {
        $this->sepayModel = new SepayModel();
    }

    public function index()
    {
        $title = "Sepay Accounts";

        // Lấy danh sách tài khoản từ API (hoặc từ DB nếu bạn cache)
        $accounts = $this->sepayModel->getAccounts();

        ob_start();
        require __DIR__ . '/../views/admin/sepay/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function updateApiKey()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apiKey = $_POST['api_key'] ?? '';
            $this->sepayModel->saveApiKey($apiKey);
            header('Location: /love-app/public/admin/sepay');
            exit;
        }
    }
}
