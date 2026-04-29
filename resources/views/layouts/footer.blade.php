<footer id="footer" class="mt-5">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between py-5">
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-001">
                    <div class="footer-intro mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/main-logo.png') }}" alt="logo">
                        </a>
                    </div>
                    <p>Kaira tự hào mang đến những sản phẩm thời trang trẻ em an toàn, chất lượng và phong cách nhất.
                        Luôn đồng hành cùng bé yêu trên mỗi chặng đường phát triển.</p>
                    <div class="social-links">
                        <ul class="list-unstyled d-flex flex-wrap gap-3">
                            <li>
                                <a href="#" class="text-secondary">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#facebook"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#twitter"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#youtube"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#pinterest"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#instagram"></use>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-002">
                    <h5 class="widget-title text-uppercase mb-4">Liên Kết Nhanh</h5>
                    <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                        <li class="menu-item">
                            <a href="{{ route('home') }}" class="item-anchor">Trang Chủ</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('products') }}" class="item-anchor">Sản phẩm</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Liên hệ</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('promotions') }}" class="item-anchor">Khuyến Mãi</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('cart') }}" class="item-anchor">Giỏ Hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-003">
                    <h5 class="widget-title text-uppercase mb-4">Chăm Sóc Khách Hàng</h5>
                    <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                        <li class="menu-item">
                            @auth
                                <a href="{{ route('orders.history') }}" class="item-anchor">Tra Cứu Đơn Hàng</a>
                            @else
                                <a href="{{ route('login') }}" class="item-anchor">Tra Cứu Đơn Hàng</a>
                            @endauth
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Chính Sách Đổi Trả</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Chính Sách Giao Hàng</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Liên Hệ Hỗ Trợ</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Hệ Thống Cửa Hàng</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('contact') }}" class="item-anchor">Câu Hỏi Thường Gặp</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-004 border-animation-left">
                    <h5 class="widget-title text-uppercase mb-4">Liên Hệ</h5>
                    <p>Bạn có câu hỏi hoặc cần tư vấn chọn size cho bé? <br><a href="mailto:cskh@bluevn.com"
                            class="item-anchor">cskh@bluevn.com</a></p>
                    <p>Hotline hỗ trợ trực tuyến 24/7. <br><a href="tel:0912345678" class="item-anchor">0912 345 678</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="border-top py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex flex-wrap">
                    <div class="shipping">
                        <span>Đơn vị vận chuyển:</span>
                        <img src="{{ asset('images/arct-icon.png') }}" alt="icon">
                        <img src="{{ asset('images/dhl-logo.png') }}" alt="icon">
                    </div>
                    <div class="payment-option">
                        <span>Phương thức thanh toán:</span>
                        <img src="{{ asset('images/visa-card.png') }}" alt="card">
                        <img src="{{ asset('images/paypal-card.png') }}" alt="card">
                        <img src="{{ asset('images/master-card.png') }}" alt="card">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <p>© Bản quyền 2026 thuộc về hệ thống thời trang trẻ em KAIRA </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/SmoothScroll.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="{{ asset('js/script.min.js') }}"></script>
