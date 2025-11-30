<?php
// app/views/home/index.php
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="LoveApp">
  <title><?= htmlspecialchars($seo['title'] ?? 'Yêu Gần') ?></title>
  <meta name="description" content="<?= htmlspecialchars($seo['description'] ?? '') ?>">
  <meta name="keywords" content="<?= htmlspecialchars($seo['keywords'] ?? '') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    .float-animation {
      animation: float 3s ease-in-out infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    .pulse-animation {
      animation: pulse 2s ease-in-out infinite;
    }
  </style>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            roboto: ['Roboto', 'sans-serif'],
          },
          scale: {
            '102': '1.02',
            '103': '1.03',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50 font-roboto antialiased scroll-pt-20">
  <!-- Header -->
  <header class="bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 text-white py-4 sticky top-0 z-50 shadow-lg transition-all duration-300">
    <div class="container mx-auto px-4 flex items-center justify-between relative">
      <div class="flex items-center">
        <h1 class="text-2xl md:text-3xl font-bold tracking-tight"><a href="/love-app/public">LoveApp</a></h1>
      </div>

      <!-- Desktop Menu -->
      <nav class="hidden md:flex space-x-8 items-center font-medium">
        <a href="/love-app/public/gioi-thieu" class="text-lg hover:text-pink-200 transition duration-300">Giới Thiệu</a>
        <a href="/love-app/public/yeu-gan" class="text-lg hover:text-pink-200 transition duration-300">Yêu Gần</a>
        <a href="/love-app/public/yeu-xa" class="text-lg hover:text-pink-200 transition duration-300">Yêu Xa</a>
        <a href="/love-app/public/bao-mat" class="text-lg hover:text-pink-200 transition duration-300">Bảo Mật</a>
        <a href="/love-app/public/cach-su-dung" class="text-lg hover:text-pink-200 transition duration-300">Cách Sử Dụng</a>
        <a href="/love-app/public/bai-viet" class="text-lg hover:text-pink-200 transition duration-300">Bài Viết</a>
        <a href="/love-app/public/#purchase" class="bg-white text-pink-600 px-5 py-2 rounded-full font-semibold hover:bg-pink-100 transition duration-300">Đặt Mua Thẻ NFC</a>
      </nav>

      <!-- Mobile Menu Toggle -->
      <div class="md:hidden">
        <input type="checkbox" id="menu-toggle" class="peer hidden">
        <label for="menu-toggle" class="cursor-pointer">
          <i class="fas fa-bars text-2xl"></i>
        </label>

        <!-- Mobile Menu -->
        <div class="absolute right-0 mt-4 w-full bg-indigo-600 text-white rounded-b-xl shadow-lg
    origin-top scale-y-0 opacity-0 transition-all duration-300
    peer-checked:scale-y-100 peer-checked:opacity-100">
          <a href="/love-app/public/gioi-thieu" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Giới Thiệu</a>
          <a href="/love-app/public/yeu-gan" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Yêu Gần</a>
          <a href="/love-app/public/yeu-xa" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Yêu Xa</a>
          <a href="/love-app/public/bao-mat" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Bảo Mật</a>
          <a href="/love-app/public/cach-su-dung" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Cách Sử Dụng</a>
          <a href="/love-app/public/bai-viet" class="block py-3 px-4 text-lg hover:text-pink-200 transition">Bài Viết</a>
          <a href="/love-app/public/#purchase"
            class="block py-3 px-4 w-56 text-lg font-bold text-yellow-400 hover:text-yellow-300 transition">
            Đặt Mua Thẻ NFC
          </a>
        </div>
      </div>
    </div>
  </header>