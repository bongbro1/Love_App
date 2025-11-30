<?php
require_once __DIR__ . '/../models/ChallengeModel.php';

class ChallengeController extends Controller
{
    private $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new ChallengeModel($this->pdo);
    }

    // AJAX: fetch challenge templates
    public function fetchChallenges()
    {
        $data = $this->model->getAllChallenges();
        echo json_encode($data);
    }

    // AJAX: fetch tasks of a challenge instance
    public function fetchTasks()
    {
        $challengeId = $_GET['challenge_id'];
        $data = $this->model->getTasks($challengeId);
        echo json_encode($data);
    }

    // AJAX: start challenge for couple
    public function startChallenge()
    {
        $coupleId = $_SESSION['couple_id'];
        $userId = $_SESSION['user_id'];
        $challengeId = $_POST['challenge_id'];

        $instanceId = $this->model->startChallenge($coupleId, $challengeId, $userId);
        echo json_encode(['success' => true, 'instance_id' => $instanceId]);
    }
    public function completeChallenge()
    {
        $participantId = intval($_POST['participant_id']);

        if (!$participantId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu participant_id']);
            return;
        }

        $result = $this->model->markChallengeCompleted($participantId);

        // Trả luôn kết quả từ model
        echo json_encode($result);
    }

    // AJAX: complete a task
    public function completeTask()
    {
        $taskId = intval($_POST['task_id'] ?? 0);

        if (!$taskId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $result = $this->model->completeTask($taskId);
        echo json_encode($result);
    }

    public function challengeHistory()
    {
        $coupleId = intval($_GET['couple_id'] ?? 0);
        $page = intval($_GET['page'] ?? 1);
        $pageSize = intval($_GET['page_size'] ?? 10);

        if ($page < 1) $page = 1;
        if ($pageSize < 1) $pageSize = 10;

        if (!$coupleId) {
            echo json_encode(['success' => false, 'message' => 'Couple ID không hợp lệ']);
            return;
        }

        // Gọi model với giới hạn phân trang
        $history = $this->model->getChallengeHistoryByCouple($coupleId, $page, $pageSize);

        echo json_encode([
            'success' => true,
            'data' => $history,
            'page' => $page,
            'page_size' => $pageSize
        ]);
    }




    // AJAX: get total LoveScore
    public function totalScore()
    {
        // Ưu tiên lấy từ GET nếu có, fallback sang session
        $coupleId = intval($_GET['couple_id'] ?? ($_SESSION['couple_id'] ?? 0));

        if (!$coupleId) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu couple_id hoặc chưa đăng nhập.'
            ]);
            return;
        }

        $score = $this->model->getTotalScore($coupleId);

        echo json_encode([
            'success' => true,
            'score' => intval($score)
        ]);
    }

    public function addChallengeInstance()
    {
        $coupleId = $_SESSION['couple_id'] ?? null;
        $challengeTitle = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? '';
        $score = intval($_POST['score'] ?? 0);
        $isOffline = isset($_POST['is_offline']) ? intval($_POST['is_offline']) : 1;
        $tasks = isset($_POST['tasks']) ? json_decode($_POST['tasks'], true) : [];

        if (!$coupleId || !$challengeTitle) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        // Gọi model để thêm challenge instance
        $instanceId = $this->model->addChallengeInstance($coupleId, [
            'title' => $challengeTitle,
            'description' => $description,
            'points' => $score,
            'is_offline' => $isOffline,
            'tasks' => $tasks
        ]);

        if ($instanceId) {
            echo json_encode(['success' => true, 'instance_id' => $instanceId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm thử thách']);
        }
    }


    // Lấy chi tiết challenge instance
    public function getChallengeDetail()
    {
        $instanceId = intval($_GET['id'] ?? 0);
        if (!$instanceId) {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;


        $challenge = $this->model->getChallengeDetail($instanceId, $userId);
        if (!$challenge) {
            echo json_encode(['success' => false, 'message' => 'Challenge không tồn tại']);
            return;
        }

        echo json_encode(['success' => true, 'challenge' => $challenge]);
    }
}
