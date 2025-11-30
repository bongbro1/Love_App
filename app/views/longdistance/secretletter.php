<!-- Secret Letter Section -->
<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="secret-letter" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 py-4 px-2">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Thư Bí Mật</h2>
            <div class="flex flex-col gap-6">
                <!-- Input Box -->
                <div>
                    <textarea id="secretText" class="w-full h-28 md:h-36 p-3 md:p-4 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/80 backdrop-blur-sm text-sm md:text-base" placeholder="Viết thư bí mật..."></textarea>
                    <div class="mt-4 md:mt-6">
                        <label class="block text-gray-600 font-medium mb-1 text-sm md:text-base">Chọn ngày mở thư:</label>
                        <input type="date" id="openDate" class="w-full p-3 md:p-4 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/80 backdrop-blur-sm text-sm md:text-base" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mt-4 flex justify-center">
                        <button
                            id="saveSecret"
                            class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 py-3 rounded-full text-sm md:text-base sparkle-button">
                            💌 Gửi thư
                        </button>
                    </div>
                </div>

                <!-- Preview Box -->
                <div id="secretPreview" class="p-6 md:p-8 bg-gradient-to-br from-pink-50 to-rose-100/70 rounded-2xl text-center border border-pink-100 shadow-sm">
                    <div class="flex flex-col items-center space-y-3">
                        <div class="text-4xl animate-bounce">💌</div>
                        <p class="text-pink-600 font-semibold text-lg">Chưa có thư nào được gửi...</p>
                        <p class="text-gray-600 text-sm">Hãy viết vài dòng yêu thương và hẹn ngày mở thư cùng nhau nhé 💖</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<div id="secretModal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div
        class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 max-w-lg w-[90%] transform scale-95 transition-all duration-300"
        id="secretModalContent">
        <h3 class="text-2xl md:text-3xl font-semibold text-pink-600 mb-3 text-center" id="secretTitle"></h3>

        <div class="mb-3 text-center text-gray-500 text-xs italic" id="secretMeta"></div>
        <p id="secretModalBody"
            class="text-gray-700 whitespace-pre-line text-sm md:text-base leading-relaxed text-center
          max-h-[10rem] overflow-y-auto no-scrollbar px-2">
        </p>

        <div class="mt-6 flex justify-center">
            <button id="closeSecretModal"
                class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 py-2 md:py-3 rounded-full text-sm md:text-base hover:shadow-lg hover:scale-105 transition">
                Đóng lại
            </button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>


