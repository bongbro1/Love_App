<div class="max-w-5xl mx-auto p-6 bg-white shadow-xl fade-in transition-all duration-700 ease-out fade-section">
    <h2 class="text-3xl font-extrabold text-pink-600 mb-6 text-center">💞 Thông tin cặp đôi</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        <!-- Người dùng -->
        <div class="bg-pink-50 rounded-3xl p-6 shadow-inner relative text-center">
            <form id="userProfileForm" enctype="multipart/form-data">
                <!-- Avatar -->
                <div class="relative w-36 h-36 mx-auto mb-4 group">
                    <img id="userAvatarPreview"
                        src="<?= htmlspecialchars($user['avatar_url']) ?>"
                        class="w-36 h-36 rounded-full object-cover border-4 border-pink-300 mx-auto transition-transform duration-300 group-hover:scale-105"
                        alt="Avatar"
                        onclick='openImageModal(["<?= htmlspecialchars($user['avatar_url']) ?>"])'>
                    <label for="userAvatar"
                        class="absolute bottom-2 right-2 bg-pink-500 text-white p-2 rounded-full cursor-pointer hover:bg-pink-600 shadow-lg transition">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" name="avatar" id="userAvatar" class="hidden" accept="image/*">
                </div>

                <!-- Thông tin cá nhân -->
                <div class="space-y-3">
                    <input type="text" name="display_name"
                        value="<?= htmlspecialchars($user['display_name']) ?>"
                        class="w-full border border-pink-300 rounded-2xl p-3 text-center focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                        placeholder="Tên hiển thị">

                    <input type="email" name="email"
                        value="<?= htmlspecialchars($user['email']) ?>"
                        class="w-full border border-pink-300 rounded-2xl p-3 text-center focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                        placeholder="Email">

                    <input type="date" name="dob"
                        value="<?= htmlspecialchars($user['dob'] ?? '') ?>"
                        class="w-full border border-pink-300 rounded-2xl p-3 text-center focus:outline-none focus:ring-2 focus:ring-pink-400 transition">

                    <select name="gender"
                        class="w-full border border-pink-300 rounded-2xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                        <option value="male" <?= ($user['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= ($user['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= ($user['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>

                <button type="submit"
                    class="mt-5 w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white py-3 rounded-2xl font-bold shadow-md hover:from-pink-600 hover:to-rose-600 transition-all active:scale-95">
                    💌 Lưu thay đổi
                </button>
            </form>
        </div>

        <!-- Người thương -->
        <?php if (!empty($partner)): ?>
            <div class="bg-gradient-to-br from-rose-100 to-rose-50 rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-shadow duration-300 text-center relative">
                <div class="relative w-36 h-36 mx-auto mb-4 group">
                    <img src="<?= htmlspecialchars($partner['avatar_url'] ?? 'http://localhost:8080/love-app/public/images/default-avatar.png') ?>"
                        class="w-36 h-36 rounded-full object-cover border-4 border-rose-300 mx-auto transition-transform duration-300 group-hover:scale-105 shadow-md"
                        alt="Avatar"
                        onclick='openImageModal(["<?= htmlspecialchars($partner['avatar_url'] ?? 'http://localhost:8080/love-app/public/images/default-avatar.png') ?>"])'>
                </div>

                <h3 class="font-bold text-xl text-rose-700 mb-1"><?= htmlspecialchars($partner['display_name']) ?></h3>

                <?php if (!empty($partner['email'])): ?>
                    <p class="text-gray-500 text-sm mb-1">Ngày sinh: <?= htmlspecialchars($partner['email']) ?></p>
                <?php endif; ?>

                <p class="text-gray-500 text-sm mb-1">
                    Ngày sinh: <?= !empty($partner['dob']) ? (new DateTime($partner['dob']))->format('d/m/Y') : '' ?>
                </p>

                <p class="text-gray-500 text-sm mb-2">
                    Giới tính: <?= !empty($partner['gender']) ? htmlspecialchars($partner['gender']) : 'Khác' ?>
                </p>
                <span class="inline-block bg-rose-200 text-rose-800 text-sm px-3 py-1 rounded-full font-semibold shadow-sm">
                    Người thương 💗
                </span>
                <?php
                $loveScore = $partner['total_score'] ?? 0;
                if ($loveScore < 50) {
                    $loveRank = '💖 Người mới yêu';
                    $rankColor = 'bg-pink-200 text-pink-800';
                } elseif ($loveScore < 200) {
                    $loveRank = '💘 Nồng nàn';
                    $rankColor = 'bg-pink-300 text-pink-900';
                } elseif ($loveScore < 500) {
                    $loveRank = '💞 Thắm thiết';
                    $rankColor = 'bg-rose-300 text-rose-900';
                } else {
                    $loveRank = '💖 Vĩnh cửu';
                    $rankColor = 'bg-red-400 text-white';
                }
                ?>
                <div class="mt-3 p-3 rounded-2xl shadow-inner border border-rose-200 inline-block w-full">
                    <p class="font-semibold text-sm text-gray-600 mb-1">Điểm tình yêu: <span id="partner-love-score"><?= $loveScore ?></span></p>
                    <span class="inline-block <?= $rankColor ?> text-sm px-3 py-1 rounded-full font-semibold shadow-sm">
                        <?= $loveRank ?>
                    </span>
                </div>


            </div>

        <?php else: ?>
            <div class="col-span-1 md:col-span-2 text-center text-gray-400 italic mt-4">
                Chưa có người thương 🥹
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Preview avatar
        $('#userAvatar').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#userAvatarPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Submit form profile
        $('#userProfileForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            console.log("📦 FormData trước khi gửi:");
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: 'index.php?action=update_profile',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#userProfileForm button')
                        .prop('disabled', true)
                        .addClass('opacity-60')
                        .text('Đang lưu...');
                },
                success: function(res) {
                    console.log("✅ Server response:", res);

                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Cập nhật thông tin thành công',
                            confirmButtonColor: '#ec4899',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload trang sau khi OK
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: res.msg || 'Đã xảy ra lỗi trong quá trình cập nhật',
                            confirmButtonColor: '#ec4899'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("❌ AJAX error:", textStatus, errorThrown);
                    console.log("Response text:", jqXHR.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi kết nối!',
                        text: 'Không thể kết nối đến server. Vui lòng thử lại sau!',
                        confirmButtonColor: '#ec4899'
                    });
                },
                complete: function() {
                    $('#userProfileForm button')
                        .prop('disabled', false)
                        .removeClass('opacity-60')
                        .text('Lưu thay đổi');
                }
            });
        });
    });
</script>