<!-- Memories Section -->
<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="memories" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 px-4 py-6 md:px-0 md:py-0">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Album Kỷ Niệm</h2>
            <div class="flex justify-center mb-8">
                <button id="add-memory-btn"
                    class="bg-gradient-to-r from-pink-400 to-pink-500 text-white px-8 py-3 rounded-full shadow-md hover:scale-105 hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                    <i class="fas fa-plus text-lg"></i>
                    Thêm khoảnh khắc
                </button>
            </div>
            <div class="relative">
                <!-- Đường dọc giữa -->
                <div class="absolute left-1/2 top-0 bottom-0 w-[3px] bg-pink-200 rounded-full -translate-x-1/2"></div>

                <!-- Kỷ niệm sẽ append vào đây -->
                <div id="memories-grid" class="flex flex-col relative z-10"></div>
            </div>
        </div>
    </section>

</main>
<?php include __DIR__ . '/../components/navbar_nearlove.php'; ?>

<!-- 🌸 Modal Thêm Kỷ Niệm -->
<div id="add-memory-modal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

    <!-- Modal content -->
    <div id="memory-modal-content"
        class="bg-gradient-to-br from-pink-50 to-white rounded-2xl shadow-2xl w-11/12 md:w-2/5 p-6 relative">

        <!-- Close Button -->
        <button id="close-memory-modal"
            class="absolute top-3 right-5 text-gray-400 hover:text-pink-500 transition">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Title -->
        <div class="text-center mb-6 mt-2">
            <h3 class="text-2xl font-bold text-pink-600 mb-1">Thêm Khoảnh Khắc 💞</h3>
            <p class="text-gray-500 text-sm">Lưu giữ khoảnh khắc đáng nhớ của hai bạn</p>
        </div>

        <!-- Form -->
        <form id="memory-form" enctype="multipart/form-data" class="space-y-5 px-1 max-h-[60vh] overflow-y-auto">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Tiêu đề</label>
                <input type="text" name="title"
                    class="w-full border border-pink-200 rounded-full px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow-sm"
                    placeholder="Ví dụ: Hẹn hò đầu tiên 💐" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Mô tả</label>
                <textarea name="description" rows="3"
                    class="w-full border border-pink-200 rounded-2xl px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow-sm"
                    placeholder="Viết vài dòng cảm xúc của bạn..."></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block font-semibold text-gray-700 mb-1">Ngày diễn ra</label>
                    <input type="date" name="event_date"
                        class="w-full border border-pink-200 rounded-full px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow-sm">
                </div>

                <div class="flex-1">
                    <label class="block font-semibold text-gray-700 mb-1">Ảnh kỷ niệm</label>
                    <input type="file" name="photos[]" id="memory-photo-input" accept="image/*" multiple
                        class="w-full border border-pink-200 rounded-full px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow-sm" required>
                </div>
            </div>

            <!-- Preview ảnh -->
            <div id="photo-preview" class="hidden mt-3 text-center">
            </div>

            <div class="text-center pt-4">
                <button type="submit"
                    class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-8 py-3 rounded-full shadow-md hover:scale-105 transition duration-300 font-semibold cursor-pointer">
                    <i class="fas fa-heart mr-2"></i> Lưu kỷ niệm
                </button>
            </div>
        </form>
    </div>
</div>

<div id="memory-detail-modal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex flex-col justify-end">

    <!-- Nội dung modal -->
    <div
        class="bg-gradient-to-b from-white to-pink-50 rounded-t-3xl shadow-2xl w-full p-6 relative animate-slideUp border-t border-pink-100 modal-show">

        <!-- Thanh nhỏ phía trên (drag indicator style) -->
        <div class="w-12 h-1.5 bg-pink-200 rounded-full mx-auto mb-3"></div>

        <!-- Nút đóng -->
        <button id="close-memory-detail"
            class="absolute top-3 right-5 text-gray-400 hover:text-pink-500 transition">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="max-h-[80vh] overflow-y-auto pt-3">
            <!-- Ảnh -->
            <div class="w-full flex flex-col items-center mb-5">
                <img id="detail-image" src="" alt="Memory"
                    class="rounded-2xl shadow-md max-h-[55vh] object-contain border border-pink-100 w-full mb-3">

                <!-- Dot navigation -->
                <div id="image-dots" class="flex gap-2"></div>
            </div>

            <!-- Tiêu đề -->
            <h3 id="detail-title" class="text-xl font-bold text-pink-600 text-center mb-2">
                Hẹn hò đầu tiên 💞
            </h3>

            <!-- Ngày -->
            <p id="detail-date" class="text-center text-gray-500 text-sm mb-4 italic">
                15/10/2025
            </p>

            <!-- Mô tả -->
            <div
                id="detail-description"
                class="text-gray-700 leading-relaxed text-center whitespace-pre-line px-2">
                Một ngày thật đặc biệt bên người thương 💗 cùng nụ cười và tách cà phê thơm ngát...
            </div>

            <div class="h-3"></div>
        </div>
    </div>