<script>
    import { showLoading, hideLoading } from './utils/ui.js';
    // secret-letter
    $(document).ready(() => {
        const saveBtn = $('#saveSecret');
        const saveMediaBtn = $('#saveMediaSecret');
        const textArea = $('#secretText');
        const fileInput = $('#secretFile');
        const dateInput = $('#openDate');
        const dateMediaInput = $('#openDateMedia');
        const previewBox = $('#secretPreview');
        const sentList = $('#sent-list');
        const previewTitle = $('#previewTitle');
        const previewCountdown = $('#previewCountdown');
        const openBtn = $('#openSecret');

        saveBtn.on('click', function() {
            const text = textArea.val().trim();
            const openDate = dateInput.val();

            if (!text || !openDate) {
                alert('Hãy nhập nội dung và chọn ngày mở thư.');
                return;
            }
            if (text) {
                // Gửi lên server lưu
                $.ajax({
                    url: 'index.php?action=secret_send',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        text,
                        open_date: openDate
                    },
                    success: function(res) {
                        if (!res.success) {
                            alert('Gửi thư thất bại!');
                            return;
                        }

                        textArea.val('');
                        dateInput.val('');
                        Swal.fire({
                            icon: 'success',
                            title: "Thông báo",
                            text: "Gửi thư thành công",
                            timer: 2000,
                            showConfirmButton: true
                        });
                    },
                    error: err => console.error(err)
                });
            }

        });
        saveMediaBtn.on('click', async function() {
            const file = fileInput[0].files[0];
            const openDateMedia = dateMediaInput.val();


            if (!file || !openDateMedia) {
                alert('Hãy nhập nội dung và chọn ngày mở thư.');
                return;
            }
            if (file) {
                showLoading();

                try {
                    const uploadResult = await uploadFileInChunks(file, {
                        url: 'index.php?action=secret_media_chunk',
                        chunkSize: 5 * 1024 * 1024, // 5MB
                        extraData: {
                            unlock_at: openDateMedia,
                            type: file.type.startsWith('video') ? 'video' : 'audio'
                        },
                        onProgress: (p) => {}
                    });
                    if (uploadResult && uploadResult.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'Gửi thành công',
                            timer: 2000,
                            showConfirmButton: true
                        });
                    }

                } catch (err) {
                    if (err.responseText) {
                        console.error('📄 Server trả về:', err.responseText);
                    }
                } finally {
                    hideLoading();
                }
            }

        });

        function markLetterAsOpened(letterId) {
            $.ajax({
                url: 'index.php?action=secret_open',
                type: 'POST',
                dataType: 'json',
                data: {
                    letter_id: letterId
                },
                success: function(res) {},
                error: err => console.error('Lỗi khi cập nhật trạng thái:', err)
            });
        }

        function showSecretModal(letter) {
            const modal = $('#secretModal');
            const content = $('#secretModalContent');
            const body = $('#secretModalBody');
            const title = $('#secretTitle');

            title.text(letter.title);

            if (letter.type === 'text' || !letter.type) body.text(letter.body);
            else if (letter.type === 'video')
                body.html(`<video id="secretMedia" controls class="w-full max-h-72"><source src="/love-app/public/${letter.file_url}" type="video/mp4">Trình duyệt không hỗ trợ video</video>`);
            else if (letter.type === 'audio')
                body.html(`<audio id="secretMedia" controls class="w-full"><source src="/love-app/public/${letter.file_url}" type="audio/mpeg">Trình duyệt không hỗ trợ audio</audio>`);

            modal.removeClass('hidden');
            setTimeout(() => content.addClass('modal-show'), 10);
            $('body').addClass('overflow-hidden');

            // --- Đóng modal ---
            const closeModal = () => {
                // 🔇 Dừng playback nếu có media
                const media = document.getElementById('secretMedia');
                if (media) {
                    media.pause();
                    media.currentTime = 0;
                }

                // Ẩn modal
                content.removeClass('modal-show');
                setTimeout(() => {
                    modal.addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                }, 200);
            };

            $('#closeSecretModal').off('click').on('click', closeModal);

            // Click ra ngoài vùng nội dung cũng đóng
            modal.off('click').on('click', e => {
                if (e.target === modal[0]) closeModal();
            });
        }

        function updateSecretPreview(letter) {
            const now = new Date();
            const target = new Date(letter.unlock_at);
            const diffDays = Math.ceil((target - now) / (1000 * 60 * 60 * 24));

            let contentHtml = letter.body || '';
            if (letter.type === 'video') contentHtml = '📹 Video được gửi';
            else if (letter.type === 'audio') contentHtml = '🎵 Voice được gửi';

            const html = `
                    <div class="relative overflow-hidden p-6 rounded-2xl border border-pink-200 bg-gradient-to-br from-pink-50 to-rose-100/70 shadow-sm">
                        <div class="absolute -top-3 -right-3 text-3xl opacity-30 select-none">💌</div>
                        <div class="text-center space-y-2">
                            <p class="font-semibold text-base md:text-lg text-pink-700">
                                ${diffDays > 0 ? 'Thư đang chờ được mở...' : 'Thư sẵn sàng để đọc 💖'}
                            </p>
                            <p class="text-gray-600 text-sm">Mở ngày: <span class="font-medium text-pink-600">${target.toLocaleDateString('vi-VN')}</span></p>
                            <p class="text-xs md:text-sm italic text-gray-500">
                                ${diffDays > 0 ? `⏳ Còn ${diffDays} ngày nữa...` : '✨ Đã đến lúc mở thư rồi!'}
                            </p>
                            <div class="pt-4">
                                <button id="openSecret" class="px-5 py-2.5 rounded-full text-sm md:text-base transition-all duration-300
                                    ${diffDays > 0 ? 'bg-gray-200 text-gray-500 cursor-not-allowed opacity-80' : 'bg-gradient-to-r from-pink-500 via-rose-400 to-purple-500 text-white shadow-md hover:shadow-lg scale-105 hover:scale-110'}"
                                    ${diffDays > 0 ? 'disabled' : ''}>
                                    ${diffDays > 0 ? 'Chưa thể mở' : '💌 Mở thư ngay'}
                                </button>
                            </div>
                        </div>
                    </div>
                `;

            $('#secretPreview').html(html);

            if (diffDays <= 0) {
                $('#openSecret').on('click', () => {
                    showSecretModal(letter);
                    markLetterAsOpened(letter.id, !!letter.type); // text=false, media=true
                    loadSecretLetter();
                });
            }
        }


        function loadSecretLetter() {
            $.ajax({
                url: 'index.php?action=secret_list',
                type: 'GET',
                dataType: 'json',
                success: function(res) {

                    const previewBox = $('#secretPreview');
                    if (!res.success || !res.letter) {
                        previewBox.html(`
                                <div class="flex flex-col items-center space-y-3">
                                    <div class="text-4xl animate-bounce">💌</div>
                                    <p class="text-pink-600 font-semibold text-lg">Chưa có thư nào được gửi...</p>
                                    <p class="text-gray-600 text-sm">Hãy viết vài dòng yêu thương và hẹn ngày mở thư cùng nhau nhé 💖</p>
                                </div>
                            `);
                        return;
                    }
                    updateSecretPreview(res.letter);
                },
                error: err => console.error('Lỗi tải thư bí mật:', err)
            });
        }
        // --- Load danh sách video/voice ---
        function loadMediaLetter() {
            $.ajax({
                url: 'index.php?action=secret_media_list',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    sentList.empty();
                    if (!res.success || !res.letter) {
                        sentList.html(`<p class="text-gray-500 text-center">Chưa có video/voice nào.</p>`);
                        return;
                    }

                    const letter = res.letter;
                    const now = new Date();
                    const unlock = new Date(letter.unlock_at);
                    const diffDays = Math.ceil((unlock - now) / (1000 * 60 * 60 * 24));

                    // 🧩 Template hiển thị
                    const html = `
                            <div class="relative overflow-hidden p-6 rounded-2xl border border-pink-200 bg-gradient-to-br from-pink-50 to-rose-100/70 shadow-sm">
                                <div class="absolute -top-3 -right-3 text-3xl opacity-30 select-none">💌</div>
                                <div class="text-center space-y-2">
                                    <p class="font-semibold text-base md:text-lg text-pink-700">
                                        ${diffDays > 0 ? 'Thư đang chờ mở...' : '💖 Thư đã sẵn sàng!'}
                                    </p>
                                    <p class="text-gray-600 text-sm">Mở ngày: 
                                        <span class="font-medium text-pink-600">${unlock.toLocaleDateString('vi-VN')}</span>
                                    </p>
                                    <p class="text-xs md:text-sm italic text-gray-500">
                                        ${diffDays > 0 ? `⏳ Còn ${diffDays} ngày nữa...` : '✨ Đã đến lúc mở rồi!'}
                                    </p>
                                    <div class="pt-3">
                                        <button id="openMedia" class="px-5 py-2.5 rounded-full text-sm md:text-base transition-all duration-300
                                            ${diffDays > 0
                        ? 'bg-gray-200 text-gray-500 cursor-not-allowed opacity-80'
                        : 'bg-gradient-to-r from-pink-500 via-rose-400 to-purple-500 text-white shadow-md hover:shadow-lg scale-105 hover:scale-110'}"
                                            ${diffDays > 0 ? 'disabled' : ''}>
                                            ${diffDays > 0 ? '🔒 Chưa thể mở' : '💌 Mở ngay'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;

                    sentList.html(html);

                    // 🎧 Khi có thể mở, xử lý sự kiện click
                    if (diffDays <= 0) {
                        $('#openMedia').on('click', function() {
                            showSecretModal(letter);
                            markLetterAsOpened(letter.id);
                            loadMediaLetter();
                        });
                    }
                },
                error: err => {
                    console.error('🔥 Lỗi tải media letter:', err);
                    sentList.html(`<p class="text-red-500 text-center">Không thể tải thư media.</p>`);
                }
            });
        }


        loadSecretLetter();
        loadMediaLetter();

    });
</script>