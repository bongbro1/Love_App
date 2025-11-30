<div class="space-y-10">

    <!-- API Key Configuration -->
    <section class="bg-gradient-to-br from-pink-50 to-white p-8 rounded-2xl shadow-sm border border-pink-100">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-pink-100 text-pink-600 p-2 rounded-xl">
                    🔑
                </div>
                <h2 class="text-xl font-bold text-gray-800">Cấu hình Sepay API</h2>
            </div>
            <span class="text-sm text-gray-400 italic">Cập nhật API Key để kết nối hệ thống thanh toán tự động</span>
        </div>

        <form method="POST" action="/love-app/public/admin/sepay/update-api-key"
              class="flex flex-col md:flex-row gap-4">
            <input
                type="text"
                name="api_key"
                value="<?= htmlspecialchars($this->sepayModel->getApiKey()) ?>"
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent
                       placeholder-gray-400"
                placeholder="Nhập API Key Sepay của bạn..."
            >
            <button type="submit"
                    class="bg-pink-500 hover:bg-pink-600 transition-all text-white font-semibold
                           px-6 py-3 rounded-xl shadow-sm hover:shadow-md">
                💾 Lưu cấu hình
            </button>
        </form>
    </section>

    <!-- Account List -->
    <section class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-green-100 text-green-600 p-2 rounded-xl">
                    🏦
                </div>
                <h2 class="text-xl font-bold text-gray-800">Danh sách tài khoản ngân hàng</h2>
            </div>
            <a href="/love-app/public/admin/sepay"
               class="text-sm text-pink-600 hover:text-pink-700 font-medium flex items-center gap-1">
                ⟳ Làm mới
            </a>
        </div>

        <?php if (!empty($accounts) && empty($accounts['error'])): ?>
            <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-pink-50 text-pink-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Ngân hàng</th>
                            <th class="px-6 py-3 text-left font-semibold">Số tài khoản</th>
                            <th class="px-6 py-3 text-left font-semibold">Chủ tài khoản</th>
                            <th class="px-6 py-3 text-right font-semibold">Số dư</th>
                            <th class="px-6 py-3 text-center font-semibold">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($accounts as $acc): ?>
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-3 font-medium"><?= htmlspecialchars($acc['bank_short_name'] ?? '-') ?></td>
                                <td class="px-6 py-3"><?= htmlspecialchars($acc['account_number'] ?? '-') ?></td>
                                <td class="px-6 py-3"><?= htmlspecialchars($acc['account_name'] ?? '-') ?></td>
                                <td class="px-6 py-3 text-right font-semibold text-green-600">
                                    <?= number_format($acc['balance'] ?? 0) ?> đ
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <?php if (($acc['status'] ?? '') === 'ACTIVE'): ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Hoạt động
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs bg-gray-200 text-gray-600 rounded-full font-medium">
                                            <span class="w-2 h-2 bg-gray-500 rounded-full"></span> Không hoạt động
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center text-gray-500 py-10">
                <p class="mb-2"><?= $accounts['error'] ?? 'Chưa có tài khoản nào được kết nối.' ?></p>
                <p class="text-sm text-gray-400">Hãy kiểm tra lại API key hoặc thử lại sau.</p>
            </div>
        <?php endif; ?>
    </section>
</div>
