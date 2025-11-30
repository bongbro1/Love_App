<?php
// app/views/nfc_redirect.php
$tag = htmlspecialchars($_GET['tag'] ?? '', ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Lấy vị trí check-in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-pink-50 flex flex-col items-center justify-center min-h-screen text-gray-700 font-sans">

    <!-- Loading screen -->
    <div id="loading" class="text-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-pink-500 mx-auto mb-4"></div>
        <p class="text-lg font-medium">Đang lấy vị trí của bạn...</p>
        <p class="text-sm text-gray-500 mt-2">Vui lòng cho phép truy cập vị trí nhé 💌</p>
    </div>

    <!-- Popup nhập tên địa điểm -->
    <div id="locationModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center px-4 z-50">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-xl p-6 text-center relative animate-fadeIn">
            <div class="flex justify-center mb-2">
                <div class="bg-pink-100 p-3 rounded-full">
                    <span class="text-3xl">💞</span>
                </div>
            </div>
            <h2 class="text-2xl font-semibold text-pink-600 mb-2">Nhập tên địa điểm</h2>
            <p class="text-sm text-gray-500 mb-5">Hãy đặt tên cho nơi đặc biệt này nhé!</p>
            <input id="locationNameInput" type="text"
                placeholder="VD: Quán cà phê kỷ niệm ☕"
                class="w-full border border-pink-300 rounded-2xl p-3 mb-4 text-center text-base focus:outline-none focus:ring-2 focus:ring-pink-400 transition" />
            <div class="flex gap-3">
                <button id="skipBtn"
                    class="flex-1 border border-pink-300 text-pink-500 hover:bg-pink-50 px-4 py-3 rounded-2xl font-medium transition-all active:scale-95">
                    🚫 Bỏ qua
                </button>
                <button id="confirmBtn"
                    class="flex-1 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-lg px-4 py-3 rounded-2xl font-semibold shadow-md transition-all active:scale-95">
                    💌 Xác nhận
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-4">Thông tin này sẽ được lưu cùng vị trí của bạn 🌍</p>
        </div>
    </div>


    <!-- 🔒 Modal nhập mật khẩu -->
    <div id="passwordModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm pd">
        <div class="bg-white/95 backdrop-blur-md border border-gray-100 rounded-2xl shadow-xl w-[90%] max-w-[22rem] p-6 animate-[fadeIn_0.25s_ease]">
            <h2 class="text-lg font-semibold text-gray-800 mb-1 text-center">Xác thực bảo mật</h2>
            <p class="text-sm text-gray-500 mb-5 text-center">Nhập mật khẩu để tiếp tục</p>

            <div class="relative mb-3">
                <input id="passwordInput" type="password"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none text-gray-800 transition"
                    placeholder="••••••••" />
            </div>

            <p id="passwordError" class="hidden text-red-500 text-sm mb-3 text-center">Mật khẩu không đúng!</p>

            <div class="flex justify-end gap-2 mt-2">
                <button id="cancelPassword"
                    class="px-4 py-2 rounded-xl text-gray-600 hover:bg-gray-100 transition">Huỷ</button>
                <button id="confirmPassword"
                    class="px-4 py-2 rounded-xl bg-pink-500 text-white hover:bg-pink-600 transition">Xác nhận</button>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>


    <script>
        $(function() {

            // 🧩 1. BIẾN & HẰNG SỐ CƠ BẢN
            const tag = <?= json_encode($tag) ?>;
            if (!tag) {
                $('body').html("<p class='text-red-500 text-center mt-10'>Thiếu tham số tag.</p>");
                return;
            }
            // 🧰 2. HÀM TIỆN ÍCH
            const savePendingTag = uid => {
                localStorage.setItem(PAIR_KEY, JSON.stringify({
                    uid,
                    ts: Date.now()
                }));
            };

            const getPendingTag = () => {
                const raw = localStorage.getItem(PAIR_KEY);
                if (!raw) return null;
                try {
                    const obj = JSON.parse(raw);
                    if (!obj.uid || !obj.ts) return null;
                    if ((Date.now() - obj.ts) > PAIR_TTL_MS) {
                        localStorage.removeItem(PAIR_KEY);
                        return null;
                    }
                    return obj.uid;
                } catch {
                    localStorage.removeItem(PAIR_KEY);
                    return null;
                }
            };

            const clearPending = () => localStorage.removeItem(PAIR_KEY);

            const redirect = (finalTag, lat = null, lng = null, locationName = '') => {
                let newUrl = `${window.location.pathname}?action=nfc_scan&tag=${encodeURIComponent(finalTag)}`;
                if (lat !== null && lng !== null)
                    newUrl += `&location=${encodeURIComponent(lat + ',' + lng)}`;
                if (locationName)
                    newUrl += `&location_name=${encodeURIComponent(locationName)}`;

                // Dùng href để reload trang
                window.location.href = newUrl;
            };
            const PAIR_KEY = 'nfc_pending_tag';
            const PAIR_TTL_MS = 30000;
            let lat, lng;


            // 🧩 Kiểm tra hoặc đặt mật khẩu trước khi redirect
            function requestPasswordThenRedirect(finalTag, lat = null, lng = null, locationName = '') {
                const payload = {
                    tags: finalTag
                }
                // Trước tiên kiểm tra user đã có mật khẩu chưa
                $.post('index.php?action=auth_has_password', payload, function(res) {
                    const data = JSON.parse(res);
                    const hasPassword = data.hasPassword;
                    const modal = $('#passwordModal');
                    const input = $('#passwordInput');
                    const error = $('#passwordError');
                    const title = modal.find('h2');

                    // Cập nhật tiêu đề theo tình trạng mật khẩu
                    title.text(hasPassword ? 'Nhập mật khẩu bảo mật' : 'Đặt mật khẩu mới');
                    input.val('');
                    error.addClass('hidden');
                    modal.removeClass('hidden');

                    // Hủy
                    $('#cancelPassword').off('click').on('click', function() {
                        modal.addClass('hidden');
                    });

                    // Xác nhận
                    $('#confirmPassword').off('click').on('click', function() {
                        const password = input.val().trim();
                        if (!password) {
                            error.text('Vui lòng nhập mật khẩu').removeClass('hidden');
                            return;
                        }

                        const action = hasPassword ? 'auth_verify_password' : 'auth_set_password';
                        const url = `index.php?action=${action}`;
                        const body = {
                            ...payload,
                            password
                        };

                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: body,
                            dataType: 'json', // important: expect JSON from server
                            timeout: 15000,
                            beforeSend: () => {
                                // disable buttons to prevent double submit
                                $('#confirmPassword, #cancelPassword').prop('disabled', true).addClass('opacity-60');
                            },
                            success: function(data, textStatus, jqXHR) {
                                // Expecting: { success: true } or { success: false, msg: '...' }
                                if (data && data.success) {
                                    modal.addClass('hidden');
                                    // Nếu tag là 2 thẻ và chưa có locationName → show modal
                                    if (finalTag.includes(',') && !locationName) {
                                        showLocationNameModal(finalTag, lat, lng);
                                    } else {
                                        // Trường hợp 1 thẻ hoặc đã có locationName → redirect luôn
                                        setTimeout(() => {
                                            redirect(finalTag, lat, lng, locationName);
                                        }, 120);
                                    }
                                } else {
                                    const msg = data && data.msg ? data.msg : (hasPassword ? 'Mật khẩu không đúng!' : 'Không thể lưu mật khẩu!');
                                    error.text(msg).removeClass('hidden');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('[AUTH] ajax error:', textStatus, errorThrown, jqXHR.responseText);
                                // Show friendly message
                                if (jqXHR.responseText) {
                                    // Try to show server message if it's JSON
                                    try {
                                        const parsed = JSON.parse(jqXHR.responseText);
                                        if (parsed.msg) error.text(parsed.msg).removeClass('hidden');
                                        else error.text('Lỗi server: ' + textStatus).removeClass('hidden');
                                    } catch (e) {
                                        error.text('Lỗi kết nối đến máy chủ!').removeClass('hidden');
                                    }
                                } else {
                                    error.text('Lỗi kết nối đến máy chủ!').removeClass('hidden');
                                }
                            },
                            complete: function() {
                                // re-enable buttons
                                $('#confirmPassword, #cancelPassword').prop('disabled', false).removeClass('opacity-60');
                            }
                        });
                    });
                }).fail((jqXHR, textStatus, errorThrown) => {
                    console.error('[AUTH] Không thể kiểm tra mật khẩu từ máy chủ!', textStatus, errorThrown);
                    $('#passwordError')
                        .text('Lỗi kết nối đến máy chủ!')
                        .removeClass('hidden');
                });
            }


            // ✅ Hàm xử lý khi chỉ có 1 thẻ (hết 30s hoặc người dùng nhấn nút)
            function proceedSingleTag(tag) {
                clearPending();

                if (!navigator.geolocation) {
                    console.warn('[NFC] ⚠️ Trình duyệt không hỗ trợ geolocation');
                    requestPasswordThenRedirect(tag);
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        const lat = pos.coords.latitude.toFixed(6);
                        const lng = pos.coords.longitude.toFixed(6);
                        requestPasswordThenRedirect(tag, lat, lng);
                    },
                    function(err) {
                        console.warn('[NFC] ⚠️ Không lấy được vị trí:', err.message || err);
                        requestPasswordThenRedirect(tag);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            }

            // ✅ 3. LUỒNG XỬ LÝ CHÍNH
            const pending = getPendingTag();

            // 🧩 Trường hợp: có pending và tag KHÁC => đây là thẻ thứ 2 (ghép đôi)
            if (pending && pending !== tag) {
                const tagCombined = `${pending},${tag}`;
                clearPending();

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(pos) {
                        const lat = pos.coords.latitude.toFixed(6);
                        const lng = pos.coords.longitude.toFixed(6);
                        requestPasswordThenRedirect(tagCombined, lat, lng);
                    }, function() {
                        requestPasswordThenRedirect(tagCombined);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    requestPasswordThenRedirect(tagCombined);
                }
                return;
            }

            // 🧩 Trường hợp: chưa có pending => đây là thẻ đầu tiên
            savePendingTag(tag);

            // Hiển thị giao diện “đang chờ thẻ thứ 2”
            if (tag.includes(',')) {
                $('#loading').html(`
                    <div class="text-center p-6">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-pink-500 mx-auto mb-4"></div>
                        <p class="text-lg font-medium">Đã nhận cặp thẻ 💞</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Hãy họn hành động:
                        </p>
                        <div class="mt-4 flex gap-3 justify-center">
                            <button id="btnProceed" class="px-4 py-2 bg-pink-500 text-white rounded-xl">
                                Tiếp tục
                            </button>
                        </div>
                    </div>
                `);
            } else {
                // Trường hợp 1 thẻ
                console.log('[NFC] 💖 Đã nhận thẻ:', tag);
                $('#loading').html(`
                    <div class="text-center p-6">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-pink-500 mx-auto mb-4"></div>
                        <p class="text-lg font-medium">Đã nhận thẻ đầu tiên 💖</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Chạm thẻ đối tác trong 30s để ghép đôi hoặc chọn hành động:
                        </p>
                        <div class="mt-4 flex gap-3 justify-center">
                            <button id="btnProceed" class="px-4 py-2 bg-pink-500 text-white rounded-xl">
                                Tiếp tục (1 thẻ)
                            </button>
                        </div>
                    </div>
                `);
            }

            // 👉 Khi người dùng bấm “Tiếp tục”
            $(document).on('click', '#btnProceed', function() {
                proceedSingleTag(tag);
            });

            // ⏰ Sau 30s nếu chưa ghép đôi => tự động “Tiếp tục”
            setTimeout(function() {
                const stillPending = getPendingTag();
                if (stillPending === tag) {
                    proceedSingleTag(tag);
                }
            }, PAIR_TTL_MS + 200);

            // ✅ 4. HÀM PHỤ: hiển thị modal nhập địa điểm khi có 2 thẻ
            function showLocationNameModal(tagCombined, lat, lng) {
                $('#loading').addClass('hidden');
                $('#locationModal').removeClass('hidden');

                // Khi nhấn xác nhận
                $('#confirmBtn').off('click').on('click', function() {
                    const name = $('#locationNameInput').val().trim();
                    if (!name) {
                        $('#locationNameInput').addClass('border-red-400 ring-2 ring-red-200');
                        return;
                    }
                    redirect(tagCombined, lat, lng, name);
                });

                // ✅ Khi nhấn "Bỏ qua"
                $('#skipBtn').off('click').on('click', function() {
                    $('#locationModal').addClass('hidden'); // Ẩn modal
                    redirect(tagCombined, lat, lng, null); // Có thể truyền null hoặc chuỗi rỗng
                });
            }
        });
    </script>


    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.25s ease-out forwards;
        }
    </style>
</body>

</html>