<?php
$title = "Danh sách đơn hàng";
// capture output buffer
ob_start();

?>
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <!-- Search + Filter -->
        <form id="filterForm" class="flex items-center gap-2">
            <input type="text" id="searchInput" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                placeholder="Tìm theo tên hoặc SĐT..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-48 focus:ring-2 focus:ring-pink-400 focus:outline-none">
            <select id="statusSelect" name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                <option value="">Tất cả trạng thái</option>
                <option value="printed" <?= ($_GET['status'] ?? '') === 'printed' ? 'selected' : '' ?>>Đã in</option>
                <option value="unprinted" <?= ($_GET['status'] ?? '') === 'unprinted' ? 'selected' : '' ?>>Chưa in</option>
            </select>
        </form>

        <!-- Export -->
        <a href="<?= BASE_URL ?>/admin/orders/export?<?= http_build_query($_GET) ?>"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
            📤 Xuất đơn chưa in
        </a>
    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-pink-50 text-pink-700">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 py-3 text-left font-semibold">Người nhận</th>
                    <th class="px-4 py-3 text-left font-semibold">SĐT</th>
                    <th class="px-4 py-3 text-left font-semibold">Địa chỉ</th>
                    <th class="px-4 py-3 text-center font-semibold">Trạng thái in</th>
                    <th class="px-4 py-3 text-left font-semibold">Ngày đặt</th>
                    <th class="px-4 py-3 text-center font-semibold">Thao tác</th>
                </tr>
            </thead>
            <tbody class="orders-list divide-y divide-gray-100">
                <!-- Nội dung sẽ load bằng AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="flex justify-center mt-4 gap-2"></div>

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

        // Load orders AJAX
        function loadOrders(page = 1) {
            const keyword = $('#searchInput').val();
            const status = $('#statusSelect').val();

            $.ajax({
                url: '<?= BASE_URL ?>/admin/orders/filter',
                type: 'GET',
                data: {
                    keyword,
                    status,
                    page
                },
                dataType: 'json',
                success: function(res) {
                    const $tbody = $('tbody.orders-list');
                    $tbody.empty();

                    if (res.orders.length === 0) {
                        $tbody.append('<tr><td colspan="7" class="text-center py-4 text-gray-500">Không có đơn hàng nào</td></tr>');
                        $('#pagination').empty();
                        return;
                    }

                    res.orders.forEach(o => {
                        let statusClass = o.printed == 1 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';
                        let statusText = o.printed == 1 ? 'Đã in' : 'Chưa in';
                        let markPrintedBtn = o.printed == 1 ? '' : `<button type="button" class="bg-white border border-pink-500 text-pink-500 hover:bg-pink-50 font-medium px-4 py-1 rounded-lg transition mark-printed-btn" data-id="${o.id}">Đã in</button>`;

                        $tbody.append(`
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800">${o.id}</td>
                            <td class="px-4 py-3">${o.receiver_name}</td>
                            <td class="px-4 py-3">${o.receiver_phone}</td>
                            <td class="px-4 py-3">${o.receiver_address}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 text-xs rounded-full font-medium ${statusClass}">${statusText}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">${o.created_at}</td>
                            <td class="px-4 py-3 flex gap-2 justify-center">
                                <a href="<?= BASE_URL ?>/admin/orders/view/${o.id}" class="bg-white border border-blue-500 text-blue-500 hover:bg-blue-50 font-medium px-4 py-1 rounded-lg transition">Xem</a>
                                ${markPrintedBtn}
                                <button type="button" class="bg-white border border-red-500 text-red-500 hover:bg-red-50 font-medium px-4 py-1 rounded-lg transition delete-btn" data-id="${o.id}">Xóa</button>
                            </td>
                        </tr>
                    `);
                    });

                    // Pagination
                    const $pagination = $('#pagination');
                    $pagination.empty();
                    for (let i = 1; i <= res.totalPages; i++) {
                        let active = i === res.page ? 'bg-pink-500 text-white' : 'bg-white text-gray-700';
                        $pagination.append(`<a href="#" class="px-3 py-1 border rounded ${active}" data-page="${i}">${i}</a>`);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:");
                    console.log("Status:", textStatus); // vd: "error", "timeout"
                    console.log("Error Thrown:", errorThrown); // vd: "Internal Server Error"
                    console.log("Response Text:", jqXHR.responseText); // body trả về từ server
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi AJAX',
                        html: `Status: ${textStatus}<br>Error: ${errorThrown}<br>Check console for details`
                    });
                }
            });
        }

        // Pagination click
        $(document).on('click', '#pagination a', function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            loadOrders(page);
        });

        // Search / filter with debounce
        $('#searchInput, #statusSelect').on('input change', debounce(() => loadOrders(1), 300));

        // Initial load
        loadOrders(1);

        // Mark printed
        $(document).on('click', '.mark-printed-btn', function() {
            const $btn = $(this);
            const orderId = $btn.data('id');
            if (!orderId) return;

            $.ajax({
                url: '<?= BASE_URL ?>/admin/orders/markPrinted',
                type: 'POST',
                data: {
                    id: orderId
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $btn.replaceWith('<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Đã in</span>');
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Đơn hàng đã được đánh dấu là đã in!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: res.message || 'Đã xảy ra lỗi server.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi, vui lòng thử lại.'
                    });
                }
            });
        });

        // Delete
        $(document).on('click', '.delete-btn', function() {
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
                    window.location.href = '<?= BASE_URL ?>/admin/orders/delete/' + id;
                }
            });
        });

        // Load initial orders
        loadOrders();
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
