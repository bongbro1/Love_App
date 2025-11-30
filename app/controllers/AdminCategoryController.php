<?php
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../helpers/helpers.php';

class AdminCategoryController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CategoryModel($this->pdo);
    }

    public function index()
    {
        // Lấy param từ query string
        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;

        // Gọi model lấy danh mục theo search + phân trang
        $result = $this->model->getAll($keyword, $page, $perPage);
        $categories = $result['categories'];
        $totalCategories = $result['total'];
        $totalPages = ceil($totalCategories / $perPage);

        // Nếu là request AJAX trả JSON
        if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($result);
            exit;
        }

        // Nếu request bình thường, render page
        require __DIR__ . '/../views/admin/categories/index.php';
    }

    public function filter()
    {
        $keyword = $_GET['keyword'] ?? '';
        $page = $_GET['page'] ?? 1;
        $perPage = 10;

        $result = $this->model->getAll($keyword, $page, $perPage);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }


    public function create()
    {
        // Kiểm tra AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            $color = $_POST['color'] ?? 'pink';

            if (empty($slug)) {
                $slug = slugify($name);
            }

            $data = [
                'name' => $name,
                'slug' => $slug,
                'color' => $color
            ];

            try {
                $this->model->create($data);
                echo json_encode(['status' => 'success', 'message' => 'Thêm danh mục thành công!']);
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
            }
            exit;
        }

        // Nếu load trang bình thường
        require __DIR__ . '/../views/admin/categories/create.php';
    }



    public function edit($id = null)
    {
        // Nếu $id chưa có (router dùng query string)
        if (!$id) {
            $id = $_GET['id'] ?? null;
        }

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
            exit;
        }

        // Lấy category từ DB
        $category = $this->model->find($id);
        if (!$category) {
            echo json_encode(['status' => 'error', 'message' => 'Category không tồn tại']);
            exit;
        }

        // Xử lý POST từ Ajax
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            $color = $_POST['color'] ?? 'pink';

            if (empty($slug)) {
                $slug = slugify($name);
            }

            $data = [
                'name' => $name,
                'slug' => $slug,
                'color' => $color
            ];

            try {
                $this->model->update($id, $data);
                echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        // Nếu GET, hiển thị form edit
        require __DIR__ . '/../views/admin/categories/edit.php';
    }


    public function delete($id)
    {
        $result = $this->model->delete($id);

        if ($result) {
            header("Location: " . BASE_URL . "/admin/categories?status=success");
        } else {
            header("Location: " . BASE_URL . "/admin/categories?status=error");
        }

        exit;
    }
}
