<div class="max-w-md mx-4 mt-6 p-6 bg-white rounded-3xl shadow fade-in transition-all duration-700 ease-out fade-section">
    <h2 class="text-2xl font-semibold text-pink-600 mb-6 text-center">Cài đặt bảo mật</h2>

    <form id="securitySettingsForm">

        <div class="mb-4">
            <label class="block text-gray-600 mb-2">Hiển thị hoạt động</label>
            <select name="show_activity" class="w-full border border-pink-300 rounded-2xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <button type="submit"
                class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-lg px-4 py-3 rounded-2xl w-full font-semibold shadow-md transition-all active:scale-95">
            💌 Lưu cài đặt
        </button>
    </form>
</div>

<script>
$(document).ready(function(){
    $('#securitySettingsForm').on('submit', function(e){
        e.preventDefault();
        const formData = $(this).serialize();

        // Đây chỉ là demo, bạn có thể gọi AJAX để lưu vào DB
        alert('Cài đặt bảo mật đã được lưu!');
    });
});
</script>
