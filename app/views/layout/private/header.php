<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Yêu  Gần' ?></title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <!-- FontAwesome CSS (bao gồm solid, regular, brands) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        /* Font Styles */

        body {
            font-family: 'Poppins', sans-serif;
        }

        h1.text-3xl,
        h2.text-3xl {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .recording {
            background-color: #f87171;
            /* đỏ */
            color: red !important;
            animation: pulse 1s infinite;
        }

        .chat-voice-audio {
            max-width: 250px;
            /* chỉnh tùy bạn */
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            z-index: 5;
            background: rgba(0, 0, 0, 0);
            pointer-events: none;
            /* trong suốt */
        }


        .voice-overlay {
            position: absolute;
            inset: 0;
            z-index: 10;
            background: transparent;
            display: inline-block;
        }

        /* Hiệu ứng nhấp nháy nhẹ */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }


        /* Heart Beat Animation */
        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .heart-beat {
            animation: heartBeat 1.5s infinite ease-in-out;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        /* Floating Hearts Background */
        @keyframes floatHeart {
            0% {
                transform: translateY(0);
                opacity: 0.8;
            }

            50% {
                transform: translateY(-100px);
                opacity: 0.3;
            }

            100% {
                transform: translateY(-200px);
                opacity: 0;
            }
        }

        .swal2-popup {
            width: 320px !important;
            padding: 1.25rem !important;
            border-radius: 1rem !important;
        }

        /* 👇 Giảm kích thước icon */
        .swal2-icon {
            transform: scale(0.7) !important;
            /* thu nhỏ còn ~70% */
            margin: 0.5rem auto !important;
        }

        .swal2-title {
            padding-top: 0;
            margin-top: 0 !important;
            font-size: 1.2rem !important;
        }

        .swal2-html-container {
            font-size: 0.9rem !important;
            margin-top: 0.25rem !important;
        }


        .floating-heart {
            position: absolute;
            font-size: 1.5rem;
            color: #ff6b6b;
            animation: floatHeart 5s infinite ease-in-out;
        }

        /* Card Hover Effect */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
        }

        /* Gradient Border */
        .gradient-border {
            position: relative;
            padding: 3px;
            background: linear-gradient(45deg, #ff6b6b, #ff99cc);
            border-radius: 16px;
        }

        .gradient-border>div {
            background: white;
            border-radius: 13px;
            padding: 1rem;
        }

        /* Image Fallback */
        img {
            background-color: #ffe6e6;
            object-fit: cover;
        }


        .modal-show {
            animation: slideUp 0.4s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(70%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .tab-link.active i,
        .tab-link.active span {
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #detail-description::-webkit-scrollbar {
            width: 6px;
        }

        #detail-description::-webkit-scrollbar-thumb {
            background: #f9a8d4;
            /* hồng nhạt */
            border-radius: 3px;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle menu khi nhấn vào avatar
            $('#userMenuBtn').on('click', function(e) {
                e.stopPropagation(); // tránh click lan ra ngoài
                $('#userMenu').toggleClass('hidden');
            });

            // Ẩn menu khi click ra ngoài
            $(document).on('click', function() {
                $('#userMenu').addClass('hidden');
            });

            // (Tùy chọn) Đóng menu khi click vào 1 item
            $('#userMenu a').on('click', function() {
                $('#userMenu').addClass('hidden');
            });
        });
    </script>
</head>

<body class="bg-gradient-to-br from-pink-50 via-rose-50 to-purple-100 min-h-screen relative overflow-x-hidden scroll-pt-32 antialiased">
    <!-- Floating Hearts Background -->
    <div class="fixed inset-0 pointer-events-none">
        <i class="fas fa-heart floating-heart" style="left: 10%; animation-delay: 0s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 30%; animation-delay: 1s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 50%; animation-delay: 2s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 70%; animation-delay: 3s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 90%; animation-delay: 4s;"></i>
    </div>

    <!-- Header -->
    <header class="bg-gradient-to-r from-pink-600 to-purple-600 text-white p-4 shadow-md sticky top-0 z-20">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-heart heart-beat text-2xl"></i>
                <?php if (($mode ?? '') === 'nearlove'): ?>
                    <a href="<?= BASE_URL ?>/nearlove/checkin">Yêu Gần</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/longdistance/chat">Yêu Xa</a>
                <?php endif; ?>
            </h1>

            <?php $userName = $_SESSION['user_full_name'] ?? 'Chưa đăng nhập'; ?>
            <div class="relative inline-block text-left">
                <!-- Nút hiển thị user -->
                <button id="userMenuBtn" class="flex items-center gap-2 bg-pink-500/40 px-3 py-1 rounded-full text-sm">
                    <i class="fas fa-user-circle text-lg"></i>
                    <span><?= htmlspecialchars($userName) ?></span>
                </button>

                <!-- Menu thả xuống -->
                <div id="userMenu"
                    class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden z-50 modal-show">

                    <a href="index.php?action=profile"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                        <i class="fas fa-user text-pink-500 w-5"></i>
                        Thông tin cá nhân
                    </a>

                    <a href="index.php?action=change_password"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                        <i class="fas fa-key text-pink-500 w-5"></i>
                        Đổi mật khẩu
                    </a>

                    <a href="index.php?action=security_settings"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                        <i class="fas fa-shield-alt text-pink-500 w-5"></i>
                        Cài đặt bảo mật
                    </a>

                    <div class="border-t border-pink-100"></div>

                    <a href="index.php?action=logout"
                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                        <i class="fas fa-sign-out-alt text-pink-500 w-5"></i>
                        Đăng xuất
                    </a>
                </div>

            </div>

        </div>
    </header>