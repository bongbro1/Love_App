<?php
require_once __DIR__ . '/../models/MoodModel.php';
class MoodController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MoodModel($this->pdo);
    }

    // API lưu mood
    public function update()
    {
        $mood = $_POST['mood'] ?? null;
        $note = $_POST['note'] ?? null;
        $coupleId = $_SESSION['couple_id'] ?? 1;
        $userId = $_SESSION['user_id'] ?? 1;

        if (!$mood) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mood']);
            return;
        }

        $this->model->saveMood($coupleId, $userId, $mood, $note);
        echo json_encode(['success' => true]);
    }

    // API trả dữ liệu cho biểu đồ
    public function getStats()
    {
        header('Content-Type: application/json; charset=utf-8');
        $coupleId = $_SESSION['couple_id'] ?? 1;

        // Lấy filter từ query string (today/week/month)
        $filter = $_GET['filter'] ?? 'today';

        // --- Lấy tổng hợp cảm xúc ---
        $summary = $this->model->getMoodSummary($coupleId, $filter);

        echo json_encode([
            'summary' => $summary
        ], JSON_UNESCAPED_UNICODE);
    }
}
