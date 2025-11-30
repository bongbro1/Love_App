<?php

require_once __DIR__ . '/../models/AnniversaryModel.php';

class AnniversaryController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AnniversaryModel($this->pdo);
    }

    // API: Lấy danh sách kỷ niệm
    public function list()
    {
        $coupleId = $_SESSION['couple_id'] ?? 0;

        if (!$coupleId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin couple']);
            return;
        }

        // Lấy page và pageSize từ query params
        $page = intval($_GET['page'] ?? 1);
        $pageSize = intval($_GET['pageSize'] ?? 10);
        if ($page < 1) $page = 1;

        $data = $this->model->getAnniversaries($coupleId, $page, $pageSize);

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    }


    // API: Xem chi tiết 1 kỷ niệm
    public function detail()
    {
        $id = intval($_GET['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu id']);
            return;
        }

        $anniversary = $this->model->getAnniversaryById($id);

        if (!$anniversary) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy kỷ niệm']);
            return;
        }

        echo json_encode(['success' => true, 'data' => $anniversary]);
    }

    // API: Thêm kỷ niệm
    public function add()
    {
        $coupleId = $_SESSION['couple_id'] ?? 0;
        $title    = trim($_POST['title'] ?? '');
        $date     = trim($_POST['date'] ?? '');
        $isRecurring    = isset($_POST['is_recurring']) ? intval($_POST['is_recurring']) : 1;
        $reminderDays   = isset($_POST['reminder_days']) ? intval($_POST['reminder_days']) : 1;

        if (!$coupleId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin couple']);
            return;
        }

        if (!$title || !$date) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ tên và ngày kỷ niệm']);
            return;
        }

        $ok = $this->model->addAnniversary($coupleId, $title, $date, $isRecurring, $reminderDays);

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? "Đã thêm kỷ niệm" : "Thêm thất bại"
        ]);
    }
    public function update()
    {
        $coupleId = $_SESSION['couple_id'] ?? 0;
        $id       = intval($_POST['id'] ?? 0);
        $title    = trim($_POST['title'] ?? '');
        $date     = trim($_POST['date'] ?? '');
        $isRecurring = isset($_POST['isRecurring']) ? intval($_POST['isRecurring']) : 1;
        $reminderDays = isset($_POST['reminderDays']) ? intval($_POST['reminderDays']) : 1;

        if (!$coupleId || !$id || !$title || !$date) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $ok = $this->model->updateAnniversary($id, $coupleId, $title, $date, $isRecurring, $reminderDays);

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Đã cập nhật kỷ niệm' : 'Cập nhật thất bại'
        ]);
    }


    // API: Xóa kỷ niệm
    public function delete()
    {
        $coupleId = $_SESSION['couple_id'] ?? 0;
        $id       = intval($_POST['id'] ?? 0);

        if (!$coupleId || !$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $ok = $this->model->deleteAnniversary($id, $coupleId);

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? "Đã xóa kỷ niệm" : "Không thể xóa kỷ niệm"
        ]);
    }
}
