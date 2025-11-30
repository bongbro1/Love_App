<?php
// Page title
$title = "Cấu Hình SEO";
require_once __DIR__ . "/../components/editor.php";

ob_start();
?>
<div class="space-y-6">

    <form action="<?= BASE_URL ?>/admin/seo/update" method="POST" class="space-y-5 bg-white p-6 rounded shadow">

        <div class="space-y-2">
            <label class="font-medium">Meta Title</label>
            <input type="text"
                name="meta_title"
                value="<?= htmlspecialchars($data['meta_title']) ?>"
                class="w-full border p-2 rounded focus:outline-pink-400">
        </div>

        <div class="space-y-2">
            <label class="font-medium">Meta Description</label>
            <?= render_editor("meta_description", $data['meta_description'], "300px") ?>
        </div>


        <div class="space-y-2">
            <label class="font-medium">Từ khóa (Keywords)</label>
            <input type="text"
                name="keywords"
                value="<?= htmlspecialchars($data['keywords']) ?>"
                class="w-full border p-2 rounded focus:outline-pink-400">
        </div>

        <div class="space-y-2">
            <label class="font-medium">Ảnh chia sẻ (OG Image URL)</label>
            <input type="text"
                name="og_image"
                value="<?= htmlspecialchars($data['og_image']) ?>"
                class="w-full border p-2 rounded focus:outline-pink-400">
        </div>

        <button class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded transition">
            Lưu Thay Đổi
        </button>

    </form>

</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: 'Cấu hình SEO đã được cập nhật thành công.',
            showConfirmButton: false,
            timer: 3000
        });

        // Xóa query param success mà không reload page
        const url = new URL(window.location);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url);
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();

// Gọi layout
require __DIR__ . '/../layout/layout.php';
