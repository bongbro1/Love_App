<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="heartbeat" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 py-4 px-2">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Nhịp Tim Tình Yêu</h2>
            <div class="text-center flex flex-col items-center gap-4">
                <?php
                $gender = $_SESSION['gender'] ?? 'unknown'; // male / female / unknown
                $buttonText = 'Nhớ Em/Anh'; // default

                if ($gender === 'male') {
                    $buttonText = 'Nhớ Em 💓';
                } elseif ($gender === 'female') {
                    $buttonText = 'Nhớ Anh 💓';
                }
                ?>
                <button id="sendHeartbeat" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 md:px-10 py-3 md:py-4 rounded-full sparkle-button ripple transition duration-300 text-sm md:text-lg flex items-center justify-center">
                    <i class="fas fa-heart heart-beat mr-2"></i> <?= $buttonText ?>
                </button>
                <p class="text-gray-600 text-sm md:text-base">Gửi tín hiệu yêu thương, đối phương sẽ nhận ngay!</p>
                <p class="text-pink-600 font-semibold text-sm md:text-base" id="lastHeartbeat">Hãy cho biết nhịp tim của bạn 💓</p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>


<script>
    // Heartbeat Signal 
    $(document).ready(function() {
        const socket = new WebSocket(WS_URL_HEARTBEAT);

        socket.onopen = () => console.log("Connected to Heartbeat WS!");

        socket.onmessage = function(event) {
            const data = JSON.parse(event.data);

            // Cập nhật chart realtime
            // addHeartbeatToChart(data.sender_id, data.created_at || new Date());
        };

        socket.onerror = (err) => console.error("WS Error:", err);

        socket.onclose = () => console.log("Disconnected from Heartbeat WS");

        // --- Khi bấm nút gửi ---
        function sendHeartbeat() {
            showLoading();
            const note = "💓";
            $.ajax({
                url: 'index.php?action=heartbeat_send', // AJAX lưu DB
                type: 'POST',
                dataType: 'json',
                data: {
                    note: note,
                    sender_id: userId
                },
                success: function(res) {
                    if (!res.success) return alert('Gửi thất bại: ' + (res.message || ''));

                    // 1️⃣ Cập nhật Last Sent
                    $('#lastHeartbeat').text('Lần cuối gửi: ' + res.last_sent);

                    // 3️⃣ Gửi WebSocket cho người khác realtime
                    if (socket.readyState === WebSocket.OPEN) {
                        socket.send(JSON.stringify({
                            sender_id: userId,
                            created_at: new Date().toISOString() // thời gian gửi realtime
                        }));
                    }
                    hideLoading();

                    Swal.fire({
                        icon: 'success',
                        title: 'Thông báo',
                        text: 'Đã gửi nhịp tim 💓',
                        timer: 2000,
                        showConfirmButton: false
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.group('💥 Heartbeat AJAX Error');
                    // console.log('Error Thrown:', errorThrown);
                    // console.log('HTTP Status:', jqXHR.status);
                    // console.log('Response Text:', jqXHR.responseText);
                    // console.log('All jqXHR:', jqXHR);
                    // console.groupEnd();
                    alert('Không thể gửi tín hiệu. Vui lòng thử lại!');
                }
            });
        }

        // Button click
        $('#sendHeartbeat').on('click', sendHeartbeat);

        // --- Load lịch sử nhịp tim bằng AJAX ---
        function loadLastSend() {
            $.ajax({
                url: 'index.php?action=last_send',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (!res.success) return console.error('Không tải được lịch sử heartbeat');

                    // Cập nhật Last Sent của chính user
                    if (res.last_sent) {
                        $('#lastHeartbeat').text('Lần cuối gửi: ' + res.last_sent);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.group('💥 Heartbeat AJAX Error');
                    console.log('Error Thrown:', errorThrown);
                    console.log('HTTP Status:', jqXHR.status);
                    console.log('Response Text:', jqXHR.responseText);
                    console.log('All jqXHR:', jqXHR);
                    console.groupEnd();

                    console.error('Lỗi tải lịch sử heartbeat', err);
                }
            });
        }

        // Load lịch sử khi reload trang
        loadLastSend();

        // Hàm convert VAPID key sang Uint8Array
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
        }

        async function registerPush() {
            // 1️⃣ Kiểm tra hỗ trợ
            if (!("serviceWorker" in navigator)) {
                console.error("❌ Service Worker KHÔNG được hỗ trợ!");
                return;
            }
            if (!("PushManager" in window)) {
                console.error("❌ Push API KHÔNG được hỗ trợ!");
                return;
            }

            try {
                // 2️⃣ Kiểm tra SW hiện có (không unregister nữa)
                let registration = await navigator.serviceWorker.getRegistration("/love-app/public/sw.js");
                if (!registration) {
                    registration = await navigator.serviceWorker.register("/love-app/public/sw.js", {
                        scope: "/love-app/public/"
                    });
                }

                // 3️⃣ Đảm bảo SW đã sẵn sàng
                const readyReg = await navigator.serviceWorker.ready;

                // 4️⃣ Kiểm tra quyền Notifications
                const perm = Notification.permission;

                if (perm === "default") {
                    const newPerm = await Notification.requestPermission();

                    if (newPerm !== "granted") {
                        console.error("🚫 Người dùng từ chối Notifications.");
                        return;
                    }
                } else if (perm === "denied") {
                    console.error("🚫 Notifications đã bị chặn trong trình duyệt.");
                    return;
                }
                // 5️⃣ Lấy subscription hiện có (nếu có)
                let subscription = await readyReg.pushManager.getSubscription();
                if (!subscription) {
                    // 6️⃣ Tạo mới subscription
                    const key = urlBase64ToUint8Array(VAPID_PUBLIC_KEY);
                    try {
                        subscription = await readyReg.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: key
                        });
                    } catch (subErr) {
                        return;
                    }
                }

                // 7️⃣ Gửi subscription lên server
                await fetch("index.php?action=save_subscription", {
                    method: "POST",
                    body: new URLSearchParams({
                        subscription: JSON.stringify(subscription)
                    })
                });

            } catch (err) {}
        }
        registerPush();
    });
</script>