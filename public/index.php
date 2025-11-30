<?php
// Thời gian sống session: 24 giờ (tính bằng giây)
$session_lifetime = 24 * 60 * 60; // 86400 giây

// Cấu hình PHP trước khi session_start()
ini_set('session.gc_maxlifetime', $session_lifetime);
ini_set('session.cookie_lifetime', $session_lifetime);
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/core/init.php'; // nếu cần load core
require_once __DIR__ . '/../vendor/autoload.php';

// Nếu gọi action order từ AJAX
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'auth_has_password':
    case 'auth_verify_password':
    case 'auth_set_password':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController($pdo);

        if ($action === 'auth_has_password') {
            $controller->hasPassword();
        } elseif ($action === 'auth_verify_password') {
            $controller->verifyPassword();
        } elseif ($action === 'auth_set_password') {
            $controller->setPassword();
        }
        break;

    case 'order':
        require_once __DIR__ . '/../app/controllers/OrderController.php';
        $controller = new OrderController($pdo);
        $controller->order(); // xử lý POST và trả JSON
        break;
    case 'nfc_scan':
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['location'])) {
            // Chưa có location → show view tự lấy vị trí rồi redirect
            require_once __DIR__ . '/../app/views/nfc_redirect.php';
            exit;
        }

        require_once __DIR__ . '/../app/controllers/NFCController.php';
        $controller = new NFCController($pdo);
        $controller->scan(); // method xử lý POST JSON
        break;

    case 'chat_send':
    case 'chat_load':
    case 'delete_message':
        require_once __DIR__ . '/../app/controllers/ChatController.php';
        $controller = new ChatController($pdo); // ChatController tự tạo PDO bên trong
        if ($action === 'chat_send') {
            $controller->send(); // POST ajax gửi tin nhắn
        } else if ($action === 'chat_load') {
            $controller->load();
        } elseif ($action === 'delete_message') {
            $controller->deleteMessage();
        }
        break;

    case 'secret_send':
    case 'secret_list':
    case 'secret_open':
    case 'secret_media_send':
    case 'secret_media_list':
    case 'secret_media_chunk':
        require_once __DIR__ . '/../app/controllers/SecretLetterController.php';
        $controller = new SecretLetterController($pdo);

        if ($action === 'secret_send') {
            $controller->send();   // Gửi thư bí mật mới
        } elseif ($action === 'secret_list') {
            $controller->list();   // Lấy danh sách thư bí mật của cặp đôi
        } elseif ($action === 'secret_open') {
            $controller->open();   // Mở thư khi đến ngày
        } else if ($action === 'secret_media_send') {
            $controller->sendMedia();     // Upload video/voice
        } elseif ($action === 'secret_media_list') {
            $controller->listMedia();     // Lấy danh sách media của cặp đôi
        } elseif ($action === 'secret_media_chunk') {
            // ✅ Route mới để xử lý upload theo từng phần
            require_once __DIR__ . '/../app/helpers/upload_chunk.php';
            $uploadResult = handleChunkUpload();
            // Nếu upload xong thì gọi tiếp sendMedia()
            if ($uploadResult && isset($uploadResult['success']) && $uploadResult['success'] && isset($uploadResult['file'])) {
                $_POST['uploaded_file'] = $uploadResult['file']; // truyền file name sang sendMedia
                $controller->sendMedia(); // gọi tiếp
            } else {
                echo json_encode($uploadResult);
            }
        }
        break;

    case 'heartbeat_send':
    case 'heartbeat_history':
    case 'last_send':
    case 'save_subscription':
        require_once __DIR__ . '/../app/controllers/HeartbeatController.php';
        $controller = new HeartbeatController($pdo);

        if ($action === 'heartbeat_send') {
            $controller->send();
        } else if ($action === 'heartbeat_history') {
            $controller->history();
        } else if ($action === 'last_send') {
            $controller->last_send();
        } else if ($action === 'save_subscription') {
            $controller->save_subscription();
        }
        break;

    case 'mood_update':
    case 'mood_stats':
        require_once __DIR__ . '/../app/controllers/MoodController.php';
        $controller = new MoodController($pdo);

        if ($action === 'mood_update') {
            $controller->update(); // POST: cập nhật cảm xúc
        } elseif ($action === 'mood_stats') {
            $controller->getStats(); // GET: lấy dữ liệu biểu đồ
        }
        break;


    case 'diary':
    case 'diary_load':
    case 'diary_save':
    case 'diary_update':
    case 'diary_delete':
        require_once __DIR__ . '/../app/controllers/LoveDiaryController.php';
        $controller = new LoveDiaryController($pdo);

        if ($action === 'diary') {
            $controller->index();
        } elseif ($action === 'diary_load') {
            $controller->load();
        } elseif ($action === 'diary_save') {
            $controller->save();
        } elseif ($action === 'diary_update') {
            $controller->update();
        } elseif ($action === 'diary_delete') {
            $controller->delete();
        }
        break;

    // yêu gần
    case 'checkin_load':      // tải dữ liệu cho section check-in trong dashboard
    case 'checkin_process':   // xử lý check-in AJAX
        require_once __DIR__ . '/../app/controllers/CheckinController.php';
        $controller = new CheckinController($pdo);

        if ($action === 'checkin_load') {
            $controller->getCheckinData();
        } elseif ($action === 'checkin_process') {
            $controller->submitCheckin();
        }
        break;

    case 'memory_upload':
    case 'memory_fetch_data':
        require_once __DIR__ . '/../app/controllers/MemoriesController.php';
        $controller = new MemoriesController($pdo);
        if ($action === 'memory_upload') {
            $controller->upload();
        } elseif ($action === 'memory_fetch_data') {
            $controller->fetchMemories();
        }
        break;

    case 'fetch_love_map_points':
        require_once __DIR__ . '/../app/controllers/LoveMapController.php';
        $controller = new LoveMapController($pdo);
        if ($action === 'fetch_love_map_points') {
            $controller->fetchPoints();
        }
        break;

    case 'add_challenge_instance':
    case 'get_challenge_detail':
    case 'fetch_challenges':
    case 'fetch_tasks':
    case 'start_challenge':
    case 'complete_task':
    case 'total_score':
    case 'complete_challenge':
    case 'challenge_history':
        require_once __DIR__ . '/../app/controllers/ChallengeController.php';
        $controller = new ChallengeController($pdo);

        if ($action === 'add_challenge_instance') {
            $controller->addChallengeInstance();
        } elseif ($action === 'get_challenge_detail') {
            $controller->getChallengeDetail();
        } elseif ($action === 'fetch_challenges') {
            $controller->fetchChallenges();
        } elseif ($action === 'fetch_tasks') {
            $controller->fetchTasks();
        } elseif ($action === 'start_challenge') {
            $controller->startChallenge();
        } elseif ($action === 'complete_task') {
            $controller->completeTask();
        } elseif ($action === 'total_score') {
            $controller->totalScore();
        } elseif ($action === 'complete_challenge') {
            $controller->completeChallenge();
        } elseif ($action === 'challenge_history') {
            $controller->challengeHistory();
        }
        break;

    case 'anniversary_list':
    case 'anniversary_detail':
    case 'anniversary_add':
    case 'anniversary_update':
    case 'anniversary_delete':
        require_once __DIR__ . '/../app/controllers/AnniversaryController.php';
        $controller = new AnniversaryController();

        if ($action === 'anniversary_list') $controller->list();
        if ($action === 'anniversary_detail') $controller->detail();
        if ($action === 'anniversary_add') $controller->add();
        if ($action === 'anniversary_update') $controller->update();
        if ($action === 'anniversary_delete') $controller->delete();
        break;

    case 'profile':
    case 'update_profile':
    case 'change_password':      // Trang đổi mật khẩu
    case 'security_settings':    // Trang cài đặt bảo mật
    case 'update_password':
    case 'logout':               // Đăng xuất
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController($pdo);
        if ($action === 'profile') {
            $controller->showProfile();
        } elseif ($action === 'update_profile') {
            $controller->updateProfile();
        } elseif ($action === 'change_password') {
            $controller->showChangePassword();
        } elseif ($action === 'security_settings') {
            $controller->showSecuritySettings();
        } elseif ($action === 'update_password') {
            $controller->updatePassword();
        } elseif ($action === 'logout') {
            $controller->logout();
        }
        break;

    default:
        // Trang web bình thường, dùng router
        $router = new Router();

        // Đăng ký route
        $router->get('/', 'HomeController@index');
        $router->get('/gioi-thieu', 'PageController@gioiThieu');
        $router->get('/yeu-gan', 'PageController@yeuGan');
        $router->get('/yeu-xa', 'PageController@yeuXa');
        $router->get('/bao-mat', 'PageController@baoMat');
        $router->get('/cach-su-dung', 'PageController@cachSuDung');
        $router->get('/dat-mua', 'PageController@datMua');
        $router->get('/bai-viet', 'PageController@baiViet');

        // NearLove pages
        $router->get('/nearlove/checkin', 'NearLoveController@checkin');
        $router->get('/nearlove/memories', 'NearLoveController@memories');
        $router->get('/nearlove/lovemap', 'NearLoveController@lovemap');
        $router->get('/nearlove/challenges', 'NearLoveController@challenges');
        $router->get('/nearlove/minigame', 'NearLoveController@minigame');
        $router->get('/nearlove/anniversary', 'NearLoveController@anniversary');

        // LongDistance pages
        $router->get('/longdistance/chat', 'LongDistanceController@chat');
        $router->get('/longdistance/secretletter', 'LongDistanceController@secretLetter');
        $router->get('/longdistance/heartbeat', 'LongDistanceController@heartbeat');
        $router->get('/longdistance/moodtracker', 'LongDistanceController@moodTracker');
        $router->get('/longdistance/diary', 'LongDistanceController@diary');
        $router->get('/longdistance/challenges', 'LongDistanceController@challenges');
        $router->get('/longdistance/minigame', 'LongDistanceController@minigame');
        $router->get('/longdistance/videoreminder', 'LongDistanceController@videoReminder');

        // Dashboard admin
        $router->get('/admin', 'AdminHomeController@index');

        // ====================
        // Admin routes
        // ====================
        // Categories
        $router->get('/admin/categories', 'AdminCategoryController@index');
        $router->get('/admin/categories/create', 'AdminCategoryController@create');
        $router->post('/admin/categories/create', 'AdminCategoryController@create');
        $router->get('/admin/categories/edit/(\d+)', 'AdminCategoryController@edit');
        $router->post('/admin/categories/edit', 'AdminCategoryController@edit');
        $router->get('/admin/categories/delete/(\d+)', 'AdminCategoryController@delete');
        $router->get('/admin/categories/filter', 'AdminCategoryController@filter');

        // Posts
        $router->get('/admin/posts', 'AdminPostController@index');
        $router->get('/admin/posts/create', 'AdminPostController@create');
        $router->post('/admin/posts/create', 'AdminPostController@store');
        $router->get('/admin/posts/edit/(\d+)', 'AdminPostController@edit');
        $router->post('/admin/posts/edit/(\d+)', 'AdminPostController@edit');
        $router->get('/admin/posts/delete/(\d+)', 'AdminPostController@delete');
        $router->get('/admin/posts/filter', 'AdminPostController@filter');

        // Sepay routes
        $router->get('/admin/sepay', 'AdminSepayController@index');
        $router->post('/admin/sepay/update-api-key', 'AdminSepayController@updateApiKey');

        // Orders
        $router->get('/admin/orders', 'AdminOrderController@index');
        $router->get('/admin/orders/view/(\d+)', 'AdminOrderController@show');
        $router->get('/admin/orders/delete/(\d+)', 'AdminOrderController@delete');
        $router->get('/admin/orders/export', 'AdminOrderController@export');
        $router->post('/admin/orders/markPrinted', 'AdminOrderController@markPrinted');
        $router->get('/admin/orders/filter', 'AdminOrderController@filter');

        $router->get('/admin/bulk-mail', 'AdminOrderController@bulkMailPage');
        $router->post('/admin/bulk-mail/send', 'AdminOrderController@sendBulkMail');


        // SEO Config
        $router->get('/admin/seo', 'AdminSeoController@index');
        $router->post('/admin/seo/update', 'AdminSeoController@update');

        // General Settings
        $router->get('/admin/settings', 'AdminSettingsController@index');
        $router->post('/admin/settings/update', 'AdminSettingsController@update');


        // Loại bỏ prefix folder khi dispatch
        $uri = str_replace('/love-app/public', '', $_SERVER['REQUEST_URI']);

        // Dispatch
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Nếu bạn đang chạy trong thư mục con (love-app/public)
        $uri = str_replace('/love-app/public', '', $uri);

        $router->dispatch($uri);

        break;
}
