let ws;

let currentImages = [];
let currentIndex = 0;

function openImageModal(images, startIndex = 0) {
    currentImages = images;
    currentIndex = startIndex;
    if (!currentImages.length) return;

    let imgSrc = currentImages[currentIndex];

    // Nếu không phải base64, thêm BASE_URL
    if (!imgSrc.startsWith('data:')) {
        imgSrc = `${BASE_URL}${imgSrc}`;
    }

    $('#modalImage').attr('src', imgSrc);
    $('#imageModal').removeClass('hidden').addClass('flex');
}

function closeImageModal() {
    $('#imageModal').addClass('hidden').removeClass('flex');
}

function showImage(index) {
    if (!currentImages.length) return;

    if (index < 0) index = currentImages.length - 1;
    if (index >= currentImages.length) index = 0;
    currentIndex = index;

    let imgSrc = currentImages[currentIndex];

    // Nếu không phải base64, thêm BASE_URL
    if (!imgSrc.startsWith('data:')) {
        imgSrc = `${BASE_URL}${imgSrc}`;
    }

    $('#modalImage').attr('src', imgSrc);
}


// --- Event binding ---
$(document).ready(() => {
    $('#modalClose').on('click', closeImageModal);
    $('#prevImage').on('click', () => showImage(currentIndex - 1));
    $('#nextImage').on('click', () => showImage(currentIndex + 1));

    // Đóng modal khi nhấn nền tối
    $('#imageModal').on('click', function (e) {
        if (e.target.id === 'imageModal') closeImageModal();
    });

    // Bổ sung điều khiển bằng phím mũi tên
    $(document).on('keydown', function (e) {
        if ($('#imageModal').hasClass('hidden')) return;
        if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
        if (e.key === 'ArrowRight') showImage(currentIndex + 1);
        if (e.key === 'Escape') closeImageModal();
    });
});