</div>

<script>
    // memories
    $(function() {

        // 🧭 Load dữ liệu album
        function loadMemories() {
            $.ajax({
                url: 'index.php?action=memory_fetch_data',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    const $grid = $('#memories-grid');
                    $grid.empty();

                    const memories = res.memories || [];
                    const visibleCount = 2; // hiển thị trước 5 memories đầu
                    const toShow = memories.slice(0, visibleCount);

                    renderMemories($grid, toShow);

                    if (memories.length > visibleCount) {
                        $grid.append(`
                                <div class="flex justify-center">
                                    <button id="load-more-memories"
                                    class="px-6 py-2 bg-white border border-pink-400 text-pink-600 rounded-full hover:bg-pink-50 transition">
                                    Xem thêm kỷ niệm 💕
                                    </button>
                                </div>
                            `);

                        $('#load-more-memories').on('click', function() {
                            renderMemories($grid, memories.slice(visibleCount));
                            $(this).remove();
                        });
                    }
                }
            });
        }

        function renderMemories($grid, data) {
            data.forEach((m, index) => {

                const isRight = index % 2 !== 0;
                const title = m.title || 'Kỷ niệm';
                const desc = m.description || '';
                const date = m.event_date || '';
                const imagesArray = m.media_urls && m.media_urls.length ?
                    m.media_urls.map(u => `${BASE_URL}/${u.replace(/^\/+/, '')}`) :
                    [`${BASE_URL}/assets/default-memory.jpg`];

                const imagesJSON = JSON.stringify(imagesArray);
                // 🧠 Không rely vào gap -> tự thêm margin-bottom
                const itemHTML = `
                        <div class="relative flex flex-col ${isRight ? 'items-end text-right' : 'items-start text-left'} 
                                    group memory-item cursor-pointer animate-fadeUp mb-4 last:mb-0"
                            data-title="${title}"
                            data-description="${desc}"
                            data-date="${date}"
                            data-images='${imagesJSON}'>

                            <!-- Dấu chấm giữa -->
                            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-pink-500 rounded-full border-4 border-white shadow"></div>

                            <!-- Ảnh -->
                            <div class="relative w-[85%] rounded-2xl overflow-hidden shadow-lg ${isRight ? 'ml-auto' : 'mr-auto'}">
                            <img src="${imagesArray[0]}" alt="${title}"
                                class="w-full h-60 object-cover transform transition duration-500 group-hover:scale-105 rounded-xl">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 
                                        group-hover:opacity-100 transition duration-300 flex items-end justify-center 
                                        text-white p-3 text-center">
                                <p class="font-semibold text-sm">${title}<br>${date}</p>
                            </div>
                            </div>
                        </div>
                    `;
                $grid.append(itemHTML);
            });
        }


        // Cuộn ngang mượt
        $('#mem-next').on('click', () => {
            const scroll = $('#memories-scroll')[0];
            scroll.scrollBy({
                left: 320,
                behavior: 'smooth'
            });
        });

        $('#mem-prev').on('click', () => {
            const scroll = $('#memories-scroll')[0];
            scroll.scrollBy({
                left: -320,
                behavior: 'smooth'
            });
        });

        // 🚀 Khởi động
        loadMemories();


        // detail
        let memoryImages = [];
        let currentImageIndex = 0;

        function openMemoryDetailModal(images, title, desc, date, startIndex = 0) {
            memoryImages = images;
            currentImageIndex = startIndex;

            $('#detail-title').text(title || 'Kỷ niệm');
            $('#detail-description').text(desc || 'Không có mô tả.');
            $('#detail-date').text(date ? `Ngày diễn ra: ${date}` : '');

            renderDots();
            updateDetailImage();

            $('#memory-detail-modal').removeClass('hidden').addClass('flex');
        }

        function updateDetailImage() {
            if (!memoryImages.length) return;
            let imgSrc = memoryImages[currentImageIndex];
            $('#detail-image').attr('src', imgSrc);

            // Cập nhật active dot
            $('#image-dots span').removeClass('bg-pink-600').addClass('bg-gray-300');
            $(`#dot-${currentImageIndex}`).removeClass('bg-gray-300').addClass('bg-pink-600');
        }

        function renderDots() {
            const $dots = $('#image-dots');
            $dots.empty();
            memoryImages.forEach((img, index) => {
                const $dot = $('<span></span>', {
                    id: `dot-${index}`,
                    class: 'w-3 h-3 rounded-full bg-gray-300 cursor-pointer',
                    click: () => {
                        currentImageIndex = index;
                        updateDetailImage();
                    }
                });
                $dots.append($dot);
            });
        }

        // Khi click vào 1 ảnh memory
        $(document).on('click', '.memory-item', function() {
            const title = $(this).data('title');
            const desc = $(this).data('description');
            const date = $(this).data('date');
            const images = $(this).data('images'); // mảng ảnh

            openMemoryDetailModal(images, title, desc, date, 0);
        });

        // Đóng modal
        $('#close-memory-detail, #memory-detail-modal').on('click', function(e) {
            const $modal = $('#memory-detail-modal');

            // Nếu click vào overlay (modal nền) hoặc vào nút đóng (hoặc phần tử con trong đó)
            if (
                $(e.target).is('#memory-detail-modal') ||
                $(e.target).closest('#close-memory-detail').length
            ) {
                $modal.addClass('hidden').removeClass('flex');
            }
        });

        function AddMemoryModal() {
            const $modal = $('#add-memory-modal');
            const $content = $('#memory-modal-content');

            // 🟢 Mở modal
            $(document).on('click', '#add-memory-btn', function() {
                $modal.removeClass('hidden').addClass('flex');
                $content.addClass('modal-show');
            });

            // 🔴 Đóng modal (nút X hoặc click overlay)
            $(document).on('click', '#close-memory-modal', function() {
                closeModal();
            });

            $(document).on('click', '#add-memory-modal', function(e) {
                // Nếu click vào overlay (ngoài modal-content)
                if (e.target === this) {
                    closeModal();
                }
            });

            //show ảnh preview
            const $photoInput = $('#memory-photo-input');
            const $previewContainer = $('#photo-preview');
            const selectedImages = [];

            $photoInput.on('change', function() {
                const files = this.files;
                $previewContainer.empty();
                selectedImages.length = 0;
                if (files.length > 0) $previewContainer.removeClass('hidden');

                const $row = $('<div class="flex flex-wrap"></div>'); // flex container

                $.each(files, function(index, file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        selectedImages.push(e.target.result);
                        const $imgWrapper = $('<div class="w-1/2 p-1 box-border"></div>'); // mỗi ảnh 50%
                        const $img = $('<img>', {
                            src: e.target.result,
                            class: 'max-h-56 w-full rounded-xl shadow-md border border-pink-100 cursor-pointer',
                            click: function() {
                                openImageModal(selectedImages, index);
                            }
                        });
                        $imgWrapper.append($img);
                        $row.append($imgWrapper);
                    };
                    reader.readAsDataURL(file);
                });

                $previewContainer.append($row);
            });



            function closeModal() {
                $content.removeClass('modal-show');
                // đợi animation biến mất rồi ẩn modal
                setTimeout(() => {
                    $modal.addClass('hidden').removeClass('flex');
                }, 200);
            }

            // 🧷 Submit form thêm kỷ niệm
            $('#memory-form').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: 'index.php?action=memory_upload',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            closeModal();
                            loadMemories();
                            Swal.fire({
                                icon: 'success',
                                title: "Thông báo",
                                text: "Lưu thành công",
                                timer: 2000,
                                showConfirmButton: true
                            });
                        } else {
                            alert('⚠️ Lỗi: ' + res.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Lỗi khi upload:', error);
                        console.log('Phản hồi:', xhr.responseText);
                        alert('❌ Không thể upload kỷ niệm. Kiểm tra console để xem chi tiết.');
                    }
                });
            });
        }


        AddMemoryModal();
    });
</script>