@include('layouts.header')

<section id="purchase-history" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Lịch sử mua hàng</h1>
            </div>
        </div>

        @if(session('thongbao'))
            <div class="alert alert-success">{{ session('thongbao') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày mua</th>
                                    <th>Sản phẩm</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="fw-bold">#DH{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->ngaytao)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php
                                                $productNames = $order->orderItems->map(function ($item) {
                                                    return $item->product->ten . ' (' . $item->soluong . ')';
                                                })->implode(', ');
                                            @endphp
                                            {{ \Illuminate\Support\Str::limit($productNames, 40) }}
                                        </td>
                                        <td class="fw-bold text-danger">{{ number_format($order->tongtien, 0, ',', '.') }}₫</td>
                                        <td>
                                            @if($order->trangthaidon == 0)
                                                <span class="badge bg-secondary">Chờ xử lý</span>
                                            @elseif($order->trangthaidon == 1)
                                                <span class="badge bg-primary">Đang giao</span>
                                            @elseif($order->trangthaidon == 2)
                                                <span class="badge bg-success">Đã giao</span>
                                            @else
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Xem</a>

                                                @if($order->trangthaidon == 0)
                                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">Hủy</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Bạn chưa có đơn hàng nào?</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">Mua sắm ngay</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')