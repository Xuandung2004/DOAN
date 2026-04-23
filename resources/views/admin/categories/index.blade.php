@extends('admin.includes.master')

@section('title', 'Quản lý Danh mục')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách Danh mục</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm mới
        </a>
    </div>

    @if($errors->has('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $errors->first('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Tên danh mục</th>
                            <th width="25%">Đường dẫn (Slug)</th>
                            <th width="20%">Số sản phẩm</th>
                            <th width="15%" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td class="font-weight-bold">{{ $cat->ten }}</td>
                                <td><span class="text-muted">{{ $cat->duongdan }}</span></td>
                                <td>
                                    @if($cat->products_count > 0)
                                        <span class="badge badge-info">{{ $cat->products_count }} sản phẩm</span>
                                    @else
                                        <span class="badge badge-secondary">Trống</span>
                                    @endif
                                </td>
                                <td class="text-center d-flex justify-content-center">
                                    <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-primary btn-sm mr-2"
                                        title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Chưa có danh mục nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-right">
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection