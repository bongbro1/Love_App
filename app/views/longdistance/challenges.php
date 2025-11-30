<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="challenges" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 p-4">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-6 text-center">Thử Thách Online</h2>

            <!-- Danh sách thử thách -->
            <div id="challenge-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[28rem] overflow-y-auto">
                <!-- Thử thách 1 -->
                <div class="flex items-start gap-3 p-4 bg-pink-50/80 rounded-xl backdrop-blur-sm hover:bg-pink-100/80 transition duration-300 shadow-sm">
                    <div class="flex-shrink-0 mt-1">
                        <input type="checkbox" class="w-5 h-5 text-pink-600 rounded border border-gray-300 checked:bg-pink-600 checked:border-pink-600 transition duration-200 appearance-none" data-score="50">
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-base">Viết 3 điều em/anh yêu ở đối phương hôm nay</p>
                        <p class="text-pink-600 font-medium text-sm text-right">LoveScore: +50</p>
                    </div>
                </div>

                <!-- Thử thách 2 -->
                <div class="flex items-start gap-3 p-4 bg-pink-50/80 rounded-xl backdrop-blur-sm hover:bg-pink-100/80 transition duration-300 shadow-sm">
                    <div class="flex-shrink-0 mt-1">
                        <input type="checkbox" class="w-5 h-5 text-pink-600 rounded border border-gray-300 checked:bg-pink-600 checked:border-pink-600 transition duration-200 appearance-none" data-score="30">
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-base">Chia sẻ 1 bài hát nhớ nhau</p>
                        <p class="text-pink-600 font-medium text-sm text-right">LoveScore: +30</p>
                    </div>
                </div>

                <!-- Thêm các item khác -->
            </div>

            <!-- Nút thêm thử thách -->
            <div class="flex justify-center mt-4">
                <button id="add-challenge-btn" class="flex items-center gap-2 bg-pink-600 text-white px-4 py-2 rounded-full hover:bg-pink-700 transition duration-300">
                    <i class="fas fa-plus"></i> Thêm thử thách
                </button>
            </div>

            <!-- Tổng LoveScore -->
            <p id="total-score" class="mt-6 text-center text-pink-600 font-bold text-xl md:text-2xl">Tổng LoveScore: 850</p>
        </div>

        <!-- Popup thêm thử thách -->
        <div id="challenge-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-xl">
                <h3 class="text-2xl font-bold text-pink-600 mb-4">Thêm Thử Thách</h3>
                <input id="new-challenge-name" type="text" placeholder="Tên thử thách" class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                <input id="new-challenge-score" type="number" placeholder="LoveScore" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                <div class="flex justify-end gap-4">
                    <button id="cancel-btn" class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400 transition">Hủy</button>
                    <button id="save-btn" class="px-4 py-2 rounded-full bg-pink-600 text-white hover:bg-pink-700 transition">Lưu</button>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>