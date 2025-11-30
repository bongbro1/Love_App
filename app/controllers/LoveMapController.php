<?php
require_once __DIR__ . '/../models/LoveMapModel.php';

class LoveMapController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new LoveMapModel($this->pdo);
    }

    /**
     * API lấy điểm Love Map JSON
     */
    public function fetchPoints() {
        $coupleId = $_SESSION['couple_id'] ?? null;
        if (!$coupleId) {
            echo json_encode(['success' => false, 'message' => 'Chưa xác định cặp đôi']);
            return;
        }

        $points = $this->model->getPointsByCouple($coupleId);
        echo json_encode(['success' => true, 'points' => $points]);
    }

    /**
     * Trang hiển thị bản đồ
     */
    public function showPage() {
        include __DIR__ . '/../views/lovemap_view.php';
    }
}
