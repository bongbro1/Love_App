<?php
function handleChunkUpload() {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $tempDir = __DIR__ . '/../../public/uploads_temp/';
    $uploadDir = __DIR__ . '/../../public/uploads/';

    // Tạo thư mục nếu chưa có
    if (!file_exists($tempDir)) mkdir($tempDir, 0777, true);
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    // Lấy thông tin chunk
    $fileName = $_POST['file_name'] ?? 'unknown';
    $chunkIndex = intval($_POST['chunk_index'] ?? 0);
    $totalChunks = intval($_POST['total_chunks'] ?? 1);

    if (!isset($_FILES['file']['tmp_name'])) {
        return ['success' => false, 'message' => 'Không nhận được file'];
    }

    // Lưu file chunk tạm
    $chunkPath = $tempDir . $fileName . "_part" . $chunkIndex;
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $chunkPath)) {
        return ['success' => false, 'message' => 'Không thể lưu file chunk'];
    }

    // Nếu đã nhận đủ tất cả chunk thì ghép lại
    if ($chunkIndex + 1 === $totalChunks) {
        $finalPath = $uploadDir . $fileName;
        $out = fopen($finalPath, 'wb');

        for ($i = 0; $i < $totalChunks; $i++) {
            $part = $tempDir . $fileName . "_part" . $i;
            if (!file_exists($part)) {
                return ['success' => false, 'message' => "Thiếu chunk $i, upload lỗi"];
            }
            $in = fopen($part, 'rb');
            stream_copy_to_stream($in, $out);
            fclose($in);
            unlink($part); // xóa file tạm
        }

        fclose($out);

        // ✅ Trả về kết quả (không echo ở đây)
        return [
            'success' => true,
            'message' => 'Upload hoàn tất',
            'file' => $fileName
        ];
    }

    // Nếu chưa phải chunk cuối
    return [
        'success' => true,
        'message' => "Đã nhận chunk $chunkIndex"
    ];
}
