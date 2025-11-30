<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new OrderModel($pdo);
    }

    public function order()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            exit;
        }

        try {
            // Lấy dữ liệu từ POST
            $data = [
                'receiver_name'    => $_POST['receiver_name'] ?? '',
                'receiver_email'   => $_POST['receiver_email'] ?? '',
                'receiver_address' => $_POST['receiver_address'] ?? '',
                'receiver_phone'   => $_POST['receiver_phone'] ?? '',
                'male_name'        => $_POST['male_name'] ?? '',
                'male_dob'         => $_POST['male_dob'] ?? null,
                'female_name'      => $_POST['female_name'] ?? '',
                'female_dob'       => $_POST['female_dob'] ?? null,
                'anniversary'      => $_POST['anniversary'] ?? null
            ];

            if (!$data['male_name'] || !$data['female_name']) {
                throw new Exception('Vui lòng nhập đầy đủ thông tin thẻ nam và nữ');
            }

            // Gọi transaction trong model để tạo user, tag, couple và order
            $result = $this->model->createOrderTransaction($data);

            ob_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Đơn hàng đã được gửi thành công!',
                'order_id' => $result['order_id'],
                'male_tag' => $result['male_tag'],
                'female_tag' => $result['female_tag'],
                'couple_id' => $result['couple_id']
            ]);
            exit;
        } catch (Exception $e) {
            // Nếu có lỗi, trả về thông báo và rollback đã được thực hiện trong model
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
}
