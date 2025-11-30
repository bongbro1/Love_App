<?php
// app/controllers/HomeController.php

require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        // Ví dụ: load view
        $seo = [
            'title' => 'Trang chủ',
            'description' => 'NearLove - Kết nối gần bạn',
            'keywords' => 'love, near, dating'
        ];

        $this->view('home/index', ['seo' => $seo], 'public');
    }
}
