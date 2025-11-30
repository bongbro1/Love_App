<main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
    <!-- Chat Section -->
    <section id="chat" class="page-section gradient-border fade-in transition-all duration-700 ease-out fade-section">
        <div class="card-hover transition duration-300 p-4 md:p-6">
            <h2 class="text-3xl md:text-4xl font-semibold text-pink-600 mb-4 md:mb-6 text-center">Hộp Thư Tình</h2>

            <div class="flex flex-col gap-4">
                <!-- Message Box -->
                <div id="messageBox" class="bg-pink-50/80 p-4 md:p-6 rounded-xl h-80 md:h-96 overflow-y-auto backdrop-blur-sm flex flex-col">
                    <!-- Tin nhắn sẽ được append bằng JS -->
                    <div class="text-center text-gray-400 text-sm mt-auto">Chưa có tin nhắn nào 💌</div>
                </div>

                <!-- Input Box -->
                <div class="flex flex-col gap-3">
                    <textarea id="messageInput" class="w-full h-28 md:h-36 p-3 md:p-4 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/80 backdrop-blur-sm text-sm md:text-base" placeholder="Viết lời nhắn yêu thương..."></textarea>
                    <input type="file" id="imageInput" accept="image/*" multiple style="display:none">
                    <div id="selectedFilesInfo" class="text-sm text-gray-500"></div>
                    <div class="flex gap-2 mt-2 justify-between">
                        <button id="sendBtn" class="flex-1 bg-gradient-to-r from-pink-500 to-purple-500 text-white p-2 rounded-full sparkle-button ripple transition duration-300">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <button id="selectImages" class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-2 rounded-full sparkle-button ripple transition duration-300">
                            <i class="fas fa-image"></i>
                        </button>
                        <button id="audioBtn" class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-2 rounded-full sparkle-button ripple transition duration-300">
                            <i class="fas fa-microphone"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<div id="msgMenu"
    class="hidden fixed bg-white rounded-xl shadow-xl border border-gray-200 w-44 z-[9999] 
            transform origin-top-left scale-95 opacity-0 transition-all duration-150 modal-show">
    <button data-action="copy"
        class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm flex items-center gap-2 leading-none">
        <span class="align-middle">📋</span> <span class="align-middle">Sao chép</span>
    </button>

    <button data-action="reply"
        class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm flex items-center gap-2 leading-none">
        <span class="align-middle">💬</span> <span class="align-middle">Trả lời</span>
    </button>

    <button data-action="forward"
        class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm flex items-center gap-2 leading-none">
        <span class="align-middle">📤</span> <span class="align-middle">Chuyển tiếp</span>
    </button>

    <button data-action="delete"
        class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-500 text-sm flex items-center gap-2 leading-none">
        <span class="align-middle" style="width: 20px;
    text-align: center;">🗑</span> <span class="align-middle">Xoá</span>
    </button>

</div>


<?php include __DIR__ . '/../components/navbar_longlove.php'; ?>


