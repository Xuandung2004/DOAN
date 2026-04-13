@extends('layouts.master')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Cập Nhật Hồ Sơ</h4>
                    </div>
                    <div class="card-body p-4 bg-light">

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="form-group mb-3">
                                <label for="name" class="form-label fw-bold">Họ và Tên</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', auth()->user()->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label fw-bold">Địa chỉ Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    Cập Nhật Hồ Sơ
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-warning text-dark text-center">
                        <h4 class="mb-0">Đổi Mật Khẩu</h4>
                    </div>
                    <div class="card-body p-4 bg-light">

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="form-group mb-3">
                                <label for="current_password" class="form-label fw-bold">Mật Khẩu Hiện Tại</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label fw-bold">Mật Khẩu Mới</label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Xác Nhận Mật Khẩu Mới</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-warning px-4 py-2">
                                    Đổi Mật Khẩu
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-danger text-white text-center">
                        <h4 class="mb-0">Xóa Tài Khoản</h4>
                    </div>
                    <div class="card-body p-4 bg-light">

                        <p class="text-muted">Khi xóa tài khoản, tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn. Hãy cẩn thận!
                        </p>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-danger px-4 py-2">
                                    Xóa Tài Khoản
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection