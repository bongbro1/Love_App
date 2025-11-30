<!-- Anniversary Reminder Section -->
<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="anniversary" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 text-center md:text-3xl">Nhắc Kỷ Niệm</h2>

            <!-- Danh sách kỷ niệm -->
            <div id="anniversary-list" class="max-h-80 overflow-y-auto space-y-3 mb-4">
            </div>

            <!-- Nút thêm kỷ niệm -->
            <button id="add-anniversary-btn" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-lg hover:from-pink-600 hover:to-purple-600 transition duration-300 text-base font-semibold mb-2">
                Thêm Kỷ Niệm
            </button>
        </div>
    </section>
</main>
<!-- Modal Thêm/Sửa Kỷ Niệm -->
<div id="add-anniversary-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative mx-6 modal-show">
        <h3 class="text-2xl font-bold text-pink-600 mb-4 text-center" id="anniversary-modal-title">Thêm Kỷ Niệm</h3>

        <div class="space-y-4">
            <!-- Tên kỷ niệm -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tên kỷ niệm</label>
                <input type="text" id="anniversary-title" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Ví dụ: Sinh nhật người ấy">
            </div>

            <!-- Ngày kỷ niệm -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Ngày</label>
                <input type="date" id="anniversary-date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>

            <!-- Lặp lại hàng năm -->
            <div class="flex items-center gap-2 justify-center">
                <input type="checkbox" id="anniversary-recurring" checked class="h-4 w-4">
                <label for="anniversary-recurring" class="text-gray-700 font-medium">Lặp lại hàng năm</label>
            </div>

            <!-- Số ngày nhắc trước -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nhắc trước (ngày)</label>
                <input type="number" id="anniversary-reminder-days" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" value="1" min="0">
            </div>
        </div>

        <!-- Nút Hủy / Lưu -->
        <div class="flex justify-end gap-3 mt-6">
            <button id="cancel-add-anniversary" class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400 transition">Hủy</button>
            <button id="save-add-anniversary" class="px-4 py-2 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 text-white hover:from-pink-600 hover:to-purple-600 transition" data-mode="add">Lưu</button>
        </div>

        <!-- Nút đóng modal -->
        <button id="close-add-anniversary" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
    </div>
</div>



<?php include __DIR__ . '/../components/navbar_nearlove.php'; ?>


