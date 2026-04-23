@extends('admin.includes.master')

@section('title', 'Thêm Danh mục')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Danh mục Mới</h1>
        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="ten" class="font-weight-bold">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten"
                        value="{{ old('ten') }}" placeholder="Ví dụ: Áo khoác nam" required>
                    @error('ten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Hệ thống sẽ tự động tạo đường dẫn (slug) từ tên này.</small>
                </div>

                <hr>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Tạo danh mục</button>
                </div>
            </form>
        </div>
    </div>
@endsection