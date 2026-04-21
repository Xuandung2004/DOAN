@include('layouts.header')

<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Liên hệ với chúng tôi</h1>
            </div>
        </div>

        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-6 mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="mb-4">Thông tin liên hệ</h3>

                <div class="contact-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1">Địa chỉ</h5>
                            <p class="text-muted">123 Đường Ngô Gia Tự, Quận Đống Đa, Hà Nội</p>
                        </div>
                    </div>
                </div>

                <div class="contact-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1">Điện thoại</h5>
                            <p class="text-muted">0901 234 567</p>
                        </div>
                    </div>
                </div>

                <div class="contact-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1">Email</h5>
                            <p class="text-muted"><a href="mailto:info@kaira.vn"
                                    class="text-decoration-none text-dark">info@kaira.vn</a></p>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1">Giờ làm việc</h5>
                            <p class="text-muted">
                                Thứ Hai - Thứ Sáu: 9:00 - 18:00<br>
                                Thứ Bảy: 9:00 - 17:00<br>
                                Chủ Nhật: Đóng cửa
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h3 class="mb-4">Gửi tin nhắn cho chúng tôi</h3>

                <form class="contact-form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Gửi tin nhắn</button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
            <div class="col-12">
                <h3 class="mb-4">Vị trí của chúng tôi trên bản đồ</h3>
                <div class="map-container rounded-3 overflow-hidden"
                    style="height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center">
                        <p class="text-muted">Google Map sẽ được nhúng tại đây</p>
                        <p class="text-muted small">123 Đường Ngô Gia Tự, Quận Đống Đa, Hà Nội</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-icon {
        color: #667eea;
        flex-shrink: 0;
    }

    .contact-form input,
    .contact-form textarea {
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

@include('layouts.footer')