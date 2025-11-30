<?php
$title = "Chỉnh sửa bài viết";
require_once __DIR__ . "/../components/editor.php";

// capture output
ob_start();
?>
<form action="<?= BASE_URL ?>/admin/posts/edit/<?= $post['id'] ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md space-y-4">

    <div class="space-y-1">
        <label for="titleInput" class="block font-medium text-gray-700">Tiêu đề</label>
        <input type="text" id="titleInput" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Tiêu đề"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>
    </div>

    <div class="space-y-1">
        <label for="slugInput" class="block font-medium text-gray-700">Slug SEO</label>
        <input type="text" id="slugInput" name="slug" value="<?= htmlspecialchars($post['slug']) ?>" placeholder="Slug SEO"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>
    </div>

    <div class="space-y-1">
        <label for="excerpt" class="block font-medium text-gray-700">Mô tả ngắn</label>
        <textarea id="excerpt" name="excerpt" placeholder="Mô tả ngắn" rows="3"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400"><?= htmlspecialchars($post['excerpt']) ?></textarea>
    </div>

    <div class="space-y-1">
        <label class="block font-medium text-gray-700">Nội dung</label>
        <?= render_editor("content", $post['content'], "300px") ?>
    </div>

    <div class="space-y-1">
        <label for="thumbnailInput" class="block font-medium text-gray-700">Ảnh bìa</label>
        <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

        <div id="thumbnailContainer" class="relative w-48 h-48 bg-gray-100 rounded-lg overflow-hidden shadow-sm <?= empty($post['thumbnail']) ? 'hidden' : '' ?>">
            <img id="thumbnailPreview"
                src="<?= !empty($post['thumbnail']) ? BASE_URL . $post['thumbnail'] : '' ?>"
                alt="Preview ảnh bìa"
                class="absolute top-0 left-0 w-full h-full object-cover <?= empty($post['thumbnail']) ? 'hidden' : '' ?>">

            <button type="button" id="removeThumbnailBtn"
                class="absolute top-2 right-2 bg-white bg-opacity-70 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-6 h-6 flex items-center justify-center shadow transition-colors duration-200"
                title="Xóa ảnh">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="space-y-1">
        <label for="read_time" class="block font-medium text-gray-700">Thời gian đọc</label>
        <input type="text" id="read_time" name="read_time" value="<?= htmlspecialchars($post['read_time']) ?>" placeholder="Thời gian đọc"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <div class="space-y-1">
        <label for="post_date" class="block font-medium text-gray-700">Ngày đăng</label>
        <input type="date" id="post_date" name="post_date" value="<?= htmlspecialchars($post['post_date']) ?>"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>
    </div>

    <div class="space-y-1">
        <label for="category_id" class="block font-medium text-gray-700">Danh mục</label>
        <select id="category_id" name="category_id" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400" required>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $post['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="space-y-1">
        <label for="meta_title" class="block font-medium text-gray-700">Meta title</label>
        <input type="text" id="meta_title" name="meta_title" value="<?= htmlspecialchars($post['meta_title']) ?>" placeholder="Meta title"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <div class="space-y-1">
        <label for="meta_description" class="block font-medium text-gray-700">Meta description</label>
        <input type="text" id="meta_description" name="meta_description" value="<?= htmlspecialchars($post['meta_description']) ?>" placeholder="Meta description"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <div class="space-y-1">
        <label for="meta_keywords" class="block font-medium text-gray-700">Meta keywords</label>
        <input type="text" id="meta_keywords" name="meta_keywords" value="<?= htmlspecialchars($post['meta_keywords']) ?>" placeholder="Meta keywords"
            class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <div class="space-y-1">
        <label for="status" class="block font-medium text-gray-700">Trạng thái</label>
        <select id="status" name="status" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-pink-400">
            <option value="published" <?= $post['status'] == 'published' ? 'selected' : '' ?>>Published</option>
            <option value="draft" <?= $post['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
        </select>
    </div>

    <button type="submit" class="bg-pink-500 text-white px-5 py-2 rounded hover:bg-pink-600 transition-all">
        Cập nhật bài viết
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
