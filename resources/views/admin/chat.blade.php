@extends('admin.includes.master')
@section('title', 'Quản lý Chat')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tin nhắn khách hàng</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-users me-2"></i> Khách hàng</h6>
                    </div>
                    <div class="p-2 bg-light border-bottom">
                        <input type="text" id="search-user" class="form-control form-control-sm rounded-pill"
                            placeholder="Tìm kiếm tên khách...">
                    </div>

                    <div class="card-body p-0 custom-scrollbar" style="height: 500px; overflow-y: auto;">
                        <div class="list-group list-group-flush" id="user-list">
                            @foreach($users as $user)
                                <button onclick="loadUserChat({{ $user->id }}, '{{ $user->hoten }}', this)"
                                    class="list-group-item list-group-item-action py-3 border-bottom user-btn"
                                    data-name="{{ strtolower($user->hoten) }}">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-0 font-weight-bold user-name">{{ $user->hoten }}</h6>
                                        <span class="badge badge-success badge-counter d-none"
                                            id="badge-{{ $user->id }}">Mới</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="chat-box" class="card shadow mb-4 d-none" style="height: 606px;">
                    <div class="card-header py-3 bg-info text-white shadow-sm z-index-1">
                        <h6 id="chat-title" class="m-0 font-weight-bold"><i class="fas fa-comment-dots me-2"></i> Đang chat
                        </h6>
                    </div>

                    <div id="admin-chat-messages" class="card-body bg-light d-flex flex-column custom-scrollbar"
                        style="overflow-y: auto; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
                    </div>

                    <div class="card-footer bg-white border-top-0 shadow-sm">
                        <form id="admin-chat-form" class="d-flex" onsubmit="sendAdminMessage(event)">
                            <input type="text" id="admin-chat-input" class="form-control me-2 rounded-pill px-3"
                                placeholder="Viết câu trả lời..." required autocomplete="off">
                            <button type="submit" class="btn btn-info text-white rounded-pill px-4"><i
                                    class="fas fa-paper-plane me-1"></i> Gửi</button>
                        </form>
                    </div>
                </div>

                <div id="chat-placeholder" class="card shadow mb-4 d-flex align-items-center justify-content-center"
                    style="height: 606px;">
                    <div class="text-center text-muted">
                        <div class="bg-gray-200 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="fas fa-comment-slash fa-3x text-gray-400"></i>
                        </div>
                        <h5 class="font-weight-bold text-gray-500">Tin nhắn KAIRA</h5>
                        <p>Chọn một khách hàng bên trái để bắt đầu hỗ trợ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* CSS cho bong bóng chat */
        .msg-bubble {
            max-width: 75%;
            border-radius: 20px;
            padding: 12px 18px;
            margin-bottom: 12px;
            word-wrap: break-word;
            font-size: 0.95rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .msg-mine {
            background-color: #36b9cc;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .msg-theirs {
            background-color: #ffffff;
            color: #3a3b45;
            margin-right: auto;
            border-bottom-left-radius: 4px;
            border: 1px solid #e3e6f0;
        }

        /* Highlight khách hàng đang được chọn */
        .user-btn.active {
            background-color: #f8f9fc;
            border-left: 4px solid #36b9cc !important;
        }

        .user-btn.active .user-name {
            color: #36b9cc;
        }

        /* Làm đẹp thanh cuộn */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <script>
        let currentChatUserId = null;
        const adminId = {{ Auth::id() }};
        const messagesBox = document.getElementById('admin-chat-messages');

        // CHỨC NĂNG TÌM KIẾM KHÁCH HÀNG
        document.getElementById('search-user').addEventListener('input', function (e) {
            const text = e.target.value.toLowerCase();
            document.querySelectorAll('.user-btn').forEach(btn => {
                const name = btn.getAttribute('data-name');
                btn.style.display = name.includes(text) ? 'block' : 'none';
            });
        });

        function loadUserChat(userId, userName, element) {
            currentChatUserId = userId;

            // Xóa badget "Mới" nếu có
            document.getElementById(`badge-${userId}`).classList.add('d-none');
            // Gọi API đánh dấu tin nhắn đã đọc
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/chat/mark-read', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ nguoiguiID: userId })
            });

            // 1. SỬA LỖI PLACEHOLDER (Gỡ bỏ d-flex trước khi ẩn)
            const placeholder = document.getElementById('chat-placeholder');
            placeholder.classList.remove('d-flex');
            placeholder.classList.add('d-none');

            document.getElementById('chat-box').classList.remove('d-none');
            document.getElementById('chat-title').innerHTML = `<i class="fas fa-user-circle me-2"></i> Khách hàng: <b>${userName}</b>`;

            // 2. HIGHLIGHT KHÁCH HÀNG ĐANG CHỌN
            document.querySelectorAll('.user-btn').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');

            fetch(`/chat/messages/${userId}`)
                .then(res => res.json())
                .then(messages => {
                    messagesBox.innerHTML = '';
                    messages.forEach(msg => appendAdminMessage(msg));
                    scrollToBottom();
                });
        }

        function sendAdminMessage(e) {
            e.preventDefault();
            if (!currentChatUserId) return;

            const input = document.getElementById('admin-chat-input');
            const noidung = input.value.trim();
            if (!noidung) return;

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            input.value = '';

            appendAdminMessage({ nguoiguiID: adminId, noidung: noidung });
            scrollToBottom();

            fetch('/chat/send', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ nguoinhanID: currentChatUserId, noidung: noidung })
            });
        }

        function appendAdminMessage(msg) {
            // Đã fix lỗi ép kiểu Number
            const isMine = Number(msg.nguoiguiID) === Number(adminId);
            const div = document.createElement('div');
            div.className = `msg-bubble ${isMine ? 'msg-mine' : 'msg-theirs'}`;
            div.innerText = msg.noidung;
            messagesBox.appendChild(div);
        }

        function scrollToBottom() {
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                if (window.Echo) {
                    window.Echo.private(`chat.${adminId}`).listen('MessageSent', (e) => {
                        if (Number(e.message.nguoiguiID) === Number(currentChatUserId)) {
                            appendAdminMessage(e.message);
                            scrollToBottom();
                        } else {
                            // Nếu đang chat với người khác mà có người mới nhắn tới -> Hiện chữ "Mới" ở danh sách
                            const badge = document.getElementById(`badge-${e.message.nguoiguiID}`);
                            if (badge) badge.classList.remove('d-none');
                        }
                    });
                }
            }, 1000);
        });
    </script>
@endsection