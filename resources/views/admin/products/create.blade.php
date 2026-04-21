@extends('admin.includes.master')

@section('title', 'Thêm Sản Phẩm Mới')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Sản Phẩm Mới</h1>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại danh sách
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin chi tiết</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group">
                            <label for="ten">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten"
                                value="{{ old('ten') }}" placeholder="VD: Sầu riêng Ri6" required>
                            @error('ten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="mota">Mô tả sản phẩm</label>
                            <textarea class="form-control @error('mota') is-invalid @enderror" id="mota" name="mota"
                                rows="6" placeholder="Nhập mô tả chi tiết về trái cây...">{{ old('mota') }}</textarea>
                            @error('mota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="images">Hình ảnh sản phẩm (Có thể chọn nhiều ảnh cùng lúc)</label>
                            <input type="file" class="form-control-file @error('images.*') is-invalid @enderror" id="images"
                                name="images[]" multiple accept="image/*">
                            <small class="form-text text-muted">Định dạng hỗ trợ: jpg, jpeg, png, webp. Tối đa
                                2MB/ảnh.</small>
                            @error('images.*') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="danhmucID">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control @error('danhmucID') is-invalid @enderror" id="danhmucID"
                                name="danhmucID" required>
                                <option value="">-- Chọn danh mục --</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $dm)
                                        <option value="{{ $dm->id }}" {{ old('danhmucID') == $dm->id ? 'selected' : '' }}>
                                            {{ $dm->ten }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Chưa có danh mục nào (Hãy thêm DM trước)</option>
                                @endif
                            </select>
                            @error('danhmucID') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="gia">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('gia') is-invalid @enderror" id="gia" name="gia"
                                value="{{ old('gia') }}" min="0" required>
                            @error('gia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="giagiam">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control @error('giagiam') is-invalid @enderror" id="giagiam"
                                name="giagiam" value="{{ old('giagiam') }}" min="0">
                            <small class="form-text text-muted">Để trống nếu không giảm giá.</small>
                            @error('giagiam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="soluong">Số lượng trong kho <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('soluong') is-invalid @enderror" id="soluong"
                                name="soluong" value="{{ old('soluong', 10) }}" min="0" required>
                            @error('soluong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>

                <hr>

                <div class="text-right">
                    <button type="reset" class="btn btn-secondary">Nhập lại</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu sản phẩm</button>
                </div>

            </form>
        </div>
    </div>
@endsection