@extends('admin.includes.master')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách Sản phẩm</h1>
        <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm sản phẩm mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tất cả sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-5">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="keyword" class="form-control me-2 shadow-sm"
                            placeholder="Nhập tên sản phẩm cần tìm..." value="{{ request('keyword') }}">

                        <button type="submit" class="btn btn-primary d-flex align-items-center shadow-sm">
                            <i class="fas fa-search me-1"></i> Tìm
                        </button>

                        @if(request('keyword'))
                            <a href="{{ url()->current() }}" class="btn btn-secondary ms-2 d-flex align-items-center shadow-sm">
                                <i class="fas fa-times me-1"></i> Hủy
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="10%">Hình ảnh</th>
                            <th width="25%">Tên sản phẩm</th>
                            <th width="15%">Danh mục</th>
                            <th width="15%">Giá / Giảm giá</th>
                            <th width="15%">Trạng thái</th>
                            <th width="15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $key => $sp)
                            <tr>
                                <td>{{ $products->firstItem() + $key }}</td>

                                <td class="text-center">
                                    @if($sp->images && $sp->images->isNotEmpty())
                                        <img src="{{ asset($sp->images->first()->duongdananh) }}" alt="{{ $sp->ten }}"
                                            class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <span class="text-muted small">Chưa có</span>
                                    @endif
                                </td>

                                <td><strong>{{ $sp->ten }}</strong></td>
                                <td>{{ $sp->category->ten ?? 'Không xác định' }}</td>

                                <td>
                                    @if($sp->giagiam > 0 && $sp->giagiam < $sp->gia)
                                        <span class="text-danger fw-bold">{{ number_format($sp->giagiam, 0, ',', '.') }}đ</span><br>
                                        <del class="text-muted small">{{ number_format($sp->gia, 0, ',', '.') }}đ</del>
                                    @else
                                        <span class="text-danger fw-bold">{{ number_format($sp->gia, 0, ',', '.') }}đ</span>
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('products.toggle', $sp->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm {{ $sp->trangthai == 1 ? 'btn-success' : 'btn-secondary' }}"
                                            title="Bấm để đổi trạng thái">
                                            <i class="fas {{ $sp->trangthai == 1 ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                            {{ $sp->trangthai == 1 ? 'Đang hiện' : 'Đang ẩn' }}
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <a href="{{ route('products.edit', $sp->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $sp->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Mọi hình ảnh liên quan cũng sẽ bị xóa!');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Chưa có sản phẩm nào trong cửa hàng.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
@endsection