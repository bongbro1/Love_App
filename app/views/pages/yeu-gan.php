<?php
include __DIR__ . '/../layout/header.php'; ?>

<section class="bg-gradient-to-b from-gray-50 via-white to-pink-50 py-8 md:py-12">

    <!-- HERO SECTION -->
    <div class="container mx-auto px-6 text-center mb-12">
        <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-semibold rounded-full mb-6 shadow-lg">
            💞 Dành Cho Các Cặp Đôi Ở Gần Nhau
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">Yêu Gần</span> – Kết Nối Cảm Xúc Mỗi Ngày Với LoveApp
        </h1>

        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Khi hai bạn ở gần nhau, tình yêu không chỉ là tin nhắn hay cuộc gọi – đó là những buổi hẹn hò, những cái chạm tay và kỷ niệm thật.
            LoveApp giúp bạn lưu giữ mọi khoảnh khắc ấy bằng công nghệ NFC thông minh, biến từng lần gặp gỡ thành một dấu ấn đáng nhớ.
        </p>
    </div>

    <!-- INTRO BLOCK -->
    <div class="container mx-auto px-6 mb-12">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <img src="/assets/images/yeu-gan-couple.jpg" alt="Cặp đôi yêu gần sử dụng LoveApp" class="rounded-3xl shadow-2xl w-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Tình Yêu Hiện Đại – Lưu Giữ Bằng Công Nghệ</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Thay vì chỉ “nhớ lại” những buổi hẹn hò, LoveApp giúp bạn “sống lại” từng cảm xúc bằng cách lưu giữ mọi dữ liệu của các lần gặp nhau –
                    vị trí, ảnh chụp, lời nhắn, cảm xúc và thậm chí cả số ngày yêu.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Hệ thống “Yêu Gần” được thiết kế riêng cho các cặp đôi có thể gặp mặt thường xuyên – giúp việc yêu không chỉ là thói quen,
                    mà trở thành một hành trình đáng tự hào.
                </p>
                <div class="flex justify-center sm:justify-start mt-6">
                    <a href="/love-app/public/#purchase"
                        class="inline-block bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold py-3 px-8 rounded-full shadow-xl hover:scale-105 transition-transform">
                        💖 Trải Nghiệm Ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURES -->
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-12 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600">
            Bộ Tính Năng Dành Riêng Cho Cặp Đôi Yêu Gần
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            <!-- 1. Check-in NFC/QR -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-qrcode text-6xl bg-gradient-to-r from-pink-500 to-pink-400 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Check-in NFC/QR</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Mỗi lần gặp mặt, chỉ cần chạm thẻ NFC hoặc quét mã QR để ghi lại thời điểm, địa điểm và cảm xúc.
                    Tất cả sẽ được lưu lại tự động vào “dòng thời gian tình yêu”.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Ứng dụng cũng tính toán <strong>streak yêu</strong> – số ngày gặp nhau liên tiếp. Mỗi streak dài là một “huy chương cảm xúc”,
                    minh chứng cho sự gắn bó bền chặt giữa hai bạn.
                </p>
                <div class="text-pink-600 font-semibold">🔥 Giữ lửa tình yêu qua từng lần gặp</div>
            </div>

            <!-- 2. Memories -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-images text-6xl bg-gradient-to-r from-purple-500 to-purple-400 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Album Kỷ Niệm</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Chụp ảnh, quay video hay viết ghi chú sau mỗi buổi hẹn. LoveApp sẽ tự động sắp xếp chúng thành album kỷ niệm,
                    giúp bạn dễ dàng xem lại theo thời gian hoặc theo địa điểm.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Bạn còn có thể thêm nhạc nền, filter tình yêu và chia sẻ album với người ấy – biến từng kỷ niệm thành một câu chuyện riêng.
                </p>
                <div class="text-purple-600 font-semibold">📸 Lưu giữ từng khoảnh khắc yêu thương</div>
            </div>

            <!-- 3. Love Map -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-map-marked-alt text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Bản Đồ Tình Yêu</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Mỗi lần check-in sẽ được đánh dấu trên bản đồ. Nhìn lại, bạn sẽ thấy hành trình tình yêu của hai bạn trải dài qua quán cà phê quen,
                    công viên buổi chiều hay chuyến đi chơi xa đầu tiên.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Love Map như một cuốn nhật ký trực quan, giúp bạn tái hiện toàn bộ chặng đường yêu một cách sinh động và đầy cảm xúc.
                </p>
                <div class="text-pink-600 font-semibold">📍 Bản đồ hành trình yêu thương</div>
            </div>

            <!-- 4. Love Challenge -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-tasks text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Thử Thách Hẹn Hò</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Thay vì chỉ gặp nhau, hãy cùng nhau chinh phục các thử thách dễ thương như “Cùng nhau làm món ăn yêu thích”,
                    “Tặng người kia một bất ngờ nhỏ” hoặc “Chụp 10 tấm ảnh trong buổi hẹn”.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Mỗi nhiệm vụ hoàn thành sẽ giúp bạn tích điểm LoveScore – biểu tượng của sự nỗ lực, sáng tạo và yêu thương chân thành.
                </p>
                <div class="text-purple-600 font-semibold">🎯 Cùng nhau yêu thông minh hơn</div>
            </div>

            <!-- 5. Mini Game Offline -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-gamepad text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Mini Game Offline</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Đôi khi tình yêu cần chút “gia vị vui nhộn”. LoveApp tích hợp mini game như “Ai cười trước thua”,
                    “Đoán biểu cảm”, “Hỏi nhanh – đáp nhanh” giúp hai bạn vừa chơi vừa gắn kết.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Mỗi trò chơi đều được thiết kế nhẹ nhàng, phù hợp cho những buổi cà phê, dạo phố hay picnic cùng nhau.
                </p>
                <div class="text-pink-600 font-semibold">🎮 Thêm tiếng cười cho mỗi lần gặp</div>
            </div>

            <!-- 6. Anniversary Reminder -->
            <div class="bg-white rounded-3xl shadow-xl p-10 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
                <i class="fas fa-bell text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 inline-block"></i>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Nhắc Ngày Đặc Biệt</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    LoveApp tự động ghi nhớ và nhắc bạn về những ngày quan trọng: ngày đầu gặp nhau, ngày yêu, sinh nhật,
                    hay kỷ niệm một năm bên nhau.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Bạn có thể thêm lời nhắn, quà gợi ý hoặc đặt lịch “surprise date” để người ấy luôn cảm nhận được tình yêu của bạn.
                </p>
                <div class="text-purple-600 font-semibold">⏰ Không bỏ lỡ bất kỳ ngày đặc biệt nào</div>
            </div>

        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="text-center mt-24 max-w-3xl mx-auto px-6">
        <h3 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-6">
            Biến Tình Yêu Thành Hành Trình Đáng Nhớ
        </h3>
        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            “Yêu Gần” không chỉ giúp bạn lưu lại kỷ niệm – nó giúp bạn nhận ra rằng, mỗi lần gặp mặt đều là một chương trong câu chuyện tình yêu.
            Hãy để LoveApp là cầu nối giúp hai bạn viết nên những kỷ niệm đẹp nhất, từng ngày, từng tháng, từng năm.
        </p>
        <a href="/love-app/public/#purchase" class="inline-block bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold py-4 px-12 rounded-full hover:scale-105 hover:shadow-2xl transition-all duration-300">
            💕 Bắt Đầu Hành Trình
        </a>
    </div>

</section>
<?php include __DIR__ . '/../layout/footer.php'; ?>