

let ws;
let currentImages = [];
let currentIndex = 0;

$(document).on('click', '.chat-image', function () {
    currentImages = $(this).data('images'); // ảnh của tin nhắn này
    currentIndex = $(this).data('index');
    $('#modalImage').attr('src', `${BASE_URL}${currentImages[currentIndex]}`);
    $('#imageModal').removeClass('hidden').addClass('flex');
});

$('#modalClose').on('click', () => $('#imageModal').addClass('hidden').removeClass('flex'));
$('#prevImage').on('click', () => showImage(currentIndex - 1));
$('#nextImage').on('click', () => showImage(currentIndex + 1));

function showImage(index) {
    if (!currentImages.length) return;
    if (index < 0) index = currentImages.length - 1;
    if (index >= currentImages.length) index = 0;
    currentIndex = index;
    $('#modalImage').attr('src', `${BASE_URL}${currentImages[currentIndex]}`);
}

// Navbar highlight
// Mở popup
const overlay = document.getElementById('overlay');
const menu = document.getElementById('moreMenu');

document.getElementById('moreMenuBtn').addEventListener('click', () => {
    overlay.classList.remove('hidden');
    menu.classList.remove('hidden');
    setTimeout(() => overlay.classList.add('opacity-100'), 10);
});

// Đóng popup
document.getElementById('closeMenu').addEventListener('click', closeMenu);
overlay.addEventListener('click', closeMenu);

function closeMenu() {
    overlay.classList.remove('opacity-100');
    setTimeout(() => {
        overlay.classList.add('hidden');
        menu.classList.add('hidden');
    }, 200);
}

// Highlight tab đang chọn
const tabs = document.querySelectorAll('.tab-link');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});


$(function () {
    const $tabs = $(".tab-link");
    const $overlay = $("#overlay");
    const $menu = $("#moreMenu");
    const $close = $("#closeMenu");
    const $sections = $(".page-section");

    // 🧭 Khi click tab chính
    $tabs.on("click", function () {
        const target = $(this).data("target");

        if (target === "more") {
            $overlay.removeClass("hidden");
            $menu.removeClass("hidden");
            return;
        }

        // Ẩn popup nếu mở
        $overlay.addClass("hidden");
        $menu.addClass("hidden");

        // Ẩn tất cả section
        $sections.addClass("hidden");

        // Hiện section tương ứng
        $("#" + target).removeClass("hidden");

        // Cập nhật trạng thái active tab
        $tabs.removeClass("opacity-100");
        $(this).addClass("opacity-100");

        // Cuộn lên đầu trang
        $("html, body").animate({
            scrollTop: 0
        }, 300);
    });

    // 🪄 Khi click trong popup menu
    $menu.find("button[data-target]").on("click", function () {
        const target = $(this).data("target");

        $overlay.addClass("hidden");
        $menu.addClass("hidden");

        $sections.addClass("hidden");
        $("#" + target).removeClass("hidden");

        // Highlight tab đầu tiên (ví dụ là "Khác" vẫn sáng)
        $tabs.removeClass("opacity-100");
        $("#moreMenuBtn").addClass("opacity-100");
    });

    // 🧹 Đóng popup
    $overlay.add($close).on("click", function () {
        $overlay.addClass("hidden");
        $menu.addClass("hidden");
    });
});

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