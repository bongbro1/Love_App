<?php
require_once __DIR__ . "/../components/editor.php";

$title = "Gửi mail hàng loạt";
ob_start();
?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg border border-gray-200">
    <h1 class="text-2xl font-bold text-pink-600 mb-6 text-center">Gửi Mail Hàng Loạt</h1>

    <form action="<?= BASE_URL ?>/admin/orders/bulk-mail/send" method="POST" class="space-y-6">
        <!-- Tiêu đề -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Tiêu đề email</label>
            <input type="text" name="subject" placeholder="Nhập tiêu đề"
                class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-sm"
                value="<?= htmlspecialchars($data['subject'] ?? '') ?>" required>
        </div>

        <!-- Nội dung -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nội dung email</label>
            <?= render_editor("message", $data['message'] ?? "", "300px") ?>
        </div>

        <!-- Danh sách email -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold text-gray-800">Danh sách email</h2>
                <button type="button" id="checkAll"
                    class="px-3 py-1 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl shadow hover:from-pink-600 hover:to-pink-700 transition">
                    Chọn tất cả
                </button>
            </div>
            <div class="border border-gray-200 rounded-xl p-4 max-h-80 overflow-y-auto">
                <?php foreach ($orders as $item): ?>
                    <label class="flex items-center gap-3 mb-2 cursor-pointer hover:bg-gray-50 rounded-lg p-2 transition">
                        <input type="checkbox" name="emails[]" value="<?= $item['receiver_email'] ?>"
                            class="h-5 w-5 text-pink-500 rounded"
                            <?= (isset($data['emails']) && in_array($item['receiver_email'], $data['emails'])) ? 'checked' : '' ?>>
                        <span class="text-gray-800 font-medium"><?= $item['receiver_name'] ?></span>
                        <span class="text-gray-500 ml-auto"><?= $item['receiver_email'] ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Nút gửi -->
        <button type="submit"
            class="w-full py-3 bg-gradient-to-r from-pink-500 to-pink-600 text-white font-bold rounded-2xl shadow-lg hover:from-pink-600 hover:to-pink-700 transition text-lg">
            Gửi Email
        </button>
    </form>
</div>

<script>
    const checkAllBtn = document.getElementById('checkAll');
    let allChecked = false;

    checkAllBtn.addEventListener('click', () => {
        allChecked = !allChecked; // toggle trạng thái
        document.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = allChecked);
        checkAllBtn.textContent = allChecked ? 'Bỏ chọn tất cả' : 'Chọn tất cả';
    });
</script>

<?php if (isset($_GET['status'])): ?>
    <script>
        Swal.fire({
            icon: '<?= $_GET['status'] === "success" ? "success" : "error" ?>',
            text: '<?= $_GET['status'] === "success" ? "Gửi email thành công!" : "Có lỗi, gửi thất bại." ?>',
            confirmButtonColor: '#ec4899'
        });
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/layout.php';
?>
