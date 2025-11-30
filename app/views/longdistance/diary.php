<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="diary" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 py-4 px-2">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Nhật ký tình yêu</h2>
            <div class="flex flex-col gap-6 ">
                <!-- Input -->
                <div>
                    <input type="text" id="diary-title" placeholder="Tiêu đề (tuỳ chọn)"
                        class="w-full p-3 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none text-sm md:text-base mb-4">
                    <textarea id="diary-content" class="w-full h-28 md:h-36 p-3 md:p-4 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/80 backdrop-blur-sm text-sm md:text-base" placeholder="Viết nhật ký hôm nay..."></textarea>
                    <button id="diary-save-btn" class="mt-4 md:mt-6 w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-3 md:px-8 md:py-3 rounded-full sparkle-button ripple text-sm md:text-base transition duration-300">
                        Lưu Nhật Ký
                    </button>
                </div>
                <!-- Filter -->
                <div class="relative w-48 mb-4 mx-auto">
                    <select id="diary-filter" class="appearance-none w-full bg-white border border-pink-300 rounded-xl px-4 py-2 pr-8 text-gray-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        <option value="all">Tất cả</option>
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>

                    <!-- Mũi tên custom -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Entries -->
                <div id="diary-entries" class="space-y-4 max-h-[20rem] overflow-y-auto no-scrollbar pr-2"></div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>


<script>
    // Love Diary
    $(document).ready(() => {

        // === Modal Function ===
        function showDiaryModal(entry) {
            const modal = $('#secretModal');
            const content = $('#secretModalContent');
            const body = $('#secretModalBody');
            const title = $('#secretTitle');
            const metaEl = $('#secretMeta');

            title.text(entry.title);
            body.text(entry.content);
            metaEl.text(`${entry.author_name} - ${new Date(entry.created_at).toLocaleDateString('vi-VN')}`);

            modal.removeClass('hidden');
            setTimeout(() => content.addClass('modal-show'), 10);
            $('body').addClass('overflow-hidden');

            $('#closeSecretModal').off('click').on('click', () => {
                content.removeClass('modal-show');
                modal.addClass('hidden');
                $('body').removeClass('overflow-hidden');
            });

            // Đóng khi click ra ngoài modal
            modal.off('click').on('click', e => {
                if (e.target === modal[0]) $('#closeSecretModal').click();
            });
        }

        // === Load diary entries ===
        function loadEntries(period = 'all') {
            $.ajax({
                url: 'index.php?action=diary_load',
                type: 'GET',
                dataType: 'json',
                data: {
                    period
                },
                success: function(entries) {
                    const container = $('#diary-entries');
                    container.empty();

                    if (!entries.length) {
                        container.append('<p class="text-gray-500 italic text-center">Chưa có nhật ký nào</p>');
                        return;
                    }

                    entries.forEach(entry => {
                        const isMine = entry.author_id === userId;
                        const html = `
                                <div class="p-4 md:p-6 bg-pink-50/80 rounded-xl backdrop-blur-sm cursor-pointer relative"
                                    data-id="${entry.id}"
                                    data-title="${encodeURIComponent(entry.title)}"
                                    data-content="${encodeURIComponent(entry.content)}"
                                    data-author="${encodeURIComponent(entry.author_name)}"
                                    data-date="${entry.created_at}">

                                    <p class="font-semibold text-sm md:text-lg">${entry.title}</p>
                                    <p class="text-gray-600 text-xs md:text-sm line-clamp-2">${entry.content}</p>

                                    ${isMine ? `
                                    <div class="absolute top-2 right-2 flex gap-2">
                                        <button class="diary-edit text-blue-500 text-sm hover:underline">Sửa</button>
                                        <button class="diary-delete text-red-500 text-sm hover:underline">Xóa</button>
                                    </div>
                                    ` : ''}
                                </div>
                            `;
                        container.append(html);
                    });

                    // Hiển thị modal khi click vào entry
                    container.find('[data-content]').off('click').on('click', function() {
                        const titleText = decodeURIComponent($(this).data('title'));
                        const contentText = decodeURIComponent($(this).data('content'));
                        const author = decodeURIComponent($(this).data('author'));
                        const date = $(this).data('date');

                        showDiaryModal({
                            title: titleText,
                            content: contentText,
                            author_name: author,
                            created_at: date
                        });
                    });

                    // Xóa
                    container.find('.diary-delete').off('click').on('click', function(e) {
                        e.stopPropagation();
                        const parent = $(this).closest('[data-id]');
                        const id = parent.data('id');

                        Swal.fire({
                            title: 'Thông báo',
                            text: 'Bạn có chắc muốn xóa nhật ký này?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#9ca3af',
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'index.php?action=diary_delete',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id
                                    },
                                    success: function(res) {
                                        if (res.success) {
                                            parent.remove();
                                            Swal.fire({
                                                title: 'Thông báo',
                                                text: 'Đã xóa nhật ký!',
                                                icon: 'success',
                                                timer: 2000,
                                                showConfirmButton: false
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Thông báo',
                                                text: res.message || 'Xóa thất bại!',
                                                icon: 'error'
                                            });
                                        }
                                    },
                                    error: function() {
                                        Swal.fire({
                                            title: 'Thông báo',
                                            text: 'Không thể kết nối tới server!',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    });

                    // Sửa
                    container.find('.diary-edit').off('click').on('click', function(e) {
                        e.stopPropagation();
                        const parent = $(this).closest('[data-id]');
                        const id = parent.data('id');
                        const title = decodeURIComponent(parent.data('title'));
                        const content = decodeURIComponent(parent.data('content'));

                        // Đổ dữ liệu vào form hiện tại
                        $('#diary-title').val(title);
                        $('#diary-content').val(content);
                        $('#diary-save-btn').data('edit-id', id); // lưu id để khi lưu biết là sửa
                    });
                },
                error: function(err) {
                    console.error('Không thể load nhật ký:', err);
                }
            });
        }

        // === Save diary ===
        $('#diary-save-btn').on('click', function() {
            const title = $('#diary-title').val();
            const content = $('#diary-content').val();
            if (!content.trim()) return alert('Nhập nội dung nhật ký trước khi lưu!');

            const editId = $(this).data('edit-id'); // nếu có id thì là sửa
            const action = editId ? 'diary_update' : 'diary_save';
            const data = editId ? {
                id: editId,
                title,
                content
            } : {
                title,
                content
            };

            $.ajax({
                url: 'index.php?action=' + action,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: editId ? 'Sửa nhật ký thành công' : 'Thêm nhật ký thành công',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#diary-title').val('');
                        $('#diary-content').val('');
                        $('#diary-save-btn').removeData('edit-id'); // reset sau khi sửa xong
                        loadEntries($('#diary-filter').val());
                    } else {
                        alert(res.message || 'Có lỗi xảy ra!');
                    }
                },
                error: err => console.error('Không thể lưu nhật ký:', err)
            });
        });


        // === Filter diary ===
        $('#diary-filter').on('change', function() {
            loadEntries($(this).val());
        });

        // === Load lần đầu ===
        loadEntries();
    });
</script>