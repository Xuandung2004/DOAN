@extends('admin.includes.master')

@section('title', 'Quản lý Đơn hàng')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách Đơn hàng</h1>
    </div>

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-list mr-2"></i>Tất cả đơn hàng hệ thống
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th width="10%">Mã ĐH</th>
                            <th width="20%">Khách hàng</th>
                            <th width="15%">Ngày đặt</th>
                            <th width="15%">Tổng tiền</th>
                            <th width="15%">Thanh toán</th>
                            <th width="15%">Trạng thái (Đổi nhanh)</th>
                            <th width="10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    #DH{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    <strong>{{ $order->user->hoten ?? 'Khách vãng lai' }}</strong><br>
                                    <small class="text-muted"><i class="fas fa-phone mr-1"></i>
                                        {{ $order->user->sodienthoai ?? 'Trống' }}</small>
                                </td>

                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($order->ngaytao)->format('d/m/Y') }}<br>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($order->ngaytao)->format('H:i') }}</small>
                                </td>

                                <td class="text-right font-weight-bold text-danger">
                                    {{ number_format($order->tongtien, 0, ',', '.') }}đ
                                </td>

                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $order->trangthaithanhtoan == 1 ? 'success' : 'warning text-dark' }} p-2">
                                        {{ $order->phuongthucthanhtoan }}<br>
                                        {{ $order->trangthaithanhtoan == 1 ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                                    </span>
                                </td>

                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="trangthaidon" class="form-control form-control-sm font-weight-bold 
                                                            {{ $order->trangthaidon == 0 ? 'text-secondary' : '' }}
                                                            {{ $order->trangthaidon == 1 ? 'text-primary' : '' }}
                                                            {{ $order->trangthaidon == 2 ? 'text-success' : '' }}
                                                            {{ $order->trangthaidon == 3 ? 'text-danger' : '' }}"
                                            onchange="this.form.submit()">
                                            <option value="0" {{ $order->trangthaidon == 0 ? 'selected' : '' }}>Chờ xử lý</option>
                                            <option value="1" {{ $order->trangthaidon == 1 ? 'selected' : '' }}>Đang giao</option>
                                            <option value="2" {{ $order->trangthaidon == 2 ? 'selected' : '' }}>Hoàn tất</option>
                                            <option value="3" {{ $order->trangthaidon == 3 ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm"
                                        title="Xem chi tiết đơn">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-box-open fa-3x mb-3 text-gray-300"></i>
                                    <p>Chưa có đơn hàng nào trong hệ thống.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection