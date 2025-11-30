<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/NFCModel.php';
require_once __DIR__ . '/../helpers/Mailer.php';

class AdminOrderController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new OrderModel($this->pdo);
    }

    public function index()
    {
        require __DIR__ . '/../views/admin/orders/index.php';
    }

    // AJAX filter cho table
    public function filter()
    {
        $status  = $_GET['status'] ?? '';
        $keyword = $_GET['keyword'] ?? '';
        $page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->model->filter($status, $keyword, $page, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'orders' => $result['data'],
            'page' => $page,
            'totalPages' => ceil($result['total'] / $perPage)
        ]);
    }
    // ✅ xuất danh sách đơn chưa in


    public function show($id)
    {
        $title = "Chi tiết đơn hàng #$id";
        $order = $this->model->find($id);

        ob_start();
        require __DIR__ . '/../views/admin/orders/view.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        $result = $this->model->delete($id);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'redirect' => BASE_URL . "/admin/orders?status=success"
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'redirect' => BASE_URL . "/admin/orders?status=error"
            ]);
        }

        exit;
    }
    public function markPrinted()
    {
        // Nhận POST data
        $id = $_POST['id'] ?? null;

        header('Content-Type: application/json; charset=utf-8');

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
            exit;
        }

        $updated = $this->model->markOrderAsPrinted($id);

        if ($updated) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
        }
        exit;
    }

    public function export()
    {
        $orders = $this->model->getUnprintedTagInfo();

        if (empty($orders)) {
            echo "Không có thẻ nào chưa in để xuất.";
            exit;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tiêu đề
        $sheet->setCellValue('A1', 'UID Thẻ');
        $sheet->setCellValue('B1', 'Tên Chủ Thẻ');
        $sheet->setCellValue('C1', 'Giới tính');
        $sheet->setCellValue('D1', 'Ngày sinh');
        $sheet->setCellValue('E1', 'Kỷ niệm');

        // Style cho header
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFC0CB'], // Hồng nhạt
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Đổ dữ liệu
        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue("A$row", $order['tag_uid']);
            $sheet->setCellValue("B$row", $order['name']);
            $sheet->setCellValue("C$row", $order['gender'] === 'male' ? 'Nam' : 'Nữ');
            $sheet->setCellValue("D$row", $order['birthday']);
            $sheet->setCellValue("E$row", $order['anniversary']);
            $row++;
        }

        // Tự động căn rộng cột
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Xuất file .xlsx
        $filename = 'the_chua_in_' . date('Y-m-d_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function bulkMailPage()
    {
        $title = "Gửi Email Hàng Loạt";

        // Lấy danh sách orders để chọn mail
        $orders = $this->model->getAllEmails(); // tự viết model

        require __DIR__ . '/../views/admin/orders/bulk_mail.php';
    }
    public function sendBulkMail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/orders/bulk-mail?status=invalid");
            exit;
        }

        $data = $_POST;

        $subject = $data['subject'] ?? '';
        $message = $data['message'] ?? '';
        $emails  = $data['emails'] ?? [];

        if (empty($subject) || empty($message) || empty($emails)) {
            header("Location: " . BASE_URL . "/admin/orders/bulk-mail?status=error");
            exit;
        }

        foreach ($emails as $email) {
            sendMail($email, $subject, $message);  // tự viết hàm hoặc dùng PHPMailer
        }

        header("Location: " . BASE_URL . "/admin/orders/bulk-mail?status=success");
        exit;
    }
}
