<?php

include __DIR__  . '/../layout/header.php';
?>


<!-- Hero Section with SVG Animation -->
<section class="relative bg-gradient-to-b from-pink-50 via-white to-purple-50 py-12 sm:py-20 overflow-hidden opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-gray-800 mb-6 leading-snug sm:leading-tight">
      Kết Nối Tình Yêu, Vươn Xa Kỷ Niệm
    </h2>
    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-xl sm:max-w-3xl mx-auto mb-8 sm:mb-10">
      LoveApp mang đến trải nghiệm hiện đại cho các cặp đôi, với NFC check-in, Love Map, thử thách tình yêu đầy cảm hứng, nhật ký chung, mini game, và bảo mật cao cấp chống XSS, injection. Dù yêu gần hay xa, hãy để tình yêu của bạn được bảo vệ và lưu giữ mãi mãi.
    </p>
    <div class="relative w-48 h-48 sm:w-80 sm:h-80 mx-auto mb-8 sm:mb-10">
      <svg viewBox="0 0 200 200" class="w-full h-full float-animation">
        <defs>
          <linearGradient id="heartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#f472b6;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#c084fc;stop-opacity:1" />
          </linearGradient>
        </defs>
        <path d="M100,20 A50,50 0 0,1 150,70 A50,50 0 0,1 100,120 A50,50 0 0,1 50,70 A50,50 0 0,1 100,20 Z" fill="url(#heartGradient)">
          <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="6s" repeatCount="indefinite" />
        </path>
        <path d="M100,30 A40,40 0 0,1 140,70 A40,40 0 0,1 100,110 A40,40 0 0,1 60,70 A40,40 0 0,1 100,30 Z" fill="none" stroke="#fff" stroke-width="6">
          <animate attributeName="opacity" from="0.3" to="1" dur="1.2s" repeatCount="indefinite" values="0.3;1;0.3" />
        </path>
        <circle cx="100" cy="100" r="20" fill="#fff" stroke="#f472b6" stroke-width="4" class="pulse-animation" />
      </svg>
    </div>
    <a href="#purchase" class="inline-block bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold py-3 px-8 sm:py-4 sm:px-10 rounded-full hover:bg-pink-700 transition duration-300 shadow-lg">
      Bắt Đầu Hành Trình
    </a>
  </div>

  <!-- Background Decorations -->
  <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
    <svg class="w-full h-full" viewBox="0 0 200 200">
      <circle cx="50" cy="50" r="30" fill="#f472b6" />
      <circle cx="150" cy="150" r="20" fill="#c084fc" />
    </svg>
  </div>
</section>

<!-- About Section -->
<section id="about" class="py-12 sm:py-16 bg-pink-50 opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4">
    <!-- Title -->
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600 drop-shadow-md">
      Về LoveApp
    </h2>

    <!-- Description -->
    <p class="text-base sm:text-lg md:text-xl text-gray-700 text-center max-w-lg sm:max-w-3xl mx-auto mb-10 leading-relaxed">
      LoveApp là ứng dụng dành cho các cặp đôi, giúp lưu giữ kỷ niệm, kết nối cảm xúc và trải nghiệm các thử thách tình yêu một cách <strong class="text-pink-600 font-semibold">an toàn, sáng tạo và tiện lợi</strong>. Khám phá các tính năng nổi bật ngay bên dưới:
    </p>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
      <!-- Yêu Gần -->
      <div class="bg-white rounded-2xl shadow-xl p-5 sm:p-6 transform transition duration-300">
        <div class="flex items-center mb-4">
          <div class="text-3xl text-pink-500 mr-3">📍</div>
          <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">Yêu Gần</h3>
        </div>
        <ul class="space-y-3">
          <li class="flex items-start bg-pink-50 hover:bg-pink-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Check-in NFC/QR tại điểm hẹn để ghi dấu kỷ niệm.
            </span>
          </li>
          <li class="flex items-start bg-pink-50 hover:bg-pink-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Theo dõi chuỗi ngày gặp nhau (streak) và lịch sử check-in.
            </span>
          </li>
          <li class="flex items-start bg-pink-50 hover:bg-pink-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Lưu giữ ảnh & kỷ niệm trong Album tình yêu theo thời gian.
            </span>
          </li>
          <li class="flex items-start bg-pink-50 hover:bg-pink-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Love Map hiển thị tất cả địa điểm hẹn hò.
            </span>
          </li>
        </ul>
      </div>

      <!-- Yêu Xa -->
      <div class="bg-white rounded-2xl shadow-xl p-5 sm:p-6 transform transition duration-300">
        <div class="flex items-center mb-4">
          <div class="text-3xl text-pink-500 mr-3">💌</div>
          <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">Yêu Xa</h3>
        </div>
        <ul class="space-y-3">
          <li class="flex items-start bg-purple-50 hover:bg-purple-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Chat realtime với ảnh và voice message.
            </span>
          </li>
          <li class="flex items-start bg-purple-50 hover:bg-purple-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Secret Letter: gửi thư tình hẹn ngày mở.
            </span>
          </li>
          <li class="flex items-start bg-purple-50 hover:bg-purple-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Heartbeat Signal: “Nhớ em/anh” gửi thông báo ngay.
            </span>
          </li>
          <li class="flex items-start bg-purple-50 hover:bg-purple-100 transition p-3 rounded-lg shadow-sm">
            <span class="flex-shrink-0 text-pink-500 text-xl mr-3">✔️</span>
            <span class="text-gray-700 text-sm sm:text-base leading-relaxed">
              Mood Tracker: cập nhật cảm xúc hàng ngày, biểu đồ tổng hợp.
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Features Near Section -->
<section id="features-near" class="py-10 sm:py-16 bg-gradient-to-b from-gray-50 to-white opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4">
    <!-- Section Title -->
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600 drop-shadow-md">
      Tính Năng Cho Yêu Gần
    </h2>
    <p class="text-base sm:text-lg md:text-xl text-gray-600 text-center max-w-lg sm:max-w-3xl mx-auto mb-10 leading-relaxed">
      Tập trung vào check-in thực tế và lưu giữ kỷ niệm ngoài đời thực cho các cặp đôi có thể gặp mặt thường xuyên.
    </p>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-qrcode text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-pink-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Check-in NFC/QR</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Mỗi lần gặp mặt, quét NFC/QR để ghi dấu kỷ niệm. Theo dõi streak (chuỗi ngày gặp nhau liên tục) để giữ lửa tình yêu.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-images text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-purple-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Memories</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Upload ảnh chụp cùng nhau, địa điểm hẹn hò. Tạo album tình yêu theo mốc thời gian để ôn lại kỷ niệm đẹp.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-map text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Love Map</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Bản đồ hiển thị tất cả nơi từng đi cùng nhau, giúp tái hiện hành trình tình yêu một cách sống động.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-tasks text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Love Challenge – Gặp Mặt</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Nhiệm vụ hẹn hò như “Đi ăn kem cùng nhau” hoặc “Chụp 10 tấm ảnh trong 1 buổi”. Hoàn thành để tăng LoveScore.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-gamepad text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Mini Game Offline</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Các trò chơi như “Ai cười trước thua” hoặc “Hỏi nhanh – đáp nhanh” khi đang ở cạnh nhau để tăng sự gắn kết.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-bell text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Anniversary Reminder</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Nhắc kỷ niệm hẹn hò, sinh nhật, ngày đặc biệt để không bao giờ quên những mốc quan trọng.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Features Far Section -->
<section id="features-far" class="py-10 sm:py-16 bg-gradient-to-r from-pink-100 via-purple-100 to-blue-100 opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4">
    <!-- Section Title -->
    <h2 class="text-3xl md:text-5xl font-extrabold text-center mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600 drop-shadow-md">
      Tính Năng Cho Yêu Xa
    </h2>
    <p class="text-base sm:text-lg md:text-xl text-gray-600 text-center max-w-lg sm:max-w-3xl mx-auto mb-10 leading-relaxed">
      Tập trung vào kết nối cảm xúc từ xa và giao tiếp thường xuyên cho các cặp đôi ít gặp mặt.
    </p>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-envelope text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-pink-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Hộp Thư Tình / Chat</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Nhắn tin realtime với AJAX, gửi ảnh, voice message để giữ liên lạc hàng ngày.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-lock text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-purple-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Secret Letter</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Gửi thư tình có thể hẹn ngày mở, tạo sự bất ngờ và lãng mạn từ xa.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-heartbeat text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Heartbeat Signal</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Nút “Nhớ em/anh” gửi thông báo ngay lập tức để đối phương cảm nhận được tình cảm.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-chart-line text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Mood Tracker</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Cập nhật cảm xúc mỗi ngày, hiển thị biểu đồ cảm xúc chung để hiểu nhau hơn.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-book-open text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Love Diary Online</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Viết nhật ký, mỗi người thấy bài viết của người kia để chia sẻ suy nghĩ hàng ngày.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-tasks text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Love Challenge – Online</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Thử thách như “Viết 3 điều em/anh yêu ở đối phương hôm nay” hoặc “Chia sẻ 1 bài hát nhớ nhau”.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Security Section -->
<section id="security" class="py-10 sm:py-16 bg-gradient-to-b from-gray-50 to-white opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4 text-center">
    <!-- Section Title -->
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600 drop-shadow-md">
      Bảo Mật & An Toàn
    </h2>
    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-lg sm:max-w-3xl mx-auto mb-10 leading-relaxed">
      LoveApp cam kết bảo vệ dữ liệu tình yêu của bạn với các biện pháp bảo mật tiên tiến.
    </p>

    <!-- Security Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-shield-alt text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-pink-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Chống XSS & Injection</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Sử dụng các kỹ thuật lọc đầu vào, mã hóa dữ liệu để ngăn chặn XSS, SQL injection, và các lỗ hổng bảo mật phổ biến.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-lock text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-purple-400 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Login Bằng NFC</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Cả hai thành viên cặp đôi đều login bằng NFC để đảm bảo tính riêng tư và an toàn, tránh truy cập trái phép.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-cloud text-5xl sm:text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Dữ Liệu Mã Hóa</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Tất cả dữ liệu cá nhân, ảnh, tin nhắn được mã hóa và lưu trữ an toàn trên server bảo mật cao.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 text-center">
        <i class="fas fa-user-secret text-5xl sm:text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 animate-pulse inline-block"></i>
        <h3 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Phần Private Riêng Biệt</h3>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
          Các chức năng cho cặp đôi được đặt trên subdomain riêng, chỉ truy cập sau khi login bằng NFC.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- How to Use Section -->
<section id="how-to-use" class="py-10 sm:py-16 bg-white opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4">
    <!-- Section Title -->
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-600 via-pink-500 to-purple-600 drop-shadow-md">
      Bắt Đầu Với LoveApp
    </h2>

    <!-- Grid layout -->
    <div class="grid gap-4 md:gap-6 md:grid-cols-2 max-w-6xl mx-auto">

      <!-- Step 1 -->
      <div class="flex items-start bg-gray-50 p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
        <span class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-pink-400 text-white font-bold text-base sm:text-lg mr-4">
          1
        </span>
        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
          Đặt mua thẻ NFC từ LoveApp để kích hoạt tài khoản với công nghệ an toàn. Thẻ NFC sẽ là chìa khóa cho mọi tính năng.
        </p>
      </div>

      <!-- Step 2 -->
      <div class="flex items-start bg-gray-50 p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
        <span class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-purple-400 text-white font-bold text-base sm:text-lg mr-4">
          2
        </span>
        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
          Quét thẻ NFC trên điện thoại để đăng nhập vào không gian riêng tư của cặp đôi (qua subdomain private).
        </p>
      </div>

      <!-- Step 3 -->
      <div class="flex items-start bg-gray-50 p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
        <span class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-pink-400 text-white font-bold text-base sm:text-lg mr-4">
          3
        </span>
        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
          Chọn chế độ Yêu Gần hoặc Yêu Xa để khám phá các tính năng phù hợp, như check-in, Love Map, hoặc chat realtime.
        </p>
      </div>

      <!-- Step 4 -->
      <div class="flex items-start bg-gray-50 p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
        <span class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-base sm:text-lg mr-4">
          4
        </span>
        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
          Lưu giữ kỷ niệm bằng cách upload ảnh, viết nhật ký, hoặc hoàn thành thử thách để tăng LoveScore và gắn kết hơn.
        </p>
      </div>

      <!-- Step 5 full-width -->
      <div class="flex items-start md:items-center md:text-center justify-start md:justify-center bg-gray-50 p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 md:col-span-2">
        <span class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold text-base sm:text-lg mr-4">
          5
        </span>
        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
          Nhận thông báo nhắc nhở kỷ niệm và cập nhật cảm xúc hàng ngày để duy trì sự kết nối bền vững.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- Purchase Section with Form -->
<section id="purchase" class="py-12 sm:py-16 md:py-20 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 text-white opacity-0 translate-y-8 transition-all duration-700 ease-out fade-section scroll-mt-20">
  <div class="container mx-auto px-4 text-center">
    <!-- Title -->
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 sm:mb-6 md:mb-8 bg-clip-text text-transparent bg-gradient-to-r from-pink-200 via-purple-200 to-white drop-shadow-lg">
      Đặt Mua Thẻ NFC Ngay Hôm Nay
    </h2>
    <p class="text-base sm:text-lg md:text-xl mb-6 sm:mb-8 md:mb-10 max-w-3xl mx-auto leading-relaxed">
      Bắt đầu hành trình tình yêu của bạn với thẻ NFC độc quyền từ LoveApp. An toàn, đơn giản, đầy ý nghĩa! Điền thông tin dưới đây để đặt mua.
    </p>

    <form id="order-form" class="max-w-4xl mx-auto bg-white text-gray-800 p-6 sm:p-8 md:p-10 rounded-3xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Thông tin nhận hàng -->
      <h3 class="md:col-span-2 text-xl sm:text-2xl font-bold text-pink-600 text-center">Thông Tin Nhận Hàng</h3>

      <div>
        <label for="receiver-name" class="block text-sm sm:text-base font-semibold mb-1 sm:mb-2 text-left">Họ và Tên</label>
        <input type="text" id="receiver-name" name="receiver_name" placeholder="Nguyễn Văn A" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300" required>
      </div>

      <div>
        <label for="receiver-email" class="block text-sm sm:text-base font-semibold mb-1 sm:mb-2 text-left">Email</label>
        <input type="email" id="receiver-email" name="receiver_email" placeholder="example@gmail.com" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300" required>
      </div>

      <div>
        <label for="receiver-address" class="block text-sm sm:text-base font-semibold mb-1 sm:mb-2 text-left">Địa Chỉ Giao Hàng</label>
        <input type="text" id="receiver-address" name="receiver_address" placeholder="Số nhà, đường, quận, TP" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300" required>
      </div>

      <div>
        <label for="receiver-phone" class="block text-sm sm:text-base font-semibold mb-1 sm:mb-2 text-left">Số Điện Thoại</label>
        <input type="tel" id="receiver-phone" name="receiver_phone" placeholder="0123 456 789" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300" required>
      </div>

      <!-- Thông tin thẻ NFC -->
      <h3 class="md:col-span-2 text-xl sm:text-2xl font-bold text-pink-600 text-center">Thông Tin Thẻ NFC</h3>

      <!-- Thẻ Nam -->
      <div class="md:col-span-1 bg-pink-50 p-4 sm:p-6 rounded-2xl shadow-inner border border-pink-200">
        <h4 class="font-semibold text-pink-500 mb-3 text-center md:text-left">Thẻ Nam</h4>
        <label for="male-name" class="block text-sm font-bold mb-1 text-left">Họ và Tên</label>
        <input type="text" id="male-name" name="male_name" placeholder="Nguyễn Văn A" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300" required>

        <label for="male-dob" class="block text-sm font-bold mt-3 mb-1 text-left">Ngày Sinh</label>
        <input type="date" id="male-dob" name="male_dob" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300">
      </div>

      <!-- Thẻ Nữ -->
      <div class="md:col-span-1 bg-purple-50 p-4 sm:p-6 rounded-2xl shadow-inner border border-purple-200">
        <h4 class="font-semibold text-purple-500 mb-3 text-center md:text-left">Thẻ Nữ</h4>
        <label for="female-name" class="block text-sm font-bold mb-1 text-left">Họ và Tên</label>
        <input type="text" id="female-name" name="female_name" placeholder="Nguyễn Thị B" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none transition duration-300" required>

        <label for="female-dob" class="block text-sm font-bold mt-3 mb-1 text-left">Ngày Sinh</label>
        <input type="date" id="female-dob" name="female_dob" class="w-full px-4 py-2 sm:px-5 sm:py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none transition duration-300">
      </div>

      <!-- Ngày Kỷ Niệm -->
      <div class="md:col-span-2">
        <label for="anniversary" class="block text-sm sm:text-base font-semibold mb-2 text-left md:text-center">Ngày Kỷ Niệm</label>
        <input type="date" id="anniversary" name="anniversary" class="w-full md:w-1/2 mx-auto md:mx-0 px-4 py-2 sm:px-5 sm:py-3 rounded-2xl border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition duration-300 shadow-sm">
      </div>

      <!-- Submit Button -->
      <div class="md:col-span-2 mt-4 sm:mt-6">
        <button type="submit" class="w-full bg-pink-600 text-white font-bold py-3 sm:py-4 rounded-2xl hover:bg-pink-700 shadow-lg hover:shadow-pink-300 transition duration-300 flex justify-center items-center space-x-2">
          <span>Đặt Hàng</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>
      </div>

    </form>
  </div>
</section>


<!-- Footer -->
<?php
include __DIR__  . '/../layout/footer.php';
?>