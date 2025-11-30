<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@heroicons/react/24/outline/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    }
                }
            }
        };
    </script>
    <style>
        body.swal2-height-auto {
            height: auto !important;
            min-height: 100vh;
            /* giữ body full-height */
            overflow: auto !important;
            /* giữ scroll nếu cần */
        }

        .ck-editor__editable {
            height: 300px;
        }

        .ck-editor__editable li {
            margin-left: 20px !important;
        }
    </style>
</head>

<body class="flex h-screen bg-gray-50 text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r shadow-lg flex flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold text-xl">
            💕 LoveApp Admin
        </div>
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-2">
                <li>
                    <a href="<?= BASE_URL ?>/admin" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= ($_SERVER['REQUEST_URI'] ?? '') === '<?= BASE_URL ?>/admin' ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/categories" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/categories') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Danh Mục
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/posts" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/posts') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Bài Viết
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/sepay" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/sepay') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Tài Khoản Sepay
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/orders" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition <?= str_contains($_SERVER['REQUEST_URI'], '/admin/orders') ? 'bg-gray-200 font-semibold text-pink-600' : '' ?>">
                        Đơn Hàng
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/bulk-mail" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/bulk-mail') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Gửi Mail
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/seo" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/seo') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Cấu Hình SEO
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/admin/settings" class="flex items-center px-3 py-2 rounded-lg transition-all hover:bg-pink-50 <?= str_contains($_SERVER['REQUEST_URI'], '/settings') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-700' ?>">
                        Cài Đặt Chung
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Footer -->
        <div class="p-4 border-t bg-gradient-to-r from-pink-50 to-rose-50">
            <a href="<?= BASE_URL ?>/admin/logout"
                class="group flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-white border border-pink-100 shadow-sm 
              hover:shadow-md hover:border-pink-300 transition-all duration-200">

                <!-- Heroicons: Arrow Right On Rectangle -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                    class="w-5 h-5 text-rose-500 group-hover:text-rose-600 transition">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>

                <span class="font-semibold text-gray-700 group-hover:text-rose-600 transition">Logout</span>
            </a>
        </div>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b shadow-sm h-16 flex justify-between items-center px-6">
            <h1 class="text-2xl font-bold text-pink-600"><?= $title ?? 'Dashboard' ?></h1>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-pink-50 px-3 py-1 rounded-full">
                    <span class="text-sm text-pink-700 font-medium">Admin</span>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6">
            <?php if (isset($content)) echo $content; ?>
        </main>
    </div>


    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
</body>

</html>