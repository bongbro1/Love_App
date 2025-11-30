<?php
require_once __DIR__ . '/../models/CheckinModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
if (!defined('QR_ECLEVEL_L')) define('QR_ECLEVEL_L', 0);
if (!defined('QR_ECLEVEL_M')) define('QR_ECLEVEL_M', 1);
if (!defined('QR_ECLEVEL_Q')) define('QR_ECLEVEL_Q', 2);
if (!defined('QR_ECLEVEL_H')) define('QR_ECLEVEL_H', 3);

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class CheckinController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new CheckinModel($pdo);
    }

    public function getCheckinData()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['couple_id'])) {
            echo json_encode(['success' => false, 'msg' => 'Chưa đăng nhập']);
            return;
        }

        $coupleId = $_SESSION['couple_id'];
        $data = [];

        // 🧮 Lấy streak
        $streak = $this->model->getStreak($coupleId);
        $data['streak'] = $streak ? intval($streak['current_streak']) : 0;

        // 📍 Lấy checkin gần nhất
        $latest = $this->model->getLastCheckin($coupleId);
        if ($latest) {
            $data['location_id'] = $latest['location_id'];
            $data['lat'] = $latest['lat'];
            $data['lng'] = $latest['lng'];
        }

        // 🧠 Sinh QR dạng base64 (không lưu file)
        $qrUrl = BASE_URL . "/index.php?action=nfc_scan&tag=" . urlencode("couple_$coupleId");

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 6,
        ]);

        $qr = (new QRCode($options))->render($qrUrl);

        // Nếu chuỗi đã có sẵn prefix thì dùng luôn
        if (strpos($qr, 'data:image/png;base64,') === 0) {
            $data['qr_code_base64'] = $qr;
        }
        // Nếu trả về là thẻ <img> thì tách base64 bên trong
        elseif (strpos($qr, '<img') !== false) {
            if (preg_match('/base64,([^"]+)/', $qr, $matches)) {
                $data['qr_code_base64'] = 'data:image/png;base64,' . $matches[1];
            } else {
                $data['qr_code_base64'] = '';
            }
        }
        // Ngược lại → render trả về binary → encode thủ công
        else {
            $data['qr_code_base64'] = 'data:image/png;base64,' . base64_encode($qr);
        }

        echo json_encode(['success' => true, 'data' => $data]);
    }

    public function submitCheckin()
    {
        header('Content-Type: application/json; charset=utf-8');

        $userId = $_SESSION['user_id'];
        $coupleId = $_SESSION['couple_id'];

        $type = $_POST['type'] ?? 'manual';
        $type = in_array($type, ['manual', 'qr', 'nfc']) ? $type : 'manual';

        $locationId = $_POST['location_id'] ?? null;
        $lat = isset($_POST['lat']) ? floatval($_POST['lat']) : null;
        $lng = isset($_POST['lng']) ? floatval($_POST['lng']) : null;

        $this->model->addCheckin($coupleId, $userId, $locationId, $lat, $lng, $type);
        $streak = $this->model->updateStreak($coupleId);

        echo json_encode([
            'success' => true,
            'streak' => $streak['current_streak'],
            'last_checkin' => date('Y-m-d H:i:s')
        ]);
    }
}
