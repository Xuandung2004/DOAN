@extends('admin.includes.master')

@section('title', 'Thêm Người Dùng')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Người Dùng Mới</h1>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ và Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('hoten') is-invalid @enderror" name="hoten"
                            value="{{ old('hoten') }}" required>
                        @error('hoten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('matkhau') is-invalid @enderror" name="matkhau"
                            required>
                        @error('matkhau') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control @error('sodienthoai') is-invalid @enderror"
                            name="sodienthoai" value="{{ old('sodienthoai') }}">
                        @error('sodienthoai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Vai trò <span class="text-danger">*</span></label>
                        <select name="vaitro" class="form-control @error('vaitro') is-invalid @enderror" required>
                            <option value="0" {{ old('vaitro') == '0' ? 'selected' : '' }}>Khách hàng</option>
                            <option value="1" {{ old('vaitro') == '1' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                        </select>
                        @error('vaitro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Trạng thái <span class="text-danger">*</span></label>
                        <select name="trangthai" class="form-control @error('trangthai') is-invalid @enderror" required>
                            <option value="1" {{ old('trangthai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('trangthai') == '0' ? 'selected' : '' }}>Khóa tài khoản</option>
                        </select>
                        @error('trangthai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Địa chỉ</label>
                        <textarea name="diachi" class="form-control @error('diachi') is-invalid @enderror"
                            rows="3">{{ old('diachi') }}</textarea>
                        @error('diachi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tạo tài khoản</button>
                </div>
            </form>
        </div>
    </div>
@endsection