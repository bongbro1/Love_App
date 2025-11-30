<?php
require_once __DIR__ . '/../models/LoveDiaryModel.php';

class LoveDiaryController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new LoveDiaryModel($this->pdo);
    }

    // View page diary
    public function index()
    {
        require __DIR__ . '/../views/diary.php';
    }

    // API: load entries
    public function load()
    {
        header('Content-Type: application/json; charset=utf-8');
        $coupleId = $_SESSION['couple_id'];
        $period = $_GET['period'] ?? 'all';

        $entries = $this->model->getEntries($coupleId, $period);
        echo json_encode($entries, JSON_UNESCAPED_UNICODE);
    }

    // API: save entry
    public function save()
    {
        header('Content-Type: application/json; charset=utf-8');
        $coupleId = $_SESSION['couple_id'];
        $authorId = $_SESSION['user_id'];
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? '';
        $visibility = $_POST['visibility'] ?? 'both';

        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Nội dung không được để trống']);
            return;
        }

        $this->model->saveEntry($coupleId, $authorId, $title, $content, $visibility);
        echo json_encode(['success' => true]);
    }

    // === Cập nhật nhật ký ===
    public function update()
    {
        header('Content-Type: application/json; charset=utf-8');
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            return;
        }

        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if (!$id || !$content) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        // Kiểm tra quyền
        $entry = $this->model->getEntryById($id);
        if (!$entry || $entry['author_id'] != $userId) {
            echo json_encode(['success' => false, 'message' => 'Không có quyền chỉnh sửa']);
            return;
        }

        $success = $this->model->updateEntry($id, $title, $content);
        echo json_encode(['success' => $success]);
    }

    // === Xóa nhật ký ===
    public function delete()
    {
        header('Content-Type: application/json; charset=utf-8');
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu ID']);
            return;
        }

        // Kiểm tra quyền
        $entry = $this->model->getEntryById($id);
        if (!$entry || $entry['author_id'] != $userId) {
            echo json_encode(['success' => false, 'message' => 'Không có quyền xóa']);
            return;
        }

        $success = $this->model->deleteEntry($id);
        echo json_encode(['success' => $success]);
    }
}
