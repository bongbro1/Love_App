<?php
$title = "Danh mục bài viết";
// capture output buffer
ob_start();

?>
<div class="flex md:flex-row md:items-center justify-between gap-4">

    <!-- Button Thêm mới -->
    <a href="<?= BASE_URL ?>/admin/categories/create"
        class="bg-pink-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-pink-600 transition shadow-md flex-shrink-0">
        Thêm mới
    </a>

    <!-- Filter bar chiếm hết chiều ngang còn lại -->
    <div id="filterBar" class="max-w-3xl bg-white flex flex-col md:flex-row md:items-center md:justify-between gap-4 flex-end">

        <!-- Search input -->
        <div class="flex-1">
            <input type="text" id="searchInput" placeholder="Tìm kiếm..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" />
        </div>
    </div>

</div>

<div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm mt-6">
    <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-pink-50 text-pink-700">
            <tr>
                <th class="px-4 py-3 text-left font-semibold">ID</th>
                <th class="px-4 py-3 text-left font-semibold">Tên</th>
                <th class="px-4 py-3 text-left font-semibold">Slug</th>
                <th class="px-4 py-3 text-left font-semibold">Màu</th>
                <th class="px-4 py-3 text-left font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody class="categories-list divide-y divide-gray-100">
        </tbody>
    </table>
</div>


<div id="pagination" class="flex justify-center mt-4 gap-2">
</div>

<script>
    $(function() {
        function debounce(func, wait) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, arguments), wait);
            };
        }

        function updatePagination(res) {
            const $pagination = $('#pagination');
            $pagination.empty();
            let totalPages = Math.ceil(res.total / res.perPage);
            for (let i = 1; i <= totalPages; i++) {
                let active = i === res.page ? 'bg-pink-500 text-white' : 'bg-white text-gray-700';
                $pagination.append(`<a href="#" class="px-3 py-1 border rounded ${active}" data-page="${i}">${i}</a>`);
            }

            // Bind click
            $('#pagination').on('click', 'a', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadCategories(page);
            });
        }

        function loadCategories(page = 1) {
            let keyword = $('#searchInput').val();

            $.ajax({
                url: '<?= BASE_URL ?>/admin/categories/filter', // route filter category
                type: 'GET',
                data: {
                    keyword,
                    page
                },
                dataType: 'json',
                success: function(res) {
                    const $tbody = $('tbody.categories-list');
                    $tbody.empty();

                    if (res.categories.length === 0) {
                        $tbody.append('<tr><td colspan="5" class="text-center py-4 text-gray-500">Không có danh mục nào</td></tr>');
                        $('#pagination').empty();
                        return;
                    }

                    res.categories.forEach(cat => {
                        $tbody.append(`
                        <tr>
                            <td class="px-4 py-2">${cat.id}</td>
                            <td class="px-4 py-2">${cat.name}</td>
                            <td class="px-4 py-2">${cat.slug}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded" style="background-color: ${cat.color}">${cat.color}</span>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="<?= BASE_URL ?>/admin/categories/edit/${cat.id}" class="bg-white border border-blue-500 text-blue-500 hover:bg-blue-50 font-medium px-4 py-1 rounded-lg transition">Sửa</a>
                                <button type="button" class="bg-white border border-red-500 text-red-500 hover:bg-red-50 font-medium px-4 py-1 rounded-lg transition delete-btn" data-id="${cat.id}">Xóa</button>
                            </td>
                        </tr>
                    `);
                    });

                    updatePagination(res);
                },
                error: function(err) {
                    console.error(err);
                }
            });
        }

        loadCategories(1);
        $('#searchInput').on('input', debounce(() => loadCategories(1), 300));

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault(); // ngăn reload
            var id = $(this).data('id');
            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // redirect tới URL xóa
                    window.location.href = '<?= BASE_URL ?>/admin/categories/delete/' + id;
                }
            });
        });
    });
</script>

<?php if (isset($_GET['status'])): ?>
    <script>
        const status = "<?= $_GET['status'] ?>";
        Swal.fire({
            icon: status === 'success' ? 'success' : 'error',
            title: status === 'success' ? 'Thành công' : 'Lỗi',
            text: status === 'success' ? 'Danh sách đã được cập nhật.' : 'Có lỗi xảy ra, vui lòng thử lại.',
            showConfirmButton: status === 'error',
            timer: status === 'success' ? 2000 : undefined
        });

        // Xóa param
        const url = new URL(window.location);
        url.searchParams.delete('status');
        window.history.replaceState({}, document.title, url);
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/layout.php';
