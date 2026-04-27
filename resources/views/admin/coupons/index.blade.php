@extends('admin.includes.master')

@section('title', 'Quản lý Mã giảm giá')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách Mã giảm giá</h1>
        <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm mới
        </a>
    </div>

    @if(session('thongbao'))
        <div class="alert alert-success shadow-sm">{{ session('thongbao') }}</div>
    @endif

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-5">
                    <form action="" method="GET" class="d-flex">
                        <div class="input-group shadow-sm">
                            <input type="text" name="keyword" class="form-control" placeholder="Nhập mã giảm giá cần tìm..."
                                value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        @if(request('keyword'))
                            <a href="{{ url()->current() }}" class="btn btn-secondary ms-2 d-flex align-items-center shadow-sm"
                                style="white-space: nowrap;">
                                <i class="fas fa-times me-1"></i> Hủy
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã</th>
                            <th>Loại mã</th>
                            <th>Giá trị</th>
                            <th>Giá tối thiểu</th>
                            <th>Giới hạn lượt</th>
                            <th>Đã sử dụng</th>
                            <th>Thời hạn</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $cp)
                            <tr>
                                <td class="font-weight-bold text-success">{{ $cp->ma }}</td>
                                <td>
                                    <span class="badge badge-{{ $cp->loai == 'phantram' ? 'info' : 'secondary' }}">
                                        {{ $cp->loai == 'phantram' ? 'Phần trăm (%)' : 'Tiền mặt (VNĐ)' }}
                                    </span>
                                </td>
                                <td class="font-weight-bold text-danger">
                                    {{ $cp->loai == 'phantram' ? $cp->giatri . '%' : number_format($cp->giatri, 0, ',', '.') . 'đ' }}
                                </td>
                                <td>{{ number_format($cp->giatridontoithieu, 0, ',', '.') }}đ</td>
                                <td>{{ $cp->gioihansudung ?? 'Vô hạn' }}</td>
                                <td class="font-weight-bold text-primary">{{ $cp->dasudung }}</td>
                                <td>
                                    @if($cp->hethan)
                                        @if(\Carbon\Carbon::parse($cp->hethan)->isPast())
                                            <span class="text-danger"><i class="fas fa-times-circle"></i>
                                                {{ \Carbon\Carbon::parse($cp->hethan)->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-success"><i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($cp->hethan)->format('d/m/Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Không thời hạn</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('coupons.edit', $cp->id) }}" class="btn btn-primary btn-sm px-3">
                                        <i class="fas fa-edit mr-1"></i> Sửa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">Chưa có mã giảm giá nào được tạo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-right">
                {{ $coupons->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection