<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        // Kiểm tra trạng thái tài khoản
    if ($user->trangthai == 0) {
    Auth::logout();
    return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Admin.']);
}
        // Kiểm tra cột 'vaitro' (Nếu DB của ông bạn đặt tên cột khác thì sửa lại chữ vaitro nhé)
        if ($user->vaitro == 1) {
            // Nếu là Admin -> Đá thẳng vào trang Dashboard của Admin
            // (Đảm bảo route 'admin.dashboard' đã được khai báo trong web.php giống bài trước)
            return redirect()->route('admin.index'); 
        }

        // Nếu là Khách hàng bình thường (vaitro = 0) -> Trả về trang chủ hoặc trang họ định vào
        return redirect()->intended('/');
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
