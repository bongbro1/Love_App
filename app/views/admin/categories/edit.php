<?php
$title = "Chỉnh sửa danh mục";

ob_start();
?>

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg p-8 mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Chỉnh sửa danh mục</h1>

    <form action="<?= BASE_URL ?>/admin/categories/edit?id=<?= $category['id'] ?>" id="categoryForm" method="post" class="space-y-6">

        <!-- Tên danh mục -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Tên danh mục <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="nameInput" required
                class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-gray-800 font-medium placeholder-gray-400 transition"
                placeholder="Ví dụ: Yêu Xa, Công Nghệ"
                value="<?= htmlspecialchars($category['name']) ?>">
        </div>

        <!-- Slug -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Slug</label>
            <input type="text" name="slug" id="slugInput"
                class="w-full px-5 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-600 font-medium cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                placeholder="yeu-xa, cong-nghe" readonly
                value="<?= htmlspecialchars($category['slug']) ?>">
        </div>

        <!-- Màu -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Màu</label>
            <input type="color" name="color" value="<?= htmlspecialchars($category['color'] ?? '#f472b6') ?>"
                class="w-20 h-10 rounded-xl border border-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
        </div>

        <!-- Button -->
        <div>
            <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-xl transition shadow-md">
                Cập nhật
            </button>
        </div>

    </form>
</div>

<!-- JS tự sinh slug -->
<script>
    function removeVietnameseTones(str) {
        str = str.toLowerCase();
        str = str.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, "a");
        str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, "e");
        str = str.replace(/i|í|ì|ỉ|ĩ|ị/g, "i");
        str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, "o");
        str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, "u");
        str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, "y");
        str = str.replace(/đ/g, "d");
        return str;
    }

    const nameInput = document.getElementById('nameInput');
    const slugInput = document.getElementById('slugInput');

    nameInput.addEventListener('input', () => {
        let slug = removeVietnameseTones(nameInput.value.trim())
            .replace(/ /g, '-') // thay khoảng trắng bằng dấu -
            .replace(/[^a-z0-9\-]/g, ''); // loại bỏ ký tự đặc biệt
        slugInput.value = slug;
    });

    $('#categoryForm').on('submit', function(e) {
        e.preventDefault(); // ngăn reload page
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            success: function(res) {
                Swal.fire({
                    icon: res.status === 'success' ? 'success' : 'error',
                    title: res.status === 'success' ? 'Thành công!' : 'Lỗi',
                    text: res.message
                });
            },
            error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // <--- Xem lỗi PHP
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Có lỗi xảy ra khi gửi dữ liệu. Kiểm tra console để biết chi tiết.'
            });
        }
        });
    });
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/layout.php';
