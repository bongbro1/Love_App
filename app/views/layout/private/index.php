<?php include __DIR__ . '/header.php'; ?>

<main>
    <?php include $viewPath; ?>
</main>

<!-- ✅ Global Image Modal -->
<div id="imageModal"
    class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="relative max-w-[90%] max-h-[90%] flex flex-col items-center modal-show">
        <!-- Close -->
        <button id="modalClose"
            class="absolute top-2 right-4 text-white text-3xl text-rose-300 transition">&times;</button>

        <!-- Image -->
        <img id="modalImage"
            src=""
            class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl border border-white/10 mb-4 object-contain">

        <!-- Navigation -->
        <div class="flex gap-6">
            <button id="prevImage"
                class="text-white text-3xl hover:text-pink-400 transition">&larr;</button>
            <button id="nextImage"
                class="text-white text-3xl hover:text-pink-400 transition">&rarr;</button>
        </div>
    </div>
</div>

<!-- Modal Lightbox -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <div class="relative max-w-[90%] max-h-[90%] flex flex-col items-center">
        <!-- Close button -->
        <button id="modalClose" class="absolute top-2 right-3 text-gray text-2xl">&times;</button>

        <!-- Image display -->
        <img id="modalImage" src="" class="max-w-full max-h-[80vh] rounded-lg shadow-lg mb-4">

        <!-- Carousel controls -->
        <div class="flex gap-4">
            <button id="prevImage" class="text-white text-3xl">&larr;</button>
            <button id="nextImage" class="text-white text-3xl">&rarr;</button>
        </div>
    </div>
</div>

<!-- Secret Letter Modal -->


<!-- 🌀 Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center z-50 hidden">
    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-pink-500 mb-4"></div>
    <p class="text-lg font-medium text-gray-800">Đang tải dữ liệu...</p>
    <p class="text-sm text-gray-500 mt-2">Vui lòng chờ trong giây lát 💌</p>
</div>

<script src="<?= BASE_URL ?>/js/uploadChunk.js"></script>

<?php
$config = include __DIR__ . '/../../../../config/config.php';
$vapidPublicKey = $config['vapid']['publicKey'];
?>


<!-- Placeholder AJAX for Real-time Chat -->
<script>
    const BASE_URL = "<?= BASE_URL ?>";
    const userId = <?= $_SESSION['user_id'] ?? 0 ?>;
    const VAPID_PUBLIC_KEY = <?= json_encode($vapidPublicKey) ?>;
    const WS_URL = "<?= WS_URL ?>";
    const WS_URL_HEARTBEAT = "<?= WS_URL_HEARTBEAT ?>";
</script>
<script src="<?= BASE_URL ?>/js/global.js"></script>
</body>

</html>