@extends('admin.includes.master')

@section('title', 'Sửa Sản Phẩm')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sửa Sản Phẩm: <span class="text-primary">{{ $product->ten }}</span></h1>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cập nhật thông tin chi tiết</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="ten">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten"
                                value="{{ old('ten', $product->ten) }}" required>
                            @error('ten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="danhmucID">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-control @error('danhmucID') is-invalid @enderror" id="danhmucID"
                                    name="danhmucID" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $dm)
                                        <option value="{{ $dm->id }}" {{ old('danhmucID', $product->danhmucID) == $dm->id ? 'selected' : '' }}>
                                            {{ $dm->ten }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('danhmucID') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="soluong">Số lượng trong kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('soluong') is-invalid @enderror"
                                    id="soluong" name="soluong" value="{{ old('soluong', $product->soluong) }}" min="0"
                                    required>
                                @error('soluong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="gia">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('gia') is-invalid @enderror" id="gia"
                                    name="gia" value="{{ old('gia', $product->gia) }}" min="0" required>
                                @error('gia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="giagiam">Giá khuyến mãi (VNĐ)</label>
                                <input type="number" class="form-control @error('giagiam') is-invalid @enderror"
                                    id="giagiam" name="giagiam" value="{{ old('giagiam', $product->giagiam) }}" min="0">
                                @error('giagiam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mota">Mô tả sản phẩm</label>
                            <textarea class="form-control @error('mota') is-invalid @enderror" id="mota" name="mota"
                                rows="5">{{ old('mota', $product->mota) }}</textarea>
                            @error('mota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group bg-light p-3 border rounded">
                            <label for="images" class="text-primary font-weight-bold"><i class="fas fa-upload"></i> Tải thêm
                                ảnh mới</label>
                            <input type="file" class="form-control-file @error('images.*') is-invalid @enderror" id="images"
                                name="images[]" multiple accept="image/*">
                            <small class="form-text text-muted">Có thể chọn nhiều ảnh. Ảnh cũ vẫn được giữ nguyên.</small>
                            @error('images.*') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật thông
                                tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hình ảnh hiện tại</h6>
                </div>
                <div class="card-body">
                    @if($product->images && $product->images->count() > 0)
                        <div class="row">
                            @foreach($product->images as $img)
                                <div class="col-6 mb-3 text-center">
                                    <div class="border rounded p-1 position-relative">
                                        <img src="{{ asset($img->duongdananh) }}" class="img-fluid rounded mb-2"
                                            style="height: 120px; object-fit: cover; width: 100%;">

                                        <form action="{{ route('products.destroyImage', $img->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-block"
                                                onclick="return confirm('Bạn có chắc muốn xóa ảnh này không?');">
                                                <i class="fas fa-trash"></i> Xóa ảnh
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Sản phẩm này chưa có hình ảnh nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection