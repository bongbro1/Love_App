<?php
// Page title
$title = "Cài đặt chung";
require_once __DIR__ . "/../components/editor.php";

ob_start();
?>

<div class="space-y-6">

    <form action="<?= BASE_URL ?>/admin/settings/update" method="POST" class="space-y-5 bg-white p-6 rounded shadow">

        <div class="space-y-1">
            <label class="block font-medium text-gray-700">Tên Website</label>
            <input type="text" name="site_name" value="<?= htmlspecialchars($data['site_name']) ?>" 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none transition">
        </div>

        <div class="space-y-1">
            <label class="block font-medium text-gray-700">Email Liên Hệ</label>
            <input type="email" name="contact_email" value="<?= htmlspecialchars($data['contact_email']) ?>" 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none transition">
        </div>

        <div class="space-y-1">
            <label class="block font-medium text-gray-700">Hotline</label>
            <input type="text" name="hotline" value="<?= htmlspecialchars($data['hotline']) ?>" 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none transition">
        </div>

        <div class="space-y-1">
            <label class="block font-medium text-gray-700">Địa Chỉ</label>
            <textarea name="address" rows="4" 
                      class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none transition"><?= htmlspecialchars($data['address']) ?></textarea>
        </div>

        <button type="submit" 
                class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded transition-all shadow-md hover:shadow-lg">
            Lưu Cài Đặt
        </button>

    </form>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: 'Cài đặt đã được cập nhật thành công.',
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
