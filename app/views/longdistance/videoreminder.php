

<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
<section id="video-reminder" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
            <div class="card-hover transition duration-300 p-4">
                <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-6 text-center">Video & Voice</h2>
                <div class="flex flex-col gap-4">
                    <!-- File + Date Input -->
                    <input id="secretFile" type="file" accept="video/*,audio/*" class="p-3 border border-pink-200 rounded-xl w-full bg-white/80 backdrop-blur-sm">
                    <div>
                        <label class="block text-gray-600 font-medium mb-2">Chọn ngày mở:</label>
                        <input id="openDateMedia" type="date" class="w-full p-3 border border-pink-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-pink-400"
                            value="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- Button chỉ icon -->
                    <button id="saveMediaSecret" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white p-3 rounded-full sparkle-button ripple text-xl transition duration-300 flex justify-center items-center">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>

                <!-- Danh sách Video/Voice đã gửi -->
                <div id="sent-list" class="max-h-[28rem] overflow-y-auto flex flex-col gap-4 p-4 bg-pink-50/80 rounded-xl backdrop-blur-sm mt-4">

                </div>


            </div>
        </section>
</main>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>