<script>
    $(function() {

        // load
        let anniversaryPage = 1;
        const anniversaryPageSize = 10;
        let loadingAnniversary = false;
        let allAnniversariesLoaded = false;

        function loadAnniversaryList(reset = false) {
            if (loadingAnniversary || allAnniversariesLoaded) return;

            loadingAnniversary = true;
            if (reset) {
                anniversaryPage = 1;
                allAnniversariesLoaded = false;
                $("#anniversary-list").empty();
            }

            $.ajax({
                url: "index.php?action=anniversary_list",
                method: "GET",
                data: {
                    page: anniversaryPage,
                    pageSize: anniversaryPageSize
                },
                dataType: "json",
                success: function(res) {
                    const list = $("#anniversary-list");

                    if (!res.success || !res.data || res.data.length === 0) {
                        if (anniversaryPage === 1) {
                            list.append(`<p class="text-center text-gray-400 py-4">Chưa có kỷ niệm nào</p>`);
                        }
                        allAnniversariesLoaded = true;
                        return;
                    }

                    res.data.forEach(item => {
                        const date = new Date(item.date);
                        const today = new Date();

                        // Nếu không lặp hàng năm mà đã qua, bỏ qua
                        if (!item.is_recurring && date < today) return;

                        // Nếu lặp hàng năm, tính ngày còn lại từ năm hiện tại
                        let displayDate = date;
                        if (item.is_recurring) {
                            displayDate = new Date(today.getFullYear(), date.getMonth(), date.getDate());
                            if (displayDate < today) {
                                displayDate.setFullYear(today.getFullYear() + 1);
                            }
                        }

                        const diffTime = displayDate.getTime() - today.getTime();
                        const daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        const formattedDate = date.toLocaleDateString("vi-VN", {
                            day: "2-digit",
                            month: "2-digit",
                            year: "numeric"
                        });

                        const itemHTML = `
                    <div class="flex justify-between items-start p-3 bg-white rounded-xl shadow hover:shadow-lg transition duration-300 border border-gray-100 mb-2">
                        <div class="flex-1">
                            <p class="font-semibold text-base text-pink-600">${item.title}</p>
                            <p class="text-gray-500 text-sm">${formattedDate} - Còn ${daysLeft} ngày</p>
                        </div>
                        <div class="flex gap-2 text-gray-500">
                            <button 
                                class="edit-anniversary-btn transition flex items-center justify-center border border-gray-300 rounded-full w-6 h-6 hover:border-yellow-400 hover:text-yellow-500"
                                data-id="${item.id}"
                                data-title="${item.title}"
                                data-date="${item.date}"
                                title="Sửa"
                            >
                                <i class="fa fa-pencil" style="font-size:13px;"></i>
                            </button>

                            <button 
                                class="remove-anniversary-btn transition flex items-center justify-center border border-gray-300 rounded-full w-6 h-6 hover:border-red-400 hover:text-red-600"
                                data-id="${item.id}"
                                title="Xóa"
                            >
                                <i class="far fa-trash-alt" style="font-size:13px;"></i>
                            </button>
                        </div>
                    </div>
                `;
                        list.append(itemHTML);
                    });

                    if (res.data.length < anniversaryPageSize) {
                        allAnniversariesLoaded = true;
                    } else {
                        anniversaryPage++;
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi khi tải danh sách kỷ niệm:", status, error);
                },
                complete: function() {
                    loadingAnniversary = false;
                }
            });
        }

        // Lắng nghe scroll để load tiếp
        $("#anniversary-list").on("scroll", function() {
            const $this = $(this);
            if ($this.scrollTop() + $this.innerHeight() >= this.scrollHeight - 50) {
                loadAnniversaryList();
            }
        });

        // Load lần đầu
        $(document).ready(function() {
            loadAnniversaryList(true);
        });

        $(document).on("click", ".edit-anniversary-btn", function() {
            const id = $(this).data("id");
            const title = $(this).data("title");
            const date = $(this).data("date");

            $("#anniversary-title").val(title);
            $("#anniversary-date").val(date);

            $("#save-add-anniversary").data("mode", "edit").data("id", id);
            $("#anniversary-modal-title").text("Sửa Kỷ Niệm");
            $("#add-anniversary-modal").removeClass("hidden");
        });

        $(document).on("click", ".remove-anniversary-btn", function() {
            const id = $(this).data("id");

            Swal.fire({
                title: "Xóa kỷ niệm?",
                text: "Bạn chắc chắn muốn xóa kỷ niệm này?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then(result => {
                if (!result.isConfirmed) return;

                $.post("index.php?action=anniversary_delete", {
                    id
                }, function(res) {
                    if (res.success) {
                        loadAnniversaryList(true);
                        Swal.fire("Đã xóa!", "", "success");
                    } else {
                        Swal.fire("Lỗi!", res.message, "error");
                    }
                }, "json");
            });
        });



        $("#save-add-anniversary").on("click", function() {
            const title = $("#anniversary-title").val().trim();
            const date = $("#anniversary-date").val().trim();
            const isRecurring = $("#anniversary-recurring").is(":checked") ? 1 : 0;
            const reminderDays = parseInt($("#anniversary-reminder-days").val()) || 1;

            if (!title || !date) {
                Swal.fire("Thiếu dữ liệu", "Vui lòng nhập đầy đủ thông tin", "warning");
                return;
            }

            const mode = $(this).data("mode");
            const postData = {
                title,
                date,
                isRecurring,
                reminderDays
            };

            let actionUrl = "index.php?action=anniversary_add";

            if (mode === "edit") {
                actionUrl = "index.php?action=anniversary_update";
                postData.id = $(this).data("id");
            }

            $.post(actionUrl, postData, function(res) {
                if (res.success) {
                    Swal.fire("Thành công!", res.message, "success");

                    $("#add-anniversary-modal").addClass("hidden");
                    $("#anniversary-title").val("");
                    $("#anniversary-date").val("");
                    $("#save-add-anniversary").data("mode", "add").removeData("id");
                    $("#anniversary-modal-title").text("Thêm Kỷ Niệm");

                    loadAnniversaryList(true);
                } else {
                    Swal.fire("Lỗi!", res.message, "error");
                }
            }, "json");
        });





        $('#add-anniversary-btn').on('click', function() {
            $('#add-anniversary-modal').removeClass('hidden');
        });

        // Hide modal
        $("#cancel-add-anniversary, #close-add-anniversary, #add-anniversary-modal").on("click", function(e) {
            if (e.target !== this) return; // chỉ click ngoài modal mới đóng
            $("#add-anniversary-modal").addClass("hidden");
            $("#anniversary-title").val("");
            $("#anniversary-date").val("");
            $("#save-add-anniversary").data("mode", "add").removeData("id");
            $("#anniversary-modal-title").text("Thêm Kỷ Niệm");
        });
        $('#add-anniversary-modal').on('click', function(e) {
            // Nếu click trực tiếp trên overlay (chứ không phải con của nó)
            if (e.target.id === 'add-anniversary-modal') {
                $(this).addClass('hidden');
            }
        });
    })
</script>