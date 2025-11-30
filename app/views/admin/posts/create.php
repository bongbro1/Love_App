<?php
$title = "Thêm bài viết";
require_once __DIR__ . "/../components/editor.php";

// capture output
ob_start();
?>

<form action="<?= BASE_URL ?>/admin/posts/create" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md space-y-4">

        <input type="text" id="titleInput" name="title" placeholder="Tiêu đề"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>

        <input type="text" id="slugInput" name="slug" placeholder="Slug SEO"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>

        <textarea name="excerpt" placeholder="Mô tả ngắn" rows="3"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>

        <!-- Content dùng CKEditor -->
        <div class="w-full">
            <label class="block mb-1 font-medium text-gray-700">Nội dung</label>
            <?= render_editor("content", $data['content'] ?? "", "300px") ?>
        </div>

        <!-- Thumbnail -->
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Ảnh bìa</label>
            <input type="file" name="thumbnail" id="thumbnailInput"
                class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                accept="image/*">

            <!-- Preview container chỉ hiện khi có ảnh -->
            <div id="thumbnailContainer" class="relative w-48 h-48 bg-gray-100 rounded-lg overflow-hidden shadow-sm <?= empty($data['thumbnail']) ? 'hidden' : '' ?>">
                <img id="thumbnailPreview" src="<?= $data['thumbnail'] ?? '' ?>"
                    alt="Preview ảnh bìa"
                    class="absolute top-0 left-0 w-full h-full object-cover">

                <!-- Nút Remove -->
                <button type="button" id="removeThumbnailBtn"
                    class="absolute top-2 right-2 bg-white bg-opacity-70 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-6 h-6 flex items-center justify-center shadow transition-colors duration-200"
                    title="Xóa ảnh">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <input type="text" name="read_time" placeholder="Thời gian đọc"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

        <input type="date" name="post_date"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>

        <select name="category_id" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="meta_title" placeholder="Meta title"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

        <input type="text" name="meta_description" placeholder="Meta description"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

        <input type="text" name="meta_keywords" placeholder="Meta keywords"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

        <select name="status" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>

        <button type="submit" class="bg-pink-500 text-white px-5 py-2 rounded hover:bg-pink-600 transition-all">
            Lưu bài viết
        </button>
    </form>

<script>
    $(function() {

        // Hàm loại bỏ dấu tiếng Việt
        function removeVietnameseTones(str) {
            str = str.toLowerCase();
            str = str.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, "a");
            str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, "e");
            str = str.replace(/i|í|ì|ỉ|ĩ|ị/g, "i");
            str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, "o");
            str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, "u");
            str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, "y");
            str = str.replace(/đ/g, "d");
            str = str.replace(/[^a-z0-9\s-]/g, ""); // loại bỏ ký tự đặc biệt
            str = str.replace(/\s+/g, "-"); // thay khoảng trắng bằng dấu -
            str = str.replace(/-+/g, "-"); // gộp các dấu - liên tiếp
            return str;
        }

        // Tự động gen slug khi nhập tiêu đề
        $('#titleInput').on('input', function() {
            $('#slugInput').val(removeVietnameseTones($(this).val()));
        });

        // Thumbnail preview và remove
        const $input = $('#thumbnailInput');
        const $container = $('#thumbnailContainer');
        const $preview = $('#thumbnailPreview');
        const $removeBtn = $('#removeThumbnailBtn');

        $input.on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $preview.attr('src', e.target.result);
                    $container.removeClass('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                $preview.attr('src', '');
                $container.addClass('hidden');
            }
        });

        $removeBtn.on('click', function() {
            $input.val('');
            $preview.attr('src', '');
            $container.addClass('hidden');
        });

    });
</script>

<?php
$content = ob_get_clean();

// load layout
require __DIR__ . '/../layout/layout.php';
