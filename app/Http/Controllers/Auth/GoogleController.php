<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Chuyển hướng người dùng sang trang đăng nhập của Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý dữ liệu Google trả về
    public function callback()
    {
        try {
            // Lấy thông tin từ Google
            $googleUser = Socialite::driver('google')->user();

            // Kiểm tra xem email này đã tồn tại trong hệ thống chưa
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Nếu đã có tài khoản (có thể trước đó họ đăng ký bằng form)
                // Thì cập nhật google_id cho họ và cho đăng nhập luôn
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
                Auth::login($user);
            } else {
                // Nếu chưa từng có tài khoản, tự động tạo mới
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)), // Gán mật khẩu ngẫu nhiên cho an toàn
                    'role' => 0,
                ]);
                Auth::login($newUser);
            }

            // Đăng nhập xong đẩy về trang Dashboard hoặc Trang chủ
            return redirect()->route('home');

        } catch (\Exception $e) {
            // Nếu có lỗi (khách hủy không đăng nhập nữa), đẩy về lại trang đăng nhập
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}