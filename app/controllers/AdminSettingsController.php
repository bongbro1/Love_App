<?php
require_once __DIR__ . '/../models/SettingsModel.php';

class AdminSettingsController extends Controller {

    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SettingsModel($this->pdo);
    }

    public function index()
    {
        $data = $this->model->getSettings();
        require_once "../app/views/admin/settings/index.php";
    }

    public function update()
    {
        $this->model->updateSettings([
            'site_name' => $_POST['site_name'],
            'contact_email' => $_POST['contact_email'],
            'hotline' => $_POST['hotline'],
            'address' => $_POST['address'],
        ]);

        header("Location:" . BASE_URL . "/admin/settings?success=1");
        exit;
    }
}
