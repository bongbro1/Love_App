<!-- Love Map Section -->
<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="lovemap" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Love Map</h2>
            <div class="relative rounded-lg overflow-hidden shadow-md h-64 md:h-80">
                <div id="love-map" class="w-full h-full rounded-lg"></div>
            </div>

            <!-- Label dưới map, chính giữa -->
            <div class="mt-4 text-center">
                <span class="bg-pink-600 text-white px-4 py-1 rounded-lg shadow text-sm md:text-base love-map-count">
                    0 địa điểm đã ghé
                </span>
            </div>

        </div>
    </section>

</main>
<?php include __DIR__ . '/../components/navbar_nearlove.php'; ?>


<script>
    // love map
    $(function() {
        let map = null;
        let loveMapLayer = null;
        let initialized = false;

        function initLoveMap(coupleId) {
            if (!coupleId) return;
            if (initialized) return; // ✅ chỉ khởi tạo 1 lần duy nhất

            initialized = true; // đánh dấu đã khởi tạo

            // Tạo map
            map = L.map('love-map', {
                center: [21.0278, 105.8342],
                zoom: 13,
                zoomControl: true,
                scrollWheelZoom: true
            });

            // Layer nền
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Group marker
            loveMapLayer = L.featureGroup().addTo(map);

            // Tạo icon trái tim (Font Awesome)
            const pinkIcon = L.divIcon({
                html: '<i class="fas fa-heart text-pink-500 text-xl"></i>', // text-xl thay vì text-2xl
                className: 'love-marker',
                iconSize: [20, 20], // nhỏ lại
                iconAnchor: [10, 10], // đặt điểm neo giữa icon
                popupAnchor: [0, -10] // popup cách icon một chút
            });

            // Fetch dữ liệu
            $.ajax({
                url: 'index.php?action=fetch_love_map_points',
                method: 'GET',
                dataType: 'json',
                cache: false, // ❗ tránh cache Ajax cũ
                success: function(res) {
                    const points = Array.isArray(res) ? res : res.points || [];
                    if (!points.length) return;
                    loveMapLayer.clearLayers();

                    points.forEach(p => {
                        const marker = L.marker([p.lat, p.lng], { // swap lat/lng
                                icon: pinkIcon
                            })
                            .bindPopup(`
                            <div class="text-center">
                                <strong>${p.label || 'Địa điểm'}</strong><br>
                                <small>${new Date(p.created_at).toLocaleDateString('vi-VN')}</small>
                            </div>
                        `);
                        loveMapLayer.addLayer(marker);
                    });

                    map.fitBounds(loveMapLayer.getBounds().pad(0.2));
                    $('.love-map-count').text(`${points.length} địa điểm đã ghé`);
                },
                error: err => console.error('Lỗi tải điểm Love Map:', err)
            });

            // Fix lỗi lag khi section ẩn/hiện
            const loveSection = document.querySelector('#lovemap');
            if (loveSection) {
                new MutationObserver(() => {
                    if (!loveSection.classList.contains('hidden')) {
                        setTimeout(() => map.invalidateSize(), 300);
                    }
                }).observe(loveSection, {
                    attributes: true
                });
            }

            // Fix lag do transition CSS
            setTimeout(() => map.invalidateSize(), 600);
        }

        const COUPLE_ID = <?= json_encode($_SESSION['couple_id'] ?? null) ?>;
        initLoveMap(COUPLE_ID);
    });
</script>