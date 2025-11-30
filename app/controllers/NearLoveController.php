<?php
require_once __DIR__ . '/../helpers/Auth.php';

class NearLoveController extends Controller
{
    private function renderPageData($file, $title)
    {
        Auth::check(); // đảm bảo user đã login

        return [
            'viewPath'  => "nearlove/{$file}",
            'pageTitle' => $title,
            'mode'      => 'nearlove'
        ];
    }


    public function checkin()
    {
        $data = $this->renderPageData('checkin', 'Check-in Gặp Mặt');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function memories()
    {
        $data = $this->renderPageData('memories', 'Album Kỷ Niệm');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function lovemap()
    {
        $data = $this->renderPageData('lovemap', 'Love Map');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function challenges()
    {
        $data = $this->renderPageData('challenges', 'Thử Thách Tình Yêu');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function minigame()
    {
        $data = $this->renderPageData('minigame', 'Mini Game Offline');
        $this->view($data['viewPath'], $data, 'private');
    }

    public function anniversary()
    {
        $data = $this->renderPageData('anniversary', 'Nhắc Kỷ Niệm');
        $this->view($data['viewPath'], $data, 'private');
    }
}
