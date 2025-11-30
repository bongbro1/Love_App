<?php
require_once __DIR__ . '/../models/MemoriesModel.php';

class MemoriesController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new MemoriesModel($db);
    }

    public function fetchMemories()
    {
        if (!isset($_SESSION['couple_id'])) {
            echo json_encode(['success' => false, 'msg' => 'Chưa đăng nhập']);
            return;
        }

        $coupleId = $_SESSION['couple_id'];
        $memories = $this->model->getMemoriesByCouple($coupleId);

        echo json_encode(['success' => true, 'memories' => $memories]);
    }

    public function upload()
    {
        if (!isset($_SESSION['couple_id'], $_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'msg' => 'Chưa đăng nhập']);
            return;
        }

        $coupleId = $_SESSION['couple_id'];
        $userId = $_SESSION['user_id'];

        $title = $_POST['title'];
        $description = $_POST['description'];
        $eventDate = $_POST['event_date'] ?? date('Y-m-d');

        // Kiểm tra file
        if (!isset($_FILES['photos'])) {
            echo json_encode(['success' => false, 'msg' => 'Chưa chọn ảnh']);
            return;
        }

        $files = $_FILES['photos'];
        $uploadDir = 'uploads/memories/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Thêm kỷ niệm
        $memoryId = $this->model->addMemory($coupleId, $userId, $title, $description, $eventDate);

        foreach ($files['tmp_name'] as $key => $tmpName) {
            if ($tmpName === '') continue;

            $fileName = uniqid() . '_' . basename($files['name'][$key]);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $this->model->addPhoto($memoryId, $userId, $targetPath);
            }
        }

        echo json_encode(['success' => true, 'msg' => 'Thêm ảnh thành công!']);
    }
}
