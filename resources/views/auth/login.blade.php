@extends('layouts.master')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5"> <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header text-white text-center py-3" style="background-color: #8B9483;"> <h4 class="mb-0 fw-bold">Đăng Nhập</h4>
                    </div>
                    <div class="card-body p-4 bg-light">

                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label fw-bold text-secondary">Địa chỉ Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required autofocus autocomplete="username" placeholder="Nhập email của bạn">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="password" class="form-label fw-bold text-secondary">Mật khẩu</label>
                                <input type="password" id="password" name="password"
                                    class="form-control py-2 @error('password') is-invalid @enderror" required
                                    autocomplete="current-password" placeholder="Nhập mật khẩu">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mb-4">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                                        Quên mật khẩu?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn w-100 py-2 text-white fw-bold text-uppercase" style="background-color: #8B9483; border: none;">
                                Đăng Nhập
                            </button>
                        </form>

                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1">
                            <span class="mx-3 text-muted small">HOẶC</span>
                            <hr class="flex-grow-1">
                        </div>

                        <a href="{{ route('google.login') }}"
                            class="btn btn-outline-danger w-100 d-flex justify-content-center align-items-center py-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-google me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                            </svg>
                            Đăng nhập bằng Google
                        </a>

                        <div class="text-center mt-2">
                            <span class="text-muted">Chưa có tài khoản?</span> 
                            <a class="text-decoration-none fw-bold" href="{{ route('register') }}" style="color: #8B9483;">
                                Đăng ký
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection