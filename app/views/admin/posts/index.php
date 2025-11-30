<?php
$title = "Danh sách bài viết";

// capture output
ob_start();
?>

<div class="flex md:flex-row md:items-center justify-between gap-4">

    <!-- Button Thêm mới -->
    <a href="<?= BASE_URL ?>/admin/posts/create"
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

        <!-- Category filter -->
        <div class="flex-1 md:w-48">
            <select id="categorySelect"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm mt-4">
    <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-pink-50 text-pink-700">
            <tr>
                <th class="px-4 py-3 text-center font-semibold">ID</th>
                <th class="px-4 py-3 text-left font-semibold">Tiêu đề</th>
                <th class="px-4 py-3 text-center font-semibold">Danh mục</th>
                <th class="px-4 py-3 text-center font-semibold">Ngày đăng</th>
                <th class="px-4 py-3 text-center font-semibold">Trạng thái</th>
                <th class="px-4 py-3 text-center font-semibold">Hành động</th>
            </tr>
        </thead>

        <tbody class="posts-list divide-y divide-gray-100 bg-white">
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
            $('#pagination a').on('click', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadPosts(page);
            });
        }


        function loadPosts(page = 1) {
            let keyword = $('#searchInput').val();
            let category = $('#categorySelect').val();

            $.ajax({
                url: '<?= BASE_URL ?>/admin/posts/filter',
                type: 'GET',
                data: {
                    keyword,
                    category,
                    page
                },
                dataType: 'json',
                success: function(res) {
                    const $tbody = $('tbody.posts-list');
                    $tbody.empty();

                    if (res.posts.length === 0) {
                        $tbody.append('<tr><td colspan="6" class="text-center py-4 text-gray-500">Không có bài viết nào</td></tr>');
                        $('#pagination').empty();
                        return;
                    }

                    res.posts.forEach(post => {
                        let statusClass = post.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700';
                        $tbody.append(`
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 text-center font-medium">${post.id}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-800">${post.title}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-center">${post.category_name}</td>
                                <td class="px-4 py-3 text-gray-700 text-center">${post.post_date}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusClass}">${post.status}</span>
                                </td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="<?= BASE_URL ?>/admin/posts/edit/${post.id}" class="bg-white border border-blue-500 text-blue-500 hover:bg-blue-50 font-medium px-4 py-1 rounded-lg transition">Sửa</a>
                                    <button type="button" class="bg-white border border-red-500 text-red-500 hover:bg-red-50 font-medium px-4 py-1 rounded-lg transition delete-btn" data-id="${post.id}">Xóa</button>
                                </td>
                            </tr>
                        `);
                    });

                    // Pagination
                    updatePagination(res);
                },
                error: function(err) {
                    console.error(err);
                }
            });
        }
        loadPosts(1);

        $('#searchInput, #categorySelect').on('input change', debounce(() => loadPosts(1), 300));
    });

    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            e.preventDefault();
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
                    window.location.href = "<?= BASE_URL ?>/admin/posts/delete/" + id;
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

// load layout
require __DIR__ . '/../layout/layout.php';
