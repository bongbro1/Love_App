<?php
require_once __DIR__ . '/../helpers/Auth.php';

class LongDistanceController extends Controller
{
    /**
     * Helper để chuẩn bị dữ liệu render view
     */
    private function renderPageData($file, $title)
    {
        $userId = Auth::check(); // đảm bảo user đã login

        return [
            'viewPath'  => "longdistance/{$file}",
            'pageTitle' => $title,
            'mode'      => 'longdistance'
        ];
    }

    public function chat()
    {
        $data = $this->renderPageData('chat', 'Chat Tình Yêu');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function secretLetter()
    {
        $data = $this->renderPageData('secretletter', 'Thư Bí Mật');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function heartbeat()
    {
        $data = $this->renderPageData('heartbeat', 'Dấu Hiệu Tim');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function moodTracker()
    {
        $data = $this->renderPageData('moodtracker', 'Theo Dõi Tâm Trạng');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function diary()
    {
        $data = $this->renderPageData('diary', 'Nhật Ký Tình Yêu');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function challenges()
    {
        $data = $this->renderPageData('challenges', 'Thử Thách Tình Yêu');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function minigame()
    {
        $data = $this->renderPageData('minigame', 'Mini Game Online');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function videoReminder()
    {
        $data = $this->renderPageData('videoreminder', 'Nhắc Nhở Video/Voice');
        $this->view($data['viewPath'], $data, 'private');
    }
}