@auth
    @if(Auth::user()->vaitro != 1)
        <div id="chat-widget" class="position-fixed" style="bottom: 30px; right: 30px; z-index: 1050;">

            <div id="chat-window" class="card shadow-lg d-none chat-window-anim"
                style="width: 360px; height: 500px; position: absolute; bottom: 80px; right: 0; border: none; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column;">

                <div class="card-header border-0 d-flex justify-content-between align-items-center py-3"
                    style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 20px 20px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="fw-bold text-primary fs-5">K</span>
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"
                                style="transform: translate(25%, 25%);"></span>
                        </div>
                        <div class="d-flex flex-column text-white">
                            <h6 class="mb-0 fw-bold" style="font-size: 1.05rem;">KAIRA Hỗ trợ</h6>
                            <small class="text-white-50" style="font-size: 0.75rem;">Luôn sẵn sàng trả lời</small>
                        </div>
                    </div>
                </div>

                <div id="chat-messages" class="card-body d-flex flex-column p-3 custom-chat-scroll"
                    style="flex: 1; overflow-y: auto; background-color: #f8f9fa;">
                    <div class="text-center text-muted small mt-auto mb-auto">
                        <svg width="40" height="40" fill="#f6c23e" viewBox="0 0 16 16" class="mb-2">
                            <path
                                d="M2.97 1.35A1 1 0 0 1 3.73 2.22l.22 1.45 1.45.22a1 1 0 0 1 0 1.98l-1.45.22-.22 1.45a1 1 0 0 1-1.98 0l-.22-1.45-1.45-.22a1 1 0 0 1 0-1.98l1.45-.22.22-1.45a1 1 0 0 1 .87-.87zm9.4 3.01a1 1 0 0 1 .76.87l.14.9.9.14a1 1 0 0 1 0 1.98l-.9.14-.14.9a1 1 0 0 1-1.98 0l-.14-.9-.9-.14a1 1 0 0 1 0-1.98l.9-.14.14-.9a1 1 0 0 1 .87-.87zM6.5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1z" />
                        </svg>
                        <p class="mb-0">KAIRA xin chào! Chúng tôi có thể giúp gì cho bạn?</p>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 p-2"
                    style="border-radius: 0 0 20px 20px; box-shadow: 0 -2px 10px rgba(0,0,0,0.05);">
                    <form id="chat-form" class="d-flex align-items-center m-0 w-100" onsubmit="sendChatMessage(event)">
                        <input type="text" id="chat-input"
                            class="form-control rounded-pill border bg-light px-3 py-2 me-2 shadow-none"
                            placeholder="Nhập tin nhắn..." required autocomplete="off" style="font-size: 0.95rem; flex: 1;">

                        <button type="submit" class="btn-force-blue" style="width: 42px; height: 42px; flex-shrink: 0;">
                            <svg width="18" height="18" fill="white" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 0-.11-.04l-.025-.005a.495.495 0 0 0-.18-.01l-.022.003-.024.004a.5.5 0 0 0-.106.035l-15 7a.5.5 0 0 0 .018.918l5.228 1.96 1.83 5.488a.5.5 0 0 0 .93-.056l7-15a.5.5 0 0 0-.13-.507zM5.535 9.88l-3.8-1.425L13.882 2.21 5.535 9.88zm.974.796 1.11 3.332L9.2 10.428l-2.691.248z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="position-relative">
                <button id="chat-bubble" class="btn-force-blue chat-btn-hover" style="width: 65px; height: 65px;">
                    <svg id="icon-chat" width="28" height="28" fill="white" viewBox="0 0 16 16"
                        style="transition: transform 0.3s ease;">
                        <path
                            d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                    </svg>
                    <svg id="icon-close" class="d-none" width="30" height="30" fill="white" viewBox="0 0 16 16"
                        style="transition: transform 0.3s ease;">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </button>
                <span id="chat-badge"
                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle d-none"></span>
            </div>
        </div>

        <style>
            /* Class Bọc Thép - Ép buộc giao diện không được ghi đè */
            .btn-force-blue {
                background-color: #0d6efd !important;
                border: none !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0 !important;
                box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4) !important;
                cursor: pointer !important;
                outline: none !important;
            }

            .btn-force-blue:hover {
                background-color: #0b5ed7 !important;
            }

            .chat-window-anim {
                animation: slideUpFade 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
                transform-origin: bottom right;
            }

            @keyframes slideUpFade {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .chat-btn-hover:hover {
                transform: scale(1.05);
            }

            .chat-shake {
                animation: shake 0.5s ease-in-out;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-5px) rotate(-5deg);
                }

                75% {
                    transform: translateX(5px) rotate(5deg);
                }
            }

            .msg-bubble {
                max-width: 78%;
                padding: 10px 16px;
                margin-bottom: 8px;
                word-wrap: break-word;
                font-size: 0.95rem;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                line-height: 1.4;
            }

            .msg-mine {
                background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                color: white;
                margin-left: auto;
                border-radius: 18px 18px 0px 18px;
            }

            .msg-theirs {
                background-color: #ffffff;
                color: #333;
                margin-right: auto;
                border-radius: 18px 18px 18px 0px;
                border: 1px solid #eef2f5;
            }

            .custom-chat-scroll::-webkit-scrollbar {
                width: 5px;
            }

            .custom-chat-scroll::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-chat-scroll::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 10px;
            }

            .custom-chat-scroll::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }
        </style>

        <script>
            const adminId = 7;
            const myId = {{ Auth::id() }};
            const chatWindow = document.getElementById('chat-window');
            const chatBubble = document.getElementById('chat-bubble');
            const iconChat = document.getElementById('icon-chat');
            const iconClose = document.getElementById('icon-close');
            const messagesBox = document.getElementById('chat-messages');
            const chatBadge = document.getElementById('chat-badge');

            let isChatOpen = false;
            let isHistoryLoaded = false;
            let unreadCount = 0; // Biến lưu số tin nhắn chưa đọc

            // HÀM HIỂN THỊ SỐ 5+
            function updateBadgeDisplay() {
                if (unreadCount > 0) {
                    chatBadge.classList.remove('d-none');
                    chatBadge.innerText = unreadCount > 5 ? '5+' : unreadCount;
                } else {
                    chatBadge.classList.add('d-none');
                    chatBadge.innerText = '';
                }
            }

            // GỌI API LẤY SỐ TIN CHƯA ĐỌC KHI VỪA VÀO TRANG
            fetch('/chat/unread').then(res => res.json()).then(data => {
                unreadCount = data.count;
                updateBadgeDisplay();
            });

            // GỌI API ĐÁNH DẤU ĐÃ ĐỌC
            function markMessagesAsRead() {
                if (unreadCount > 0) {
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('/chat/mark-read', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({ nguoiguiID: adminId })
                    });
                    unreadCount = 0;
                    updateBadgeDisplay();
                }
            }

            chatBubble.addEventListener('click', () => {
                isChatOpen = !isChatOpen;

                if (isChatOpen) {
                    chatWindow.classList.remove('d-none');
                    iconChat.classList.add('d-none');
                    iconClose.classList.remove('d-none');
                    iconClose.style.transform = 'rotate(90deg)';
                    setTimeout(() => iconClose.style.transform = 'rotate(0deg)', 150);

                    markMessagesAsRead(); // ĐÁNH DẤU ĐÃ ĐỌC KHI MỞ CHAT

                    if (!isHistoryLoaded) loadChatHistory();
                } else {
                    chatWindow.classList.add('d-none');
                    iconClose.classList.add('d-none');
                    iconChat.classList.remove('d-none');
                    iconChat.style.transform = 'rotate(-90deg)';
                    setTimeout(() => iconChat.style.transform = 'rotate(0deg)', 150);
                }
            });

            function loadChatHistory() {
                fetch(`/chat/messages/${adminId}`)
                    .then(res => res.json())
                    .then(messages => {
                        messagesBox.innerHTML = '';
                        if (messages.length === 0) {
                            messagesBox.innerHTML = `<div class="text-center text-muted small mt-auto mb-auto">...</div>`;
                        } else {
                            messages.forEach(msg => appendMessage(msg));
                        }
                        scrollToBottom();
                        isHistoryLoaded = true;
                    });
            }

            function sendChatMessage(e) {
                e.preventDefault();
                const input = document.getElementById('chat-input');
                const noidung = input.value.trim();
                if (!noidung) return;

                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                input.value = '';

                appendMessage({ nguoiguiID: Number(myId), noidung: noidung });
                scrollToBottom();

                fetch('/chat/send', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ nguoinhanID: adminId, noidung: noidung })
                });
            }

            function appendMessage(msg) {
                const isMine = Number(msg.nguoiguiID) === Number(myId);
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
                        window.Echo.private(`chat.${myId}`).listen('MessageSent', (e) => {
                            if (Number(e.message.nguoiguiID) === Number(adminId)) {
                                if (isChatOpen) {
                                    appendMessage(e.message);
                                    scrollToBottom();
                                    markMessagesAsRead(); // ĐANG MỞ CHAT MÀ CÓ TIN THÌ ĐÁNH DẤU ĐỌC LUÔN
                                } else {
                                    // CHAT ĐANG ĐÓNG -> TĂNG SỐ DEM, RUNG BONG BÓNG
                                    unreadCount++;
                                    updateBadgeDisplay();

                                    chatBubble.classList.add('chat-shake');
                                    setTimeout(() => chatBubble.classList.remove('chat-shake'), 500);
                                    if (isHistoryLoaded) {
                                        appendMessage(e.message);
                                        scrollToBottom();
                                    }
                                }
                            }
                        });
                    }
                }, 1000);
            });
        </script>
    @endif
@endauth

</body>

</html>