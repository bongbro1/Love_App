 <!-- Love Challenge Section -->
 <main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
     <section id="challenges" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
         <div class=" p-4 rounded-2xl bg-gradient-to-br from-pink-50 to-white shadow-md transition-all duration-300">
             <h2 class="text-3xl md:text-4xl font-bold text-pink-600 mb-6 text-center">Thử Thách Tình Yêu</h2>

             <div id="challenge-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[28rem] overflow-y-auto">
                 <!-- Challenge items sẽ append vào đây -->
             </div>

             <div class="flex justify-center mt-4">
                 <button id="add-challenge-btn" class="flex items-center gap-2 bg-pink-600 text-white px-6 py-2 rounded-full hover:bg-pink-700 shadow-md hover:shadow-lg transition-all duration-300">
                     <i class="fas fa-plus"></i> Thêm thử thách
                 </button>
             </div>

             <div id="total-score" class="mt-6 w-full max-w-xs mx-auto text-center bg-pink-100 text-pink-700 font-bold text-lg md:text-xl px-4 py-2 rounded-full shadow-md transition-all duration-300">
                 LoveScore: <span id="score-value">0</span>
             </div>

         </div>
         <div class="mt-8 p-4 bg-white rounded-2xl shadow-md">
             <h3 class="text-lg font-bold text-pink-600 mb-4 text-center">Lịch sử hoàn thành thử thách</h3>

             <div id="challenge-history" class="max-h-64 overflow-y-auto">
             </div>

         </div>
         <div id="challenge-history-detail-modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 overflow-auto modal-show">
             <div class="bg-white w-full max-w-lg rounded-3xl flex flex-col max-h-[80vh] border-2 border-pink-200">
                 <div class="p-6 flex-1 overflow-auto">
                     <h3 id="history-detail-title" class="text-2xl font-bold text-pink-600 mb-4 text-center"></h3>
                     <p id="history-detail-desc" class="text-gray-700 mb-4 text-center"></p>
                     <div id="history-detail-task-list" class="space-y-2">
                         <!-- Tasks append -->
                     </div>
                 </div>
                 <div class="flex justify-end gap-4 p-4 border-t border-gray-200">
                     <button id="history-detail-close-btn" class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400 transition focus:outline-none">Đóng</button>
                 </div>
             </div>
         </div>


         <!-- Popup thêm thử thách -->
         <div id="challenge-modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 h-[70vh] overflow-auto modal-show pb-3">
             <div class="bg-white w-full max-w-lg h-full">
                 <h3 class="text-2xl font-bold text-pink-600 mb-4 text-center">Thêm Thử Thách</h3>

                 <!-- Thông tin challenge -->
                 <input id="new-challenge-name" type="text" placeholder="Tên thử thách"
                     class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                 <textarea id="new-challenge-desc" placeholder="Mô tả thử thách"
                     class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-xl resize-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none"></textarea>
                 <input id="new-challenge-score" type="number" placeholder="LoveScore"
                     class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                 <select id="new-challenge-type"
                     class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                     <option value="1">Offline</option>
                     <option value="0">Online</option>
                 </select>

                 <!-- Task list -->
                 <div id="task-list" class="mb-4">
                     <h4 class="font-semibold text-pink-600 mb-2">Tasks</h4>
                 </div>
                 <button id="add-task-btn" class="mb-4 px-4 py-2 bg-pink-100 text-pink-600 rounded-xl hover:bg-pink-200 transition">+ Thêm Task</button>

                 <!-- Nút lưu / hủy -->
                 <div class="flex justify-end gap-4 pb-4">
                     <button id="cancel-btn" class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400 transition focus:outline-none">Hủy</button>
                     <button id="save-btn" class="px-4 py-2 rounded-full bg-pink-600 text-white hover:bg-pink-700 transition focus:outline-none">Lưu</button>
                 </div>
             </div>
         </div>

         <!-- Task template (ẩn) -->
         <div id="task-template" class="hidden">
             <div class="task-item flex gap-2 items-center mb-2 p-2 border border-gray-200 rounded-xl">
                 <input type="text" placeholder="Tên task" class="flex-1 px-2 py-1 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-200">
                 <input type="number" placeholder="Seq" class="w-16 px-2 py-1 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-200">
                 <button class="remove-task-btn flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-full hover:bg-red-200 hover:text-red-700 transition focus:outline-none">
                     <i class="fas fa-times"></i>
                 </button>
             </div>
         </div>

         <div id="challenge-detail-modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 overflow-auto modal-show">
             <div class="bg-white w-full max-w-lg h-full rounded-3xl flex flex-col max-h-[80vh]">
                 <div class="p-6 flex-1 overflow-auto">
                     <h3 id="detail-title" class="text-2xl font-bold text-pink-600 mb-4 text-center"></h3>
                     <p id="detail-desc" class="text-gray-700 mb-4 text-center"></p>

                     <div id="detail-task-list" class="space-y-2">
                         <!-- Tasks sẽ append ở đây -->
                     </div>
                 </div>

                 <div class="flex justify-end gap-4 p-4 border-t border-gray-200">
                     <button id="detail-close-btn" class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400 transition focus:outline-none">Hủy</button>
                     <button id="complete-challenge-btn" class="px-4 py-2 rounded-full bg-pink-600 text-white hover:bg-pink-700 transition focus:outline-none hidden">Hoàn thành</button>
                 </div>
             </div>
         </div>
     </section>
 </main>
 <?php include __DIR__ . '/../components/navbar_nearlove.php'; ?>


 <script>
     // chanllenge
     $(function() {
         const COUPLE_ID = <?= json_encode($_SESSION['couple_id'] ?? null) ?>;

         // Load challenge templates
         function loadChallenges() {
             $.getJSON('index.php?action=fetch_challenges', function(challenges) {
                 const $list = $('#challenge-list');
                 $list.empty();
                 challenges.forEach((ch, index) => {
                     $list.append(`
                <div class="challenge-item flex items-start gap-4 p-4 bg-white rounded-xl border border-pink-100 shadow-sm hover:shadow-md transition-all duration-300"
                     data-id="${ch.id}" data-points="${ch.points}">
                    
                    <!-- STT -->
                    <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-pink-100 text-pink-600 font-semibold rounded-full shadow-sm">
                        ${index + 1}
                    </div>

                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">${ch.title}</p>
                        <p class="text-pink-600 font-semibold text-sm text-right">+${ch.points} điểm</p>
                    </div>
                </div>
            `);
                 });
             });
         }

         function loadTotalScore() {
             $.getJSON('index.php?action=total_score', {
                 couple_id: COUPLE_ID
             }, function(res) {
                 if (res.success) {
                     $('#score-value')
                         .text(res.score);
                 } else {
                     console.error('Không thể tải LoveScore:', res.message);
                 }
             }).fail(() => {
                 console.error('Lỗi mạng khi tải tổng điểm.');
             });
         }
         loadTotalScore();

         $('#add-task-btn').on('click', function() {
             const $task = $('#task-template .task-item').clone();
             $('#task-list').append($task);
         });

         // Xóa task
         $(document).on('click', '.remove-task-btn', function() {
             $(this).closest('.task-item').remove();
         });


         $('#cancel-btn').on('click', function() {
             $('#challenge-modal').addClass('hidden');
         });

         // Add challenge modal
         $('#add-challenge-btn').on('click', function() {
             $('#challenge-modal').removeClass('hidden');
         });

         // Hủy modal
         $('#cancel-btn').on('click', function() {
             $('#challenge-modal').addClass('hidden');
         });

         // Lưu thử thách
         $('#save-btn').click(function() {
             const title = $('#new-challenge-name').val().trim();
             const description = $('#new-challenge-desc').val().trim();
             const score = parseInt($('#new-challenge-score').val().trim() || 0);
             const isOffline = parseInt($('#new-challenge-type').val());

             if (!title) {
                 Swal.fire({
                     icon: 'warning',
                     title: 'Thông báo',
                     text: 'Vui lòng nhập tên thử thách',
                 });
                 return;
             }

             // Collect tasks
             const tasks = [];
             $('#task-list .task-item').each(function() {
                 const text = $(this).find('input[type=text]').val().trim();
                 const seq = parseInt($(this).find('input[type=number]').val().trim() || 0);
                 if (text) tasks.push({
                     text,
                     seq
                 });
             });

             $.ajax({
                 url: 'index.php?action=add_challenge_instance',
                 method: 'POST',
                 data: {
                     title,
                     description,
                     score,
                     is_offline: isOffline,
                     tasks: JSON.stringify(tasks)
                 },
                 dataType: 'json',
                 success: function(res) {
                     if (res.success) {
                         Swal.fire({
                             icon: 'success',
                             title: 'Thành công',
                             text: 'Thêm thử thách thành công!',
                             timer: 1500,
                             showConfirmButton: false
                         });
                         $('#challenge-modal').addClass('hidden');
                         $('#task-list .task-item').remove();
                         $('#new-challenge-name, #new-challenge-desc, #new-challenge-score').val('');
                         $('#new-challenge-type').val('1');

                         // Thêm front-end
                         loadChallenges();
                     } else {
                         Swal.fire({
                             icon: 'error',
                             title: 'Lỗi',
                             text: res.message || 'Thêm thử thách thất bại',
                         });
                     }
                 },
                 error: function(err) {
                     console.error(err);
                     Swal.fire({
                         icon: 'error',
                         title: 'Lỗi',
                         text: 'Lỗi server, thử lại sau',
                     });
                 }
             });
         });

         // Init
         loadChallenges();

         // Click vào challenge item để xem chi tiết
         $('#challenge-list').on('click', '.challenge-item', function(e) {
             const challengeId = $(this).data('id');

             $.getJSON('index.php?action=get_challenge_detail', {
                 id: challengeId
             }, function(res) {
                 console.log(res);

                 if (!res.success) return;
                 const data = res.challenge;

                 $('#detail-title').text(data.title);
                 $('#detail-desc').text(data.description || '');
                 const $taskList = $('#detail-task-list').empty();

                 data.tasks.forEach(task => {
                     $taskList.append(`
                <div class="flex items-center gap-3 p-2 border border-gray-200 rounded-xl">
                    <input type="checkbox" class="task-checkbox" data-task-id="${task.id}" ${task.completed ? 'checked' : ''} />
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">${task.text}</p>
                    </div>
                </div>
            `);
                 });

                 // Check nếu tất cả task đã completed
                 const allCompleted = data.tasks.every(task => task.completed);
                 if (allCompleted) {
                     $('#complete-challenge-btn').removeClass('hidden');
                 } else {
                     $('#complete-challenge-btn').addClass('hidden');
                 }
                 if (data.participant_id) {
                     $('#complete-challenge-btn').data('participant', data.participant_id || null);
                 } else {
                     $('#complete-challenge-btn').data('participant', null);
                 }

                 $('#challenge-detail-modal').removeClass('hidden');
             });
         });

         // Close modal
         $('#detail-close-btn').on('click', function() {
             $('#challenge-detail-modal').addClass('hidden');
         });

         // Check task -> hiện nút hoàn thành nếu tất cả check
         // Khi tick / bỏ tick một task
         $('#detail-task-list').on('change', '.task-checkbox', function() {
             const taskId = $(this).data('task-id');
             const isChecked = $(this).is(':checked');
             console.log({
                 taskId,
                 isChecked
             });

             if (isChecked) {
                 // ✅ Gửi task hoàn thành về backend
                 $.post('index.php?action=complete_task', {
                     task_id: taskId,
                 }, function(res) {
                     console.log(res);

                     if (res.success) {
                         $('#complete-challenge-btn').data('participant', res.participant_id);
                         console.log(`✅ Hoàn thành task ${taskId}`);
                     } else {
                         console.warn('❌ Không thể hoàn thành task:', res.message);
                     }
                 }, 'json');
             } else {
                 // ❌ Có thể thêm API để “bỏ hoàn thành” nếu bạn muốn (optional)
                 console.log(`🚫 Bỏ chọn task ${taskId}`);
             }

             // Kiểm tra nếu tất cả task đã tick hết
             const totalTasks = $('.task-checkbox').length;
             const checkedTasks = $('.task-checkbox:checked').length;

             if (totalTasks > 0 && totalTasks === checkedTasks) {
                 $('#complete-challenge-btn').removeClass('hidden');
             } else {
                 $('#complete-challenge-btn').addClass('hidden');
             }
         });


         // history
         let historyPage = 1;
         const pageSize = 10;
         let loadingHistory = false;
         let hasMoreHistory = true;

         function loadChallengeHistory(reset = false) {
             if (loadingHistory || !hasMoreHistory) return;

             loadingHistory = true;

             const $history = $('#challenge-history');

             if (reset) {
                 $history.empty();
                 historyPage = 1;
                 hasMoreHistory = true;
             }

             $.getJSON('index.php?action=challenge_history', {
                 couple_id: COUPLE_ID,
                 page: historyPage,
                 page_size: pageSize
             }, function(res) {
                 if (!res.success || !res.data || res.data.length === 0) {
                     if (historyPage === 1) {
                         $history.append('<p class="text-gray-400 text-center">Chưa có dữ liệu</p>');
                     }
                     hasMoreHistory = false;
                     loadingHistory = false;
                     return;
                 }

                 res.data.forEach((item, index) => {
                     const completedAt = item.completed_at ? new Date(item.completed_at).toLocaleDateString() : '-';
                     const cardHTML = `
                <div class="history-item cursor-pointer flex items-center justify-between py-2 px-3 rounded-xl hover:bg-pink-50" data-id="${item.challenge_id}">
                    <div class="w-6 flex items-center justify-center font-semibold text-pink-600 mr-2">
                        ${(historyPage-1)*pageSize + index + 1}.
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">${item.challenge_title}</p>
                        <p class="text-gray-500 text-sm">Ngày hoàn thành: ${completedAt}</p>
                    </div>
                    <div class="text-pink-600 font-semibold text-sm ml-4">
                        +${item.score} điểm
                    </div>
                </div>
                <hr class="border-t border-gray-200 my-1">
            `;
                     $history.append(cardHTML);
                 });

                 // Nếu số item trả về < pageSize => hết dữ liệu
                 if (res.data.length < pageSize) hasMoreHistory = false;

                 historyPage++;
                 loadingHistory = false;
             });
         }

         // Scroll event để load thêm khi gần cuối
         $('#challenge-history').on('scroll', function() {
             const $this = $(this);
             if ($this.scrollTop() + $this.innerHeight() >= this.scrollHeight - 50) {
                 loadChallengeHistory();
             }
         });

         // Ban đầu load page 1
         loadChallengeHistory(true);



         // ✅ Khi bấm nút "Hoàn thành thử thách"
         $('#complete-challenge-btn').on('click', function() {
             const participantId = $(this).data('participant');
             Swal.fire({
                 title: 'Hoàn thành thử thách!',
                 text: 'Cả hai bạn đã cùng nhau vượt qua thử thách này ❤️',
                 icon: 'success',
                 confirmButtonText: 'Tuyệt vời!',
             }).then(() => {
                 // Gọi API đánh dấu thử thách hoàn thành (optional)
                 $.post('index.php?action=complete_challenge', {
                     participant_id: participantId
                 }, function(res) {
                     window.location.reload();
                 }, 'json');

                 $('#challenge-detail-modal').addClass('hidden');
             });
         });


         // Click vào từng lịch sử để xem chi tiết
         $(document).on('click', '#challenge-history .history-item', function() {
             console.log('heheheh');

             const id = $(this).data('id');

             console.log(id);


             $.getJSON('index.php?action=get_challenge_detail', {
                 id: id
             }, function(res) {
                 console.log('res: ', res);

                 if (!res.success) return;

                 const data = res.challenge;
                 $('#history-detail-title').text(data.title);
                 $('#history-detail-desc').text(data.description || '');
                 const $taskList = $('#history-detail-task-list').empty();

                 data.tasks.forEach(task => {
                     $taskList.append(`
                <div class="flex items-center gap-3 p-2 border border-gray-200 rounded-xl">
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">${task.text}</p>
                    </div>
                </div>
            `);
                 });

                 $('#challenge-history-detail-modal').removeClass('hidden');
             });
         });

         // Đóng modal
         $('#history-detail-close-btn').on('click', function() {
             $('#challenge-history-detail-modal').addClass('hidden');
         });

     });
 </script>