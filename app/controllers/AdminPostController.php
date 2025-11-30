<?php
// app/controllers/AdminPostController.php

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class AdminPostController extends Controller
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new PostModel($this->pdo);
        $this->categoryModel = new CategoryModel($this->pdo);
    }

    // Hiển thị danh sách bài viết
    public function index()
    {
        $keyword = $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;

        $result = $this->postModel->getAllWithCategory($keyword, $category, $page, $perPage);
        $posts = $result['posts'];
        $totalPosts = $result['total'];
        $totalPages = ceil($totalPosts / $perPage);

        $categories = $this->categoryModel->all();
        require __DIR__ . '/../views/admin/posts/index.php';
    }


    public function filter()
    {
        $keyword = $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;

        $result = $this->postModel->getAllWithCategory($keyword, $category, $page, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'posts' => $result['posts'],
            'total' => $result['total'],
            'page' => $page,
            'perPage' => $perPage
        ]);
        exit;
    }



    // Form tạo bài viết mới
    public function create()
    {
        $categories = $this->categoryModel->all();
        require __DIR__ . '/../views/admin/posts/create.php';
    }

    // Lưu bài viết mới
    public function store()
    {
        $data = $_POST;
        $thumbnail = $this->handleImageUpload("thumbnail");

        $data['thumbnail'] = $thumbnail;

        // slug rỗng → tạo mới
        if (empty($data['slug'])) {
            $data['slug'] = slugify($data['title']);
        }

        $result = $this->postModel->create($data);
        if ($result) {
            header("Location:" . BASE_URL . "/admin/posts?status=success");
        } else {
            header("Location:" . BASE_URL . "/admin/posts?status=error");
        }
        exit;
    }

    // Form chỉnh sửa — nhận ID từ Router
    public function edit($id = null)
    {
        if (!$id) {
            $id = $_GET['id'] ?? null;
        }

        if (!$id) {
            die("ID không hợp lệ");
        }

        $post = $this->postModel->find($id);
        if (!$post) {
            die("Bài viết không tồn tại");
        }

        // Nếu POST → update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $thumbnail = $this->handleImageUpload("thumbnail", $post['thumbnail']);

            $data = [
                'title' => trim($_POST['title']),
                'slug' => trim($_POST['slug']),
                'excerpt' => $_POST['excerpt'] ?? '',
                'content' => $_POST['content'] ?? '',
                'thumbnail' => $thumbnail,
                'read_time' => $_POST['read_time'] ?? '',
                'post_date' => $_POST['post_date'] ?? '',
                'category_id' => $_POST['category_id'] ?? '',
                'meta_title' => $_POST['meta_title'] ?? '',
                'meta_description' => $_POST['meta_description'] ?? '',
                'meta_keywords' => $_POST['meta_keywords'] ?? '',
                'status' => $_POST['status'] ?? 'draft'
            ];

            if (empty($data['slug'])) {
                $data['slug'] = slugify($data['title']);
            }

            $result = $this->postModel->update($id, $data);

            if ($result) {
                header("Location:" . BASE_URL . "/admin/posts?status=success");
            } else {
                header("Location:" . BASE_URL . "/admin/posts?status=error");
            }
            exit;
        }

        // GET → load form edit
        $categories = $this->categoryModel->all();
        require __DIR__ . '/../views/admin/posts/edit.php';
    }

    public function delete($id)
    {
        $result = $this->postModel->delete($id);

        if ($result) {
            header("Location:" . BASE_URL . "/admin/posts?status=success");
        } else {
            header("Location:" . BASE_URL . "/admin/posts?status=error");
        }
        exit;
    }

    private function handleImageUpload($fileInputName, $oldFile = null)
    {
        if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== 0) {
            return $oldFile; // ko upload -> giữ ảnh cũ hoặc null
        }

        // Tạo tên file mới tránh trùng
        $fileName = time() . "_" . basename($_FILES[$fileInputName]['name']);
        $uploadDir = __DIR__ . "/../../public/uploads/posts/";
        $uploadPath = $uploadDir . $fileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Di chuyển file upload
        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploadPath)) {

            // Xóa ảnh cũ nếu có
            if ($oldFile && file_exists(__DIR__ . "/../../public" . $oldFile)) {
                unlink(__DIR__ . "/../../public" . $oldFile);
            }

            return "/uploads/posts/" . $fileName;
        }

        return $oldFile; // Lỗi → giữ ảnh cũ
    }
}