<script>
    // chat
    $(function() {
        const box = $('#messageBox');
        const input = $('#messageInput');
        const sendBtn = $('#sendBtn');

        ws = new WebSocket(WS_URL);


        ws.onopen = () => console.log("✅ WebSocket connected");
        ws.onmessage = (e) => {
            const msg = JSON.parse(e.data);

            // Nếu sender là chính mình, **bỏ qua** để tránh double
            if (msg.sender_id == userId) return;

            const self = false;
            addMessage(msg.sender_name, msg.body, self);
        };

        function sendMessage() {
            const text = input.val().trim();
            const files = $('#imageInput')[0].files;

            // Nếu không có text và không có ảnh → không gửi
            if (!text && files.length === 0) return;

            const formData = new FormData();
            formData.append('text', text);

            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            $.ajax({
                url: 'index.php?action=chat_send', // vẫn dùng chat_send
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (!res.success) return console.error('Gửi thất bại', res.message);

                    // Dùng luôn body trả về từ server
                    addMessage('Bạn', res.body, true);

                    // Gửi WebSocket cho người khác
                    ws.send(JSON.stringify({
                        sender_id: userId,
                        body: res.body
                    }));

                    // Reset input và file
                    input.val('');
                    $('#imageInput').val('');
                    $('#selectedFilesInfo').text('');
                },
                error: function(err) {
                    console.error('Gửi tin nhắn thất bại', err);
                }
            });
        }


        sendBtn.on('click', sendMessage);
        input.on('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function addMessage(user, body, self = false, id = null) {
            const messageBox = $('#messageBox')[0];
            if (!messageBox) {
                return;
            }

            let textContent = '';
            let images = [];
            let voice = '';
            let messageId = id;

            try {
                const obj = typeof body === 'string' ? JSON.parse(body) : body;

                if (obj.text && obj.text.trim()) textContent = obj.text;
                if (obj.images && obj.images.length) images = obj.images;
                if (obj.voice && obj.voice.trim()) voice = obj.voice;
                if (obj.id) messageId = obj.id;
            } catch (e) {
                if (body && body.trim()) textContent = body;
            }

            // Tạo div text
            if (textContent) {
                const div = $('<div>')
                    .addClass(self ?
                        'bg-pink-100 text-gray-700 p-3 rounded-xl my-1 ml-auto max-w-[75%] break-words' :
                        'bg-white text-gray-700 p-3 rounded-xl my-1 mr-auto max-w-[75%] break-words'
                    )
                    .html(self ? textContent : `<span title="${user}">${textContent}</span>`);
                $('#messageBox').append(div);
                enableMessageMenu(div, {
                    content: textContent,
                    self,
                    message_id: messageId
                });
            }

            // Thêm ảnh
            images.forEach((url, index) => addMessageImage(url, self, images, index, messageId));

            // Thêm voice
            if (voice) addMessageVoice(voice, self, messageId);

            // Scroll xuống cuối DOM sau khi render xong
            requestAnimationFrame(() => {
                messageBox.scrollTop = messageBox.scrollHeight;
            });
        }



        function addMessageVoice(url, self = false, messageId = null) {

            const wrapper = $('<div>')
                .addClass(self ?
                    'my-1 ml-auto max-w-[85%] flex justify-end' :
                    'my-1 mr-auto max-w-[85%] flex justify-start'
                );

            const box = $('<div class="relative inline-block">');

            const audio = $(`<audio controls class="rounded-lg shadow-md chat-voice-audio" src="${BASE_URL}${url}"></audio>`);

            const overlay = $('<div class="voice-overlay"></div>');

            box.append(audio);
            box.append(overlay);
            wrapper.append(box);

            $('#messageBox').append(wrapper);

            enableMessageMenu(wrapper, {
                content: '[Voice message]',
                self,
                message_id: messageId
            });

            requestAnimationFrame(() => {
                const messageBox = $('#messageBox')[0];
                if (messageBox) messageBox.scrollTop = messageBox.scrollHeight;
            });
        }


        function addMessageImage(url, self = false, images = [], index = 0, messageId = null) {

            // --- tạo wrapper chung cho toàn tin nhắn (1 ảnh hoặc nhiều ảnh) ---
            const wrapper = $('<div>')
                .addClass(self ?
                    'my-1 ml-auto max-w-[60%] relative' :
                    'my-1 mr-auto max-w-[60%] relative'
                )
                .addClass('message-wrapper');

            // --- overlay để bắt long-press ---
            const overlay = $('<div class="image-overlay"></div>');
            wrapper.append(overlay);

            // --- nếu nhiều ảnh: tạo container grid ---
            if (images && images.length > 1) {

                const container = $('<div>')
                    .addClass('grid grid-cols-2 gap-2 grid-container')
                    .appendTo(wrapper);

                // tạo từng ảnh
                images.forEach((imgUrl, i) => {
                    const img = $(`<img src="${BASE_URL}${imgUrl}" class="rounded-lg shadow-md cursor-pointer chat-image">`);
                    img.data('images', images);
                    img.data('index', i);

                    img.on('click', function() {
                        openImageModal(images, i);
                    });

                    container.append(img);
                });

            } else {
                // --- ảnh đơn ---
                const img = $(`<img src="${BASE_URL}${url}" class="rounded-lg shadow-md cursor-pointer chat-image">`);
                img.data('images', [url]);
                img.data('index', 0);

                img.on('click', function() {
                    openImageModal([url], 0);
                });

                wrapper.append(img);
            }

            // --- gắn wrapper vào messageBox ---
            $('#messageBox').append(wrapper);

            // --- gán menu vào wrapper ---
            enableMessageMenu(wrapper, {
                content: '[Image message]',
                self,
                message_id: messageId
            });

            // --- scroll xuống cuối ---
            requestAnimationFrame(() => {
                const box = $('#messageBox')[0];
                if (box) box.scrollTop = box.scrollHeight;
            });
        }



        function addTimeRow(time) {
            const div = $('<div>')
                .addClass('text-xs text-gray-400 my-2 text-center')
                .text(time);

            const messageBox = $('#messageBox')[0]; // DOM element
            if (!messageBox) {
                return;
            }

            $('#messageBox').append(div);
            messageBox.scrollTop = messageBox.scrollHeight; // scroll xuống cuối
        }

        function loadMessages() {
            $.ajax({
                url: 'index.php?action=chat_load',
                type: 'GET',
                dataType: 'json',
                success: function(messages) {
                    let lastTime = null;

                    messages.forEach(msg => {
                        const msgTime = new Date(msg.created_at);

                        // Nếu cách tin nhắn trước > 1 giờ, thêm "time row"
                        if (!lastTime || (msgTime - lastTime) > 60 * 60 * 1000) {
                            const timeStr = msgTime.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            addTimeRow(timeStr); // thêm 1 row căn giữa
                        }

                        const self = msg.sender_id == userId;
                        addMessage(msg.sender_name, msg.body, self, msg.id);

                        lastTime = msgTime;
                    });

                    requestAnimationFrame(() => {
                        const box = $('#messageBox')[0];
                        if (!box) return;
                        box.scrollTop = box.scrollHeight;
                    });
                },
                error: function(err) {
                    console.error('Load messages failed:', err);
                }
            });

        }


        loadMessages();


        // audio
        let mediaRecorder;
        let audioChunks = [];

        $('#audioBtn').on('click', async () => {
            const micBtn = $('#audioBtn');
            // Nếu chưa có quyền, yêu cầu micro
            if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                mediaRecorder = new MediaRecorder(stream);

                audioChunks = [];

                mediaRecorder.ondataavailable = e => audioChunks.push(e.data);

                mediaRecorder.onstop = () => {
                    const blob = new Blob(audioChunks, {
                        type: 'audio/webm'
                    });
                    const file = new File([blob], 'voice.webm', {
                        type: 'audio/webm'
                    });

                    const formData = new FormData();
                    formData.append('voice', file);

                    $.ajax({
                        url: 'index.php?action=chat_send',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(res) {
                            if (!res.success) return console.error('Gửi thất bại', res.message);

                            // Nếu server trả về string JSON, parse ra object
                            const bodyObj = typeof res.body === 'string' ? JSON.parse(res.body) : res.body;

                            // Hiển thị ngay ở chat box
                            addMessage('Bạn', bodyObj, true, null);

                            // Gửi WebSocket cho đối phương
                            ws.send(JSON.stringify({
                                sender_id: userId,
                                sender_name: 'Bạn',
                                body: bodyObj
                            }));

                            $('#messageInput').val('');
                        },
                        error: function(err) {
                            console.error(err);
                        }
                    });

                    micBtn.removeClass('recording');
                };

                mediaRecorder.start();
                micBtn.addClass('recording');
            } else if (mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                micBtn.removeClass('recording');
            }
        });

        $('#selectImages').on('click', function() {
            $('#imageInput').click();
        });
        $('#imageInput').on('change', function() {
            const files = this.files;
            if (!files.length) return; // không có file thì bỏ qua

            // Gọi luôn sendMessage để gửi file
            sendMessage();

            // Reset input nếu muốn chọn lại lần nữa
            $(this).val('');
        });
    });


    let pressTimer = null;
    let longPressActivated = false;
    let pointerMoved = false;
    let menuVisible = false;
    let suppressClickAfterLongPress = false;

    function enableMessageMenu(wrapper, data) {
        const el = wrapper[0];
        let pressTimer = null;
        let longPressActivated = false;
        let pointerMoved = false;

        el.addEventListener("pointerdown", (e) => {
            longPressActivated = false;
            pointerMoved = false;

            const moveHandler = () => {
                pointerMoved = true;
                clearTimeout(pressTimer);
            };

            el.addEventListener("pointermove", moveHandler, {
                passive: false
            });

            pressTimer = setTimeout(() => {
                if (!pointerMoved) {
                    longPressActivated = true;
                    suppressClickAfterLongPress = true;
                    showMsgMenu(wrapper, e, data);
                }
            }, 450);
        });

        el.addEventListener("pointerup", (e) => {
            clearTimeout(pressTimer);

            // Chỉ click nhanh mới mở modal
            if (!longPressActivated) {
                const img = wrapper.querySelector('img');
                if (img && img.dataset.images) {
                    const images = JSON.parse(img.dataset.images);
                    const index = parseInt(img.dataset.index || 0);
                    openImageModal(images, index);
                }
            }
        });

        el.addEventListener("pointercancel", () => {
            clearTimeout(pressTimer);
        });
    }

    function showMsgMenu(wrapper, event, data) {
        const menu = $("#msgMenu");
        currentMessage = {
            wrapper,
            data
        };

        const rect = wrapper[0].getBoundingClientRect();
        const menuWidth = menu.outerWidth();
        const menuHeight = menu.outerHeight();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        // Tính top
        let top = rect.top - menuHeight - 8; // menu phía trên tin nhắn, cách 8px
        if (top < 8) top = rect.bottom + 8; // nếu không đủ chỗ trên, hiển thị bên dưới

        // Tính left căn giữa
        let left = rect.left + rect.width / 2 - menuWidth / 2;
        if (left < 8) left = 8; // không vượt lề trái
        if (left + menuWidth > viewportWidth - 8) left = viewportWidth - menuWidth - 8; // không vượt lề phải

        menu.css({
            top: `${top + window.scrollY}px`, // cộng scrollY để menu đúng vị trí khi scroll
            left: `${left + window.scrollX}px`
        });

        // Hiển thị menu
        menu.removeClass("hidden opacity-0 scale-95")
            .addClass("opacity-100 scale-100");

        // Hiện/ẩn nút xóa
        if (!data.self) {
            menu.find('[data-action="delete"]').addClass("hidden");
        } else {
            menu.find('[data-action="delete"]').removeClass("hidden");
        }

        menuVisible = true;
    }


    $("#msgMenu button").on("click", function() {
        const action = $(this).data("action");
        if (!currentMessage) return;

        const {
            wrapper,
            data
        } = currentMessage;

        switch (action) {
            case "copy":
                navigator.clipboard.writeText(data.content || "");
                break;
            case "delete":
                console.log(data.message_id);

                if (!data.message_id) {
                    console.warn("Không có message_id để xóa!");
                    break;
                }

                $.ajax({
                    url: "index.php?action=delete_message",
                    method: "POST",
                    data: {
                        message_id: data.message_id
                    },
                    success: function(res) {
                        console.log(res);

                        if (res.success) {
                            wrapper.remove();
                        } else {
                            alert(res.error || "Xoá tin nhắn thất bại");
                        }
                    },
                    error: function() {
                        alert("Lỗi kết nối server!");
                    }
                });
                break;
        }

        hideMsgMenu();
    });

    $(document).on("click", function(e) {
        if (!menuVisible) return;

        if (suppressClickAfterLongPress) {
            suppressClickAfterLongPress = false;
            return;
        }

        const menu = $("#msgMenu");
        if (!$(e.target).closest("#msgMenu").length && !$(e.target).closest(currentMessage.wrapper).length) {
            hideMsgMenu();
            menuVisible = false;
        }
    });


    function hideMsgMenu() {
        const menu = $("#msgMenu");

        menu.removeClass("opacity-100 scale-100")
            .addClass("opacity-0 scale-95");

        setTimeout(() => menu.addClass("hidden"), 150);
    }
</script>