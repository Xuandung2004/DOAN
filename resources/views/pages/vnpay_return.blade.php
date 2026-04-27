@include('layouts.header')

<section class="py-5 bg-light" style="min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-lg border-0 rounded-4 p-5">

                    @if($status == 'success')
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                        </div>
                        <h2 class="fw-bold text-success mb-3">Thanh toán thành công!</h2>
                        <p class="text-muted fs-5 mb-4">{{ $message }}</p>

                        <div class="bg-light p-3 rounded-3 mb-4 text-start">
                            <p class="mb-1"><strong>Mã giao dịch VNPay:</strong> {{ request()->vnp_TransactionNo }}</p>
                            <p class="mb-1"><strong>Mã đơn hàng:</strong> #{{ request()->vnp_TxnRef }}</p>
                            <p class="mb-0"><strong>Số tiền:</strong>
                                {{ number_format(request()->vnp_Amount / 100, 0, ',', '.') }} đ</p>
                        </div>
                    @else
                        <div class="mb-4">
                            <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                        </div>
                        <h2 class="fw-bold text-danger mb-3">Thanh toán thất bại!</h2>
                        <p class="text-muted fs-5 mb-4">{{ $message }}</p>
                    @endif

                    <div class="d-grid gap-2 col-8 mx-auto mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-home me-2"></i> Trở về trang chủ
                        </a>
                        <a href="{{ route('cart') }}" class="btn btn-outline-secondary rounded-pill fw-bold">
                            Về giỏ hàng
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')