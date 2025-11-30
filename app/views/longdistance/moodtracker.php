<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <section id="mood-tracker" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 py-4 px-2">

            <h2 class="text-3xl font-bold text-pink-600 mb-6 text-center">Cảm xúc tình yêu</h2>

            <div class="grid md:grid-cols-2 gap-10">
                <!-- Nhập mood -->
                <div>
                    <label class="block text-gray-600 font-medium mb-2">Cảm xúc hôm nay:</label>

                    <select id="mood-select"
                        class="w-full p-3 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
                        <option value="very_happy">Rất vui 😍</option>
                        <option value="happy">Vui 😊</option>
                        <option value="neutral">Bình thường 😐</option>
                        <option value="sad">Buồn 😢</option>
                        <option value="very_sad">Rất buồn 😭</option>
                    </select>

                    <textarea id="mood-note"
                        class="w-full mt-3 p-3 border border-pink-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none"
                        placeholder="Viết ghi chú ngắn (tuỳ chọn)..."></textarea>

                    <button id="update-mood-btn"
                        class="mt-4 w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-3 rounded-full font-semibold shadow hover:scale-[1.02] transition focus:outline-none">
                        💌 Cập nhật cảm xúc
                    </button>
                </div>


                <!-- Biểu đồ -->
                <div class="space-y-6">
                    <h3 class="text-gray-700 font-semibold text-center">Biểu đồ cảm xúc chung</h3>
                    <div class="flex justify-center mb-4">
                        <div class="relative w-48">
                            <select id="mood-filter"
                                class="appearance-none w-full bg-white border border-pink-300 rounded-xl px-4 py-2 pr-8 text-gray-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                                <option value="today">Hôm nay</option>
                                <option value="week">Tuần này</option>
                                <option value="month">Tháng này</option>
                            </select>
                            <!-- Mũi tên custom -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-md mx-auto mt-6">
                        <canvas id="moodSummaryChart" height="250"></canvas>
                        <p id="no-data-msg" class="hidden text-gray-500 italic mt-4 text-center">Chưa có dữ liệu cảm xúc 😴</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>


<script>
    // Mood tracker
    $(document).ready(function() {

        function loadMoodStats(filter = 'today') {
            $.ajax({
                url: 'index.php?action=mood_stats',
                method: 'GET',
                dataType: 'json',
                data: {
                    filter: filter
                },
                success: function(data) {
                    const summaryLabels = {
                        'very_happy': 'Rất vui 😍',
                        'happy': 'Vui 😊',
                        'neutral': 'Bình thường 😐',
                        'sad': 'Buồn 😢',
                        'very_sad': 'Rất buồn 😭'
                    };

                    const canvas = document.getElementById('moodSummaryChart');
                    if (!canvas) {
                        return;
                    }

                    const ctx = canvas.getContext('2d');
                    const msg = document.getElementById('no-data-msg');
                    if (window.doughnutChart) window.doughnutChart.destroy();

                    const summaryData = Object.keys(summaryLabels).map(k => data.summary?.[k] || 0);
                    const total = summaryData.reduce((a, b) => a + b, 0);

                    if (total === 0) {
                        // Ẩn biểu đồ, hiện thông báo
                        ctx.canvas.style.display = 'none';
                        msg.classList.remove('hidden');
                        return;
                    }

                    // Có dữ liệu thì hiển thị biểu đồ
                    ctx.canvas.style.display = 'block';
                    msg.classList.add('hidden');

                    window.doughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: Object.values(summaryLabels),
                            datasets: [{
                                data: Object.keys(summaryLabels).map(k => data.summary[k] || 0),
                                backgroundColor: ['#F472B6', '#F9A8D4', '#FCD34D', '#93C5FD', '#C4B5FD'],
                                borderColor: '#fff',
                                borderWidth: 3
                            }]
                        },
                        options: {
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                },
                error: function(err) {
                    console.error("Không thể load dữ liệu mood stats:", err);
                }
            });
        }

        // Filter change
        $('#mood-filter').on('change', function() {
            loadMoodStats($(this).val());
        });

        // Cập nhật mood
        $('#update-mood-btn').on('click', function() {
            const mood = $('#mood-select').val();
            const note = $('#mood-note').val();

            $.ajax({
                url: 'index.php?action=mood_update',
                method: 'POST',
                dataType: 'json',
                data: {
                    mood,
                    note
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'Cảm xúc hôm nay đã được lưu!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadMoodStats($('#mood-filter').val());
                    } else {
                        alert(res.message || "Có lỗi xảy ra!");
                    }
                },
                error: function(err) {
                    console.error("Cập nhật mood thất bại:", err);
                    alert("Có lỗi khi gửi dữ liệu!");
                }
            });
        });

        // Load chart mặc định
        loadMoodStats();
    });
</script>