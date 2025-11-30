<div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">
        Chi tiết đơn hàng #<?= $order['id'] ?>
    </h2>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Thông tin người nhận -->
        <div class="bg-pink-50 p-6 rounded-lg shadow-sm border border-pink-100">
            <h3 class="font-semibold text-pink-600 mb-4 text-lg">Người nhận hàng</h3>
            <p class="mb-2"><span class="font-medium">Tên:</span> <?= htmlspecialchars($order['receiver_name']) ?></p>
            <p class="mb-2"><span class="font-medium">Email:</span> <?= htmlspecialchars($order['receiver_email']) ?></p>
            <p class="mb-2"><span class="font-medium">Điện thoại:</span> <?= htmlspecialchars($order['receiver_phone']) ?></p>
            <p class="mb-2"><span class="font-medium">Địa chỉ:</span> <?= htmlspecialchars($order['receiver_address']) ?></p>
        </div>

        <!-- Thông tin cặp đôi -->
        <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-100">
            <h3 class="font-semibold text-green-600 mb-4 text-lg">Thông tin cặp đôi</h3>
            <p class="mb-2"><span class="font-medium">Nam:</span> <?= htmlspecialchars($order['male_name']) ?> (<?= $order['male_dob'] ?>)</p>
            <p class="mb-2"><span class="font-medium">Nữ:</span> <?= htmlspecialchars($order['female_name']) ?> (<?= $order['female_dob'] ?>)</p>
            <p class="mb-2"><span class="font-medium">Kỷ niệm:</span> <?= htmlspecialchars($order['anniversary']) ?></p>
            <p class="mb-2">
                <span class="font-medium">Trạng thái in:</span> 
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full <?= $order['printed'] ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                    <?= $order['printed'] ? '✅ Đã in' : '🕓 Chưa in' ?>
                </span>
            </p>
        </div>
    </div>

    <div class="mt-8 flex justify-end">
        <a href="<?= BASE_URL ?>/admin/orders" 
           class="bg-white border border-pink-500 text-pink-500 hover:bg-pink-50 font-medium px-5 py-2 rounded-lg shadow-sm transition">
           ← Quay lại danh sách
        </a>
    </div>
</div>
