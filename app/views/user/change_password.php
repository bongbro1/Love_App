<div class="max-w-md mt-6 p-6 bg-white rounded-3xl shadow mx-4 fade-in transition-all duration-700 ease-out fade-section">
    <h2 class="text-2xl font-semibold text-pink-600 mb-6 text-center">Đổi mật khẩu</h2>

    <form id="changePasswordForm">
        <input type="password" name="old_password" placeholder="Mật khẩu cũ"
            class="w-full border border-pink-300 rounded-2xl p-3 mb-4 text-center focus:outline-none focus:ring-2 focus:ring-pink-400 transition">

        <input type="password" name="new_password" placeholder="Mật khẩu mới"
            class="w-full border border-pink-300 rounded-2xl p-3 mb-4 text-center focus:outline-none focus:ring-2 focus:ring-pink-400 transition">

        <button type="submit"
            class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-lg px-4 py-3 rounded-2xl w-full font-semibold shadow-md transition-all active:scale-95">
            💌 Xác nhận
        </button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: 'index.php?action=update_password',
                method: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $('#changePasswordForm button')
                        .prop('disabled', true)
                        .addClass('opacity-60')
                        .text('Đang xử lý...');
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: res.msg || 'Mật khẩu đã được cập nhật',
                            confirmButtonColor: '#ec4899'
                        }).then(() => {
                            $('#changePasswordForm')[0].reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: res.msg || 'Có lỗi xảy ra!',
                            confirmButtonColor: '#ec4899'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi kết nối!',
                        text: 'Không thể kết nối đến server. Vui lòng thử lại sau!',
                        confirmButtonColor: '#ec4899'
                    });
                },
                complete: function() {
                    $('#changePasswordForm button')
                        .prop('disabled', false)
                        .removeClass('opacity-60')
                        .text('💌 Xác nhận');
                }
            });
        });
    });
</script>