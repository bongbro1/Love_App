<?php
require_once __DIR__ . '/../core/Controller.php';
class PageController extends Controller
{
    public function gioiThieu()
    {
        $this->view('pages/gioi-thieu', [
            'pageTitle' => 'Giới thiệu LoveApp - Kết nối tình yêu bằng công nghệ NFC',
            'pageDescription' => 'Khám phá LoveApp - ứng dụng giúp các cặp đôi kết nối và lưu giữ kỷ niệm qua thẻ NFC hiện đại, bảo mật và tiện lợi.',
            'pageKeywords' => 'LoveApp, ứng dụng tình yêu, NFC couple app, kỷ niệm tình yêu, ứng dụng cặp đôi, bản đồ tình yêu, nhật ký yêu nhau, thử thách tình yêu'
        ], 'public');
    }

    public function yeuGan()
    {
        $this->view('pages/yeu-gan', [
            'pageTitle' => 'Yêu Gần - Tính năng LoveApp cho các cặp đôi gặp nhau thường xuyên',
            'pageDescription' => 'Khám phá tính năng Yêu Gần của LoveApp: check-in NFC, bản đồ tình yêu, album kỷ niệm, thử thách hẹn hò, mini game offline và nhắc ngày đặc biệt.',
            'pageKeywords' => 'yêu gần, LoveApp, ứng dụng cặp đôi, check-in NFC, bản đồ tình yêu, thử thách hẹn hò, mini game tình yêu, nhắc kỷ niệm'
        ], 'public');
    }

    public function yeuXa()
    {
        $this->view('pages/yeu-xa', [
            'pageTitle' => 'Tính năng Yêu Xa - Kết nối tình yêu từ xa an toàn',
            'pageDescription' => 'LoveApp giúp các cặp đôi yêu xa duy trì kết nối với video, voice note, mini game online và nhật ký chung bảo mật tuyệt đối.',
            'pageKeywords' => 'LoveApp yêu xa, couple app, kết nối từ xa, video love, voice message, nhật ký yêu xa'
        ], 'public');
    }

    public function baoMat()
    {
        $this->view('pages/bao-mat', [
            'pageTitle' => 'Bảo Mật & An Toàn - LoveApp',
            'pageDescription' => 'LoveApp bảo vệ tình yêu của bạn bằng công nghệ NFC, mã hóa dữ liệu và vùng riêng tư an toàn tuyệt đối.',
            'pageKeywords' => 'LoveApp, bảo mật, an toàn, mã hóa dữ liệu, NFC, chống XSS, bảo vệ cặp đôi, bảo mật tình yêu'
        ], 'public');
    }

    public function cachSuDung()
    {
        $this->view('pages/cach-su-dung', [
            'pageTitle' => 'Cách sử dụng thẻ NFC LoveCard - Hướng dẫn chi tiết',
            'pageDescription' => 'Hướng dẫn từng bước sử dụng thẻ NFC LoveCard để kích hoạt tài khoản, kết nối với người yêu và khám phá các tính năng đặc biệt của LoveApp.',
            'pageKeywords' => 'LoveCard, cách sử dụng, thẻ NFC, hướng dẫn LoveApp, kích hoạt tài khoản, ứng dụng tình yêu'
        ], 'public');
    }

    public function datMua()
    {
        $this->view('pages/dat-mua', [
            'pageTitle' => 'Đặt mua thẻ NFC LoveCard chính hãng - LoveApp',
            'pageDescription' => 'Mua ngay thẻ NFC LoveCard để kích hoạt không gian riêng cho hai bạn trên LoveApp. Chính hãng, bảo mật và giao nhanh toàn quốc.',
            'pageKeywords' => 'LoveCard, đặt mua, NFC card, LoveApp, thẻ tình yêu, thẻ couple, quà tặng cho người yêu'
        ], 'public');
    }

    public function baiViet()
    {
        $this->view('blog/index', [
            'pageTitle' => 'Blog LoveApp - Mẹo & Câu Chuyện Tình Yêu Công Nghệ',
            'pageDescription' => 'Khám phá những bài viết thú vị về tình yêu, công nghệ NFC, và mẹo giúp các cặp đôi gắn kết hơn với LoveApp.',
            'pageKeywords' => 'LoveApp blog, bài viết tình yêu, mẹo cặp đôi, ứng dụng NFC, yêu xa, yêu gần'
        ], 'public');
    }
}
