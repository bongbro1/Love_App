<?php
require_once __DIR__ . '/../models/SeoModel.php';

class AdminSeoController extends Controller {

    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SeoModel($this->pdo);
    }

    public function index()
    {
        $data = $this->model->getSeoConfig();
        require_once "../app/views/admin/seo/index.php";
    }

    public function update()
    {
        $payload = [
            'meta_title' => $_POST['meta_title'],
            'meta_description' => $_POST['meta_description'],
            'keywords' => $_POST['keywords'],
            'og_image' => $_POST['og_image'] ?? null,
        ];

        $this->model->updateSeoConfig($payload);

        header("Location: " . BASE_URL . "/admin/seo?success=1");
        exit;
    }
}
