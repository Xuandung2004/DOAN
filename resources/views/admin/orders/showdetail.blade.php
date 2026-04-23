@extends('admin.includes.master')

@section('title', 'Chi tiết Đơn hàng')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Chi tiết Đơn hàng: <span class="text-primary">#DH{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
        </h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm khách đặt</h6>
                    @if($order->trangthaidon == 0)
                        <span class="badge badge-secondary" style="font-size: 0.9rem;">Chờ xử lý</span>
                    @elseif($order->trangthaidon == 1)
                        <span class="badge badge-primary" style="font-size: 0.9rem;">Đang giao</span>
                    @elseif($order->trangthaidon == 2)
                        <span class="badge badge-success" style="font-size: 0.9rem;">Hoàn tất</span>
                    @else
                        <span class="badge badge-danger" style="font-size: 0.9rem;">Đã hủy</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-right pr-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                @if($item->product->images->isNotEmpty())
                                                    <img src="{{ asset($item->product->images->first()->duongdananh) }}" alt="img"
                                                        class="rounded border mr-3"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light border rounded mr-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <strong>{{ $item->product->ten }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }}đ</td>
                                        <td class="text-center font-weight-bold">{{ $item->soluong }}</td>
                                        <td class="text-right pr-4 font-weight-bold text-danger">
                                            {{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-bottom-primary">
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-2">
                            <label class="font-weight-bold">Cập nhật trạng thái:</label>
                            <select name="trangthaidon" class="form-control">
                                <option value="0" {{ $order->trangthaidon == 0 ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="1" {{ $order->trangthaidon == 1 ? 'selected' : '' }}>Đang giao</option>
                                <option value="2" {{ $order->trangthaidon == 2 ? 'selected' : '' }}>Hoàn tất</option>
                                <option value="3" {{ $order->trangthaidon == 3 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Lưu thay
                            đổi</button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin Khách hàng</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><i class="fas fa-user mr-2 text-gray-500"></i> <strong>Tên:</strong>
                        {{ $order->user->hoten ?? 'Khách vãng lai' }}</p>
                    <p class="mb-2"><i class="fas fa-phone mr-2 text-gray-500"></i> <strong>SĐT:</strong>
                        {{ $order->user->sodienthoai ?? 'Chưa cập nhật' }}</p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i> <strong>Địa chỉ:</strong>
                        {{ $order->diachigiaohang }}</p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tóm tắt thanh toán</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-600">Tổng tiền hàng:</span>
                        <span
                            class="font-weight-bold">{{ number_format($order->tongtien + $order->sotiengiam - 30000, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-600">Phí vận chuyển:</span>
                        <span class="font-weight-bold">30.000đ</span>
                    </div>
                    @if($order->sotiengiam > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-gray-600">Giảm giá:</span>
                            <span
                                class="font-weight-bold text-success">-{{ number_format($order->sotiengiam, 0, ',', '.') }}đ</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="font-weight-bold text-dark">Khách phải trả:</span>
                        <span
                            class="h5 mb-0 font-weight-bold text-danger">{{ number_format($order->tongtien, 0, ',', '.') }}đ</span>
                    </div>

                    <div class="alert alert-{{ $order->trangthaithanhtoan == 1 ? 'success' : 'warning' }} text-center mb-0">
                        <div class="font-weight-bold">{{ $order->phuongthucthanhtoan }}</div>
                        <small>{{ $order->trangthaithanhtoan == 1 ? 'Đã thanh toán' : 'Chờ thanh toán' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection