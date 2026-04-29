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
                // Cập nhật googleID (gọi đúng tên cột trong DB)
                $user->update([
                    'googleID' => $googleUser->getId(),
                ]);
                Auth::login($user);
            } else {
                // SỬA LỖI Ở ĐÂY: Dùng đúng tên cột vật lý trong Database để Laravel không bị lú
                $newUser = User::create([
                    'hoten' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'googleID' => $googleUser->getId(),
                    // Dùng Hash::make thay vì mong chờ tính năng cast tự động khi dùng alias
                    'matkhau' => \Illuminate\Support\Facades\Hash::make(Str::random(16)), 
                    'vaitro' => 0,
                    'trangthai' => 1, // PHẢI CÓ CÁI NÀY: 1 = Đang hoạt động, nếu thiếu nó sẽ rớt vào trường hợp tài khoản bị khóa ở AuthenticatedSessionController
                ]);
                Auth::login($newUser);
            }

            // Đăng nhập xong đẩy về trang chủ
            return redirect()->route('home');

        } catch (\Exception $e) {
            // Nếu có lỗi, đẩy về lại trang đăng nhập (tôi thêm dòng hiển thị chi tiết lỗi để ông bạn dễ debug nếu vẫn xịt)
            return redirect()->route('login')->withErrors(['email' => 'Đăng nhập Google thất bại: ' . $e->getMessage()]);
        }
    }
}