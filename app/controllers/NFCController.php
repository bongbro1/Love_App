<?php
// app/controllers/NFCController.php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../models/NFCModel.php';
require_once __DIR__ . '/../models/CheckinModel.php';
require_once __DIR__ . '/../models/LoveMapModel.php';

class NFCController
{
    private $model;
    private $checkinModel;
    private $loveMapModel;
    public function __construct($pdo)
    {
        $this->model = new NFCModel($pdo);
        $this->checkinModel = new CheckinModel($pdo);
        $this->loveMapModel = new LoveMapModel($pdo);
    }


    function getFirstName($fullName)
    {
        $parts = preg_split('/\s+/', trim($fullName));
        return end($parts);
    }

    public function scan()
    {

        $config = require __DIR__ . '/../../config/config.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $tagsParam = $_GET['tag'] ?? ($input['tag'] ?? '');
        $location = $_GET['location'] ?? ($input['location'] ?? null);
        $locationName = $_GET['location_name'] ?? ($input['location_name'] ?? null);

        // phân tách danh sách tag
        $tags = array_filter(array_map('trim', explode(',', $tagsParam)));
        if (!$tags) {
            echo json_encode(['success' => false, 'message' => 'Không có tag hợp lệ']);
            return;
        }

        // Ghi log tất cả
        foreach ($tags as $t) $this->model->logScan($t, $location, $locationName);

        if (count($tags) === 1) {
            $tag = $tags[0];
            $tagInfo = $this->model->getTagByUid($tag);
            if (!$tagInfo) {
                echo json_encode(['success' => false, 'reason' => 'unknown_tag', 'message' => 'Thẻ chưa đăng ký']);
                return;
            }

            $user = $this->model->findUserByTag($tag);
            if (!$user) {
                echo json_encode(['success' => false, 'reason' => 'not_linked', 'message' => 'Thẻ chưa liên kết người dùng']);
                return;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['user_full_name'] = $user['display_name'];
            $_SESSION['couple_id'] = $tagInfo['couple_id'];

            header("Location: " . $config['redirects']['longdistance']);
            return;
        }

        // Nếu 2 thẻ — chỉ kiểm tra cùng couple hay không
        if (count($tags) === 2) {
            $tag1 = $this->model->getTagByUid($tags[0]);
            $tag2 = $this->model->getTagByUid($tags[1]);

            if (!$tag1 || !$tag2) {
                echo json_encode(['success' => false, 'reason' => 'invalid_tag', 'message' => 'Một trong hai thẻ không hợp lệ']);
                return;
            }

            if (empty($tag1['couple_id']) || empty($tag2['couple_id'])) {
                echo json_encode(['success' => false, 'reason' => 'unpaired', 'message' => 'Một trong hai thẻ chưa thuộc cặp nào']);
                return;
            }

            if ($tag1['couple_id'] !== $tag2['couple_id']) {
                echo json_encode(['success' => false, 'reason' => 'mismatch', 'message' => 'Hai thẻ không thuộc cùng một cặp']);
                return;
            }
            $coupleId = $tag1['couple_id'];

            // --- Lấy thông tin user tương ứng từng thẻ ---
            $user1 = $this->model->findUserByTag($tags[0]);
            $user2 = $this->model->findUserByTag($tags[1]);

            if (!$user1 || !$user2) {
                echo json_encode(['success' => false, 'reason' => 'not_linked', 'message' => 'Một trong hai thẻ chưa liên kết người dùng']);
                return;
            }

            // --- Set session cho user 1 (hoặc lưu cả couple tuỳ logic) ---
            $_SESSION['user_id'] = $user1['id'];
            $_SESSION['gender'] = $user1['gender'];
            $_SESSION['couple_id'] = $coupleId;
            $name1 = $this->getFirstName($user1['display_name']);
            $name2 = $this->getFirstName($user2['display_name']);

            $_SESSION['user_full_name'] = "{$name1} & {$name2}";

            // --- Tách tọa độ từ location nếu có ---
            $lat = $lng = null;
            $locationId = null; // Nếu chưa dùng bảng locations
            if (!empty($location)) {
                $coords = explode(',', $location);
                if (count($coords) === 2) {
                    $lat = floatval(trim($coords[0]));
                    $lng = floatval(trim($coords[1]));
                }
            }
            $locationName = $_GET['location_name'] ?? null;
            $locationId = null;

            if ($lat !== null && $lng !== null) {
                $locationId = $this->checkinModel->addLocation($coupleId, $lat, $lng, $locationName);
            }

            // Thêm checkin cho cả 2 user
            $this->checkinModel->addCheckin($coupleId, $user1['id'], $locationId, $lat, $lng, 'nfc');
            $this->checkinModel->addCheckin($coupleId, $user2['id'], $locationId, $lat, $lng, 'nfc');

            if ($lat !== null && $lng !== null) {
                $this->loveMapModel->addPoint(
                    $coupleId,
                    $lat,
                    $lng,
                    $locationName
                );
            }
            // Cập nhật streak cho couple
            $this->checkinModel->updateStreak($coupleId);

            header("Location: " . $config['redirects']['nearlove']);
            return;
        }

        echo json_encode(['success' => false, 'message' => 'Quét quá nhiều thẻ cùng lúc']);
    }
}
