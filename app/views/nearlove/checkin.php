<!-- Check-in Section -->


<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="checkin" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 p-5 md:p-8 bg-white rounded-xl shadow-lg">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-6 text-center">Check-in Gặp Mặt</h2>

            <div class="flex flex-col md:flex-row gap-6 items-center justify-center">
                <!-- LEFT: Buttons + Streak -->
                <div class="flex-1 text-center">
                    <p class="text-gray-700 font-semibold text-lg">
                        Streak: <span id="streak-count" class="text-pink-600">0 ngày</span>
                    </p>
                </div>

                <!-- RIGHT: QR code placeholder -->
                <div class="flex-1 flex justify-center">
                    <div class="bg-gray-100 p-4 rounded-xl shadow-md">
                        <img id="qr-code-img" src="" alt="QR Code" class="rounded-lg w-48 h-48 md:w-64 md:h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/navbar_nearlove.php'; ?>

<script>
    // Check-in
    $(function() {

        // --- Hàm load dữ liệu checkin lúc page load ---
        function loadCheckinData() {
            $.ajax({
                url: 'index.php?action=checkin_load',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const data = res.data;

                        // Update streak
                        if (data.streak !== undefined && data.streak != 0) {
                            $('#streak-count').text(data.streak + ' ngày liên tục');
                        }

                        // Update QR code
                        if (data.qr_code_base64) {
                            $('#qr-code-img').attr('src', data.qr_code_base64);
                        }

                        // 📍 Cập nhật location cho nút hành động
                        if (data.location_id) {
                            $('#btn-qr').data('location-id', data.location_id);
                            $('#btn-nfc').data('location-id', data.location_id);
                        }
                        if (data.lat) {
                            $('#btn-qr').data('lat', data.lat);
                            $('#btn-nfc').data('lat', data.lat);
                        }
                        if (data.lng) {
                            $('#btn-qr').data('lng', data.lng);
                            $('#btn-nfc').data('lng', data.lng);
                        }
                    } else {
                        console.warn('Không load được dữ liệu checkin');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Lỗi khi load checkin data:', status, error);
                    console.log('📨 Phản hồi server:', xhr.responseText);
                }
            });
        }

        // --- Gọi khi load page ---
        loadCheckinData();

        // --- Bắt sự kiện click cho cả 2 nút ---
        $('#checkin .checkin-btn').on('click', function(e) {
            e.preventDefault();

            let $btn = $(this);
            let type = $btn.data('type');
            let locationId = $btn.data('location-id') || '';
            let lat = $btn.data('lat') || '';
            let lng = $btn.data('lng') || '';

            $btn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

            $.ajax({
                url: 'index.php?action=checkin_submit',
                method: 'POST',
                data: {
                    type: type,
                    location_id: locationId,
                    lat: lat,
                    lng: lng
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#streak-count').text(res.streak + ' ngày liên tục');
                        $('#streak-count').fadeOut(100).fadeIn(200);
                    } else {
                        alert(res.message || 'Check-in thất bại, thử lại!');
                    }
                },
                error: function() {
                    alert('Lỗi kết nối server!');
                },
                complete: function() {
                    $btn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                }
            });
        });

    });
</script>