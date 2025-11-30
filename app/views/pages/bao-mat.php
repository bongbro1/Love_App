<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="bg-gradient-to-b from-gray-50 via-white to-pink-50 py-8 md:py-12">

  <!-- HERO SECTION -->
  <div class="container mx-auto px-6 text-center mb-12">
    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-semibold rounded-full mb-6 shadow-lg">
      🔒 Bảo Mật & An Toàn
    </div>

    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
      Giữ An Toàn Cho <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">Tình Yêu Của Bạn</span>
    </h1>

    <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
      LoveApp hiểu rằng mỗi ký ức, tin nhắn hay hình ảnh đều là một phần quý giá của tình yêu.  
      Vì vậy, chúng tôi xây dựng hệ thống bảo mật đa tầng — giúp bạn yên tâm lưu giữ kỷ niệm mà không lo rủi ro.
    </p>
  </div>

  <!-- SECURITY GRID -->
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- 1. XSS & Injection -->
      <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 text-center">
        <i class="fas fa-shield-alt text-6xl bg-gradient-to-r from-pink-500 to-pink-400 text-transparent bg-clip-text mb-4 inline-block"></i>
        <h3 class="text-2xl font-bold mb-3 text-gray-800">Chống XSS & Injection</h3>
        <p class="text-gray-600 leading-relaxed mb-4">
          Mọi dữ liệu nhập vào đều được lọc và mã hóa nghiêm ngặt để ngăn chặn XSS, SQL Injection và các lỗ hổng bảo mật phổ biến.
        </p>
        <div class="text-pink-600 font-semibold">🛡️ An toàn ở từng dòng mã</div>
      </div>

      <!-- 2. NFC Login -->
      <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 text-center">
        <i class="fas fa-lock text-6xl bg-gradient-to-r from-purple-500 to-purple-400 text-transparent bg-clip-text mb-4 inline-block"></i>
        <h3 class="text-2xl font-bold mb-3 text-gray-800">Đăng Nhập Bằng NFC</h3>
        <p class="text-gray-600 leading-relaxed mb-4">
          Mỗi cặp đôi có thẻ NFC riêng, đảm bảo chỉ hai bạn có thể đăng nhập — không cần mật khẩu, không lo bị đánh cắp tài khoản.
        </p>
        <div class="text-purple-600 font-semibold">🔐 Bảo mật bằng công nghệ chạm</div>
      </div>

      <!-- 3. Data Encryption -->
      <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 text-center">
        <i class="fas fa-cloud text-6xl bg-gradient-to-r from-pink-500 to-purple-500 text-transparent bg-clip-text mb-4 inline-block"></i>
        <h3 class="text-2xl font-bold mb-3 text-gray-800">Mã Hóa Dữ Liệu Toàn Phần</h3>
        <p class="text-gray-600 leading-relaxed mb-4">
          Ảnh, tin nhắn, vị trí và nhật ký được mã hóa AES-256, lưu trữ an toàn trên server có chứng chỉ SSL và sao lưu định kỳ.
        </p>
        <div class="text-pink-600 font-semibold">☁️ Dữ liệu tình yêu được bảo vệ tuyệt đối</div>
      </div>

      <!-- 4. Private Zone -->
      <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 text-center">
        <i class="fas fa-user-secret text-6xl bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text mb-4 inline-block"></i>
        <h3 class="text-2xl font-bold mb-3 text-gray-800">Khu Vực Riêng Tư</h3>
        <p class="text-gray-600 leading-relaxed mb-4">
          Các tính năng dành riêng cho từng cặp đôi được đặt trong vùng Private Zone — chỉ mở khóa sau khi xác thực bằng NFC.
        </p>
        <div class="text-purple-600 font-semibold">🕶️ Không ai ngoài hai bạn có thể xem</div>
      </div>

    </div>
  </div>

  <!-- CTA -->
  <div class="text-center mt-12 md:mt-16 max-w-3xl mx-auto px-6">
    <h3 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-6">
      Tình Yêu Cần Được Bảo Vệ
    </h3>
    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
      LoveApp không chỉ giúp bạn lưu giữ kỷ niệm — mà còn bảo vệ chúng bằng công nghệ bảo mật cao nhất.  
      Hãy yên tâm yêu thương, vì mọi thứ quan trọng với bạn đều được chúng tôi giữ an toàn.
    </p>
    <a href="/love-app/public/#purchase" class="inline-block bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold py-4 px-12 rounded-full hover:scale-105 hover:shadow-2xl transition-all duration-300">
      🔐 Trải Nghiệm LoveApp Ngay
    </a>
  </div>

</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
