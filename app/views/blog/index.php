<?php include __DIR__ . '/../layout/header.php'; ?>
<style>
    .perspective {
        perspective: 1500px;
    }

    .article-card {
        transition: all 0.45s ease;
        transform-style: preserve-3d;
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.12);
    }

    .animate-blob {
        animation: blob 8s infinite cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }

    @keyframes blob {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(25px, -25px) scale(1.05);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.95);
        }
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    /* Hiệu ứng gradient chuyển động nhẹ */
    @keyframes gradient-x {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    .animate-gradient-x {
        background-size: 200% 200%;
        animation: gradient-x 5s ease infinite;
    }
</style>

<section class="relative bg-gradient-to-b from-white via-pink-50 to-purple-50 py-8 md:py-12 overflow-hidden">
    <!-- Hiệu ứng nền blob -->
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="absolute top-0 left-1/3 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-20 right-1/3 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl animation-delay-2000 animate-blob"></div>
    </div>

    <div class="relative max-w-7xl mx-auto z-10">
        <!-- Tiêu đề -->
        <div class="text-center mb-10 relative">
            <!-- Nền ánh sáng nhẹ -->
            <div class="absolute inset-0 -z-10 flex justify-center">
                <div class="w-[600px] h-[600px] bg-gradient-to-b from-rose-100 via-pink-50 to-transparent blur-3xl opacity-70"></div>
            </div>

            <!-- Tiêu đề chính -->
            <h1 class="text-3xl md:text-5xl font-extrabold mb-6 tracking-tight leading-tight text-gray-900">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-rose-500">
                    Blog LoveApp
                </span>
            </h1>

            <!-- Dòng tagline -->
            <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto font-light italic leading-relaxed">
                “Kết nối cảm xúc, nuôi dưỡng yêu thương” — nơi sẻ chia câu chuyện, bí quyết yêu xa và cảm hứng tình yêu qua công nghệ 💞
            </p>

            <!-- Đường phân cách nhỏ -->
            <div class="mt-6 flex justify-center">
                <div class="w-24 h-[3px] bg-gradient-to-r from-pink-500 to-purple-500 rounded-full"></div>
            </div>
        </div>


        <!-- Bộ lọc -->
        <div class="flex flex-wrap justify-center gap-3 mb-8 md:mb-12">
            <?php
            $categories = ['Tất cả', 'Yêu Xa', 'Công Nghệ', 'Kỷ Niệm', 'Thử Thách'];
            foreach ($categories as $cat): ?>
                <span class="filter-btn px-5 py-2.5 rounded-full text-sm font-semibold shadow-md cursor-pointer transition-all duration-300
            <?= $cat === 'Tất cả' ?
                    'bg-gradient-to-r from-pink-600 to-purple-600 text-white hover:shadow-lg' :
                    'bg-white text-gray-700 border border-pink-200 hover:bg-pink-50 hover:text-pink-600' ?>"
                    data-category="<?= strtolower(str_replace(' ', '-', $cat)) ?>">
                    <?= $cat ?>
                </span>
            <?php endforeach; ?>
        </div>

        <!-- Danh sách bài viết -->
        <div id="postContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 perspective">

            <?php
            $posts = [
                ['title' => 'Cách dùng thẻ NFC LoveApp để ghi dấu kỷ niệm 💖', 'img' => '/public/images/blog/nfc-loveapp.jpg', 'cat' => 'Công Nghệ', 'color' => 'pink', 'excerpt' => 'Check-in NFC không chỉ là quét — mà là cách lưu giữ kỷ niệm yêu thương trong từng khoảnh khắc.', 'date' => '10/10/2025', 'read' => '3 phút đọc'],
                ['title' => 'Yêu xa vẫn hạnh phúc – bí quyết từ LoveApp 🌍', 'img' => '/public/images/blog/yeu-xa.jpg', 'cat' => 'Yêu Xa', 'color' => 'purple', 'excerpt' => 'Gắn kết dù cách xa với LoveMap và voice note giúp hai bạn gần nhau hơn mỗi ngày.', 'date' => '05/10/2025', 'read' => '4 phút đọc'],
                ['title' => 'Thử thách tình yêu – cùng nhau vượt qua 💪', 'img' => '/public/images/blog/love-challenge.jpg', 'cat' => 'Thử Thách', 'color' => 'rose', 'excerpt' => 'Love Challenge giúp bạn hiểu nhau hơn và tăng LoveScore mỗi ngày một cách thú vị.', 'date' => '20/09/2025', 'read' => '5 phút đọc'],
                ['title' => '10 cách lưu giữ kỷ niệm đôi lứa 💞', 'img' => '/public/images/blog/memory-ideas.jpg', 'cat' => 'Kỷ Niệm', 'color' => 'amber', 'excerpt' => 'Từ ảnh, thư tay đến video – tất cả đều trở nên đặc biệt hơn với LoveApp.', 'date' => '01/10/2025', 'read' => '6 phút đọc'],
                ['title' => 'Gợi ý 5 thử thách tình yêu mỗi tuần ❤️', 'img' => '/public/images/blog/weekly-challenge.jpg', 'cat' => 'Thử Thách', 'color' => 'red', 'excerpt' => 'Giữ lửa tình yêu bằng những trò chơi nhỏ và phần thưởng đáng yêu.', 'date' => '12/09/2025', 'read' => '3 phút đọc'],
                ['title' => 'Yêu xa không cô đơn với LoveChat 💬', 'img' => '/public/images/blog/lovechat.jpg', 'cat' => 'Yêu Xa', 'color' => 'violet', 'excerpt' => 'LoveChat giúp bạn gửi lời yêu mỗi ngày, dù cách xa hàng nghìn km.', 'date' => '08/10/2025', 'read' => '2 phút đọc']
            ];

            foreach ($posts as $post): ?>
                <article
                    class="article-card bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-lg hover:shadow-2xl transition group"
                    data-category="<?= strtolower(str_replace(' ', '-', $post['cat'])) ?>">
                    <div class="relative overflow-hidden">
                        <img src="<?= $post['img'] ?>" alt="<?= $post['title'] ?>" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4 bg-<?= $post['color'] ?>-600 text-white px-4 py-1 rounded-full text-xs font-bold uppercase shadow">
                            <?= $post['cat'] ?>
                        </div>
                    </div>
                    <div class="p-8">
                        <h2 class="text-2xl font-semibold mb-3 text-gray-900 group-hover:text-<?= $post['color'] ?>-600 transition">
                            <?= $post['title'] ?>
                        </h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            <?= $post['excerpt'] ?>
                        </p>
                        <div class="flex justify-between items-center text-sm text-gray-400 border-t border-gray-100 pt-4 mb-6">
                            <span>🗓️ <?= $post['date'] ?></span>
                            <span>💕 <?= $post['read'] ?></span>
                        </div>
                        <a href="#"
                            class="block text-center w-full bg-gradient-to-r from-<?= $post['color'] ?>-500 to-<?= $post['color'] ?>-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition hover:scale-[1.02]">
                            Đọc bài →
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<script>
    // Filter danh mục
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.dataset.category;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('bg-gradient-to-r', 'from-pink-600', 'to-purple-600', 'text-white'));
            btn.classList.add('bg-gradient-to-r', 'from-pink-600', 'to-purple-600', 'text-white');
            document.querySelectorAll('.article-card').forEach(card => {
                if (cat === 'tất-cả' || card.dataset.category === cat) {
                    card.classList.remove('hidden');
                    card.classList.add('animate-fadeIn');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?>