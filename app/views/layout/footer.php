<footer class="bg-gradient-to-t from-gray-900 via-gray-800 to-gray-900 text-white py-4 md:py-8">
    <div class="container mx-auto px-4 flex flex-col justify-between items-center gap-4">

      <!-- Logo & Description -->
      <div class="flex-1 text-center md:text-left">
        <h3 class="text-2xl sm:text-3xl font-extrabold mb-2 sm:mb-3 bg-clip-text text-transparent bg-gradient-to-r from-pink-400 via-purple-400 to-blue-400 text-center">
          LoveApp
        </h3>
        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
          Kết nối tình yêu, lưu giữ những khoảnh khắc đáng nhớ, dù bạn ở bất kỳ đâu.
        </p>
      </div>

      <!-- Social & Quick Links -->
      <div class="flex-1 flex flex-col items-center md:items-center gap-4 sm:gap-6">
        <!-- Social Icons -->
        <div class="flex space-x-4 sm:space-x-6">
          <a href="#" class="text-gray-400 hover:text-white transition duration-300 transform hover:scale-110">
            <i class="fab fa-facebook-f text-xl sm:text-2xl"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition duration-300 transform hover:scale-110">
            <i class="fab fa-instagram text-xl sm:text-2xl"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition duration-300 transform hover:scale-110">
            <i class="fab fa-twitter text-xl sm:text-2xl"></i>
          </a>
        </div>

        <!-- Quick Links (hidden mobile) -->
        <div class="hidden sm:flex flex-wrap justify-center gap-4 sm:gap-6 text-xs sm:text-sm">
          <a href="#" class="text-gray-400 hover:text-white transition">Liên Hệ</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Chính Sách Bảo Mật</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Điều Khoản Dịch Vụ</a>
        </div>
      </div>

      <!-- Copyright -->
      <div class="flex-1 text-center md:text-right text-gray-400 text-xs sm:text-sm">
        &copy; 2025 LoveApp. Tất cả quyền được bảo lưu.
      </div>

    </div>
  </footer>


  <script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Mini Game Logic
    function showResult(choice) {
      const resultDiv = document.getElementById('quiz-result');
      let message = '';
      if (choice === 'A') {
        message = 'Ôi, bạn thật lãng mạn! Nụ cười của người ấy là nguồn cảm hứng lớn nhất của bạn!';
      } else if (choice === 'B') {
        message = 'Bạn trân trọng sự chân thành! Điều này làm tình yêu của bạn sâu sắc và bền vững.';
      } else if (choice === 'C') {
        message = 'Những khoảnh khắc bên nhau là điều bạn yêu nhất! Bạn là người sống cho hiện tại.';
      }
      resultDiv.textContent = message;
      resultDiv.classList.remove('hidden');
      resultDiv.classList.add('text-pink-600', 'font-semibold');
    }


    // Navbar highlight
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          navLinks.forEach(link => link.classList.remove("text-pink-500", "font-bold"));
          const activeLink = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
          if (activeLink) activeLink.classList.add("text-pink-500", "font-bold");
        }
      });
    }, {
      threshold: 0.6
    });

    sections.forEach(section => observer.observe(section));

    // Section fade-in
    const faders = document.querySelectorAll(".fade-section");

    const fadeObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove("opacity-0", "translate-y-8");
          entry.target.classList.add("opacity-100", "translate-y-0");
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.3
    });

    faders.forEach(section => fadeObserver.observe(section));


    //  logic
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('order-form');
      form.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(form);
        try {
          const res = await fetch('index.php?action=order', {
            method: 'POST',
            body: formData
          });
          const data = await res.json();
          Swal.fire({
            icon: data.success ? 'success' : 'error',
            title: data.message || (data.success ? 'Thành công!' : 'Có lỗi xảy ra'),
            timer: data.success ? 2000 : null,
            showConfirmButton: true
          });
        } catch (err) {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi khi gửi dữ liệu',
            text: err.message || err
          });
        }
      });
    });
  </script>



  <script>
    /**
     * Hàm xử lý JSON trả về từ backend và show alert
     * @param {Object} data - JSON từ server
     */
    function handleJsonResponse(data) {
      if (!data) return;

      // Kiểu thông báo
      let icon = 'info';
      if (data.success === true) icon = 'success';
      else if (data.success === false) icon = 'error';

      Swal.fire({
        icon: icon,
        title: data.message || (data.success ? 'Thành công!' : 'Có lỗi xảy ra'),
        timer: data.success ? 2000 : null,
        showConfirmButton: true
      });
    }
  </script>
</body>

</html>