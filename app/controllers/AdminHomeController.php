<?php
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/PostModel.php';

class AdminHomeController extends Controller
{
    private $categoryModel;
    private $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new CategoryModel($this->pdo);
        $this->postModel = new PostModel($this->pdo);
    }

    public function index()
    {
        // Thống kê
        $categories = $this->categoryModel->all();
        $posts = $this->postModel->getLatest(5);

        $title = "Dashboard Admin";

        ob_start();
        require __DIR__ . '/../views/admin/home/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/admin/layout/layout.php';
    }
}
