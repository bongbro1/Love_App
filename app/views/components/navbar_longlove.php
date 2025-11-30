<nav class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-pink-500/95 to-purple-500/95 backdrop-blur-md shadow-[0_-2px_10px_rgba(0,0,0,0.2)] z-40 border-t border-pink-300/40">
    <div class="flex justify-around items-center py-2 text-white text-xs font-medium">
        <button data-target="chat" class="tab-link flex flex-col items-center justify-center gap-1 opacity-80 hover:opacity-100 transition">
            <i class="fas fa-envelope text-xl"></i>
            <span>Thư</span>
        </button>
        <button data-target="moodtracker" class="tab-link flex flex-col items-center justify-center gap-1 opacity-80 hover:opacity-100 transition">
            <i class="fas fa-smile text-xl"></i>
            <span>Cảm Xúc</span>
        </button>
        <button data-target="diary" class="tab-link flex flex-col items-center justify-center gap-1 opacity-80 hover:opacity-100 transition">
            <i class="fas fa-book text-xl"></i>
            <span>Nhật Ký</span>
        </button>
        <button id="moreMenuBtn" data-target="more" class="tab-link flex flex-col items-center justify-center gap-1 opacity-80 hover:opacity-100 transition">
            <i class="fas fa-ellipsis-h text-xl"></i>
            <span>Khác</span>
        </button>
    </div>
</nav>

<!-- Overlay -->
<div id="overlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40 transition-opacity"></div>

<!-- Popup Menu -->
<div id="moreMenu" class="hidden fixed bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl border-t border-pink-100 animate-[slideUp_0.35s_ease-out] z-50">
    <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto my-3"></div>
    <div class="text-center pb-2 text-gray-600 font-semibold text-base border-b border-gray-100">✨ Tính năng khác</div>

    <div class="p-5 flex flex-col gap-4 text-gray-800 text-base">
        <button data-target="secretletter" class="tab-link flex items-center gap-4 hover:bg-pink-50 rounded-xl px-3 py-2 transition w-full text-left">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-pink-100 text-pink-500">
                <i class="fas fa-lock"></i>
            </div>
            <span class="font-medium">Thư Bí Mật</span>
        </button>

        <button data-target="challenges" class="tab-link flex items-center gap-4 hover:bg-yellow-50 rounded-xl px-3 py-2 transition w-full text-left">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-star"></i>
            </div>
            <span class="font-medium">Thử Thách</span>
        </button>

        <button data-target="minigame" class="tab-link flex items-center gap-4 hover:bg-purple-50 rounded-xl px-3 py-2 transition w-full text-left">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-gamepad"></i>
            </div>
            <span class="font-medium">Mini Game</span>
        </button>

        <button data-target="videoreminder" class="tab-link flex items-center gap-4 hover:bg-blue-50 rounded-xl px-3 py-2 transition w-full text-left">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-video"></i>
            </div>
            <span class="font-medium">Video Nhắc Nhở</span>
        </button>
    </div>

    <div class="p-4 border-t border-gray-100">
        <button id="closeMenu" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-purple-500 text-white font-semibold shadow-md hover:shadow-lg active:scale-95 transition">
            Đóng
        </button>
    </div>
</div>

<script>
    $(function() {
        const overlay = document.getElementById('overlay');
        const menu = document.getElementById('moreMenu');

        document.getElementById('moreMenuBtn').addEventListener('click', () => {
            overlay.classList.remove('hidden');
            menu.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 20);
        });

        document.getElementById('closeMenu').addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);

        function closeMenu() {
            overlay.classList.remove('opacity-100');
            setTimeout(() => {
                overlay.classList.add('hidden');
                menu.classList.add('hidden');
            }, 200);
        }

        const tabs = document.querySelectorAll('.tab-link');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.target;
                if (!target || target === 'more') return;

                window.location.href = `<?= BASE_URL ?>/longdistance/${target}`;
            });
        });
    });
</script>
