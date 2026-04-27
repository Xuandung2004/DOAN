<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// THÊM DÒNG NÀY ĐỂ TRỊ VS CODE:
use Illuminate\Support\Facades\Auth; 

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Đổi auth()->check() thành Auth::check()
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
        }

        // Đổi auth()->user() thành Auth::user()
        if (Auth::user()->vaitro != 1) {
            abort(403, 'CẢNH BÁO: Bạn không có quyền truy cập khu vực Quản trị!');
        }

        return $next($request);
    }
}