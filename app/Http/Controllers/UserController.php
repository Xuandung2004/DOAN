<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // ==========================================
    // PHẦN DÀNH CHO ADMIN (QUẢN TRỊ VIÊN)
    // ==========================================

    public function index()
    {
        $users = User::orderBy('ngaytao', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hoten'       => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:nguoidung,email',
            'matkhau'     => ['required', 'string', Password::defaults()],
            'sodienthoai' => 'nullable|string|max:20',
            'diachi'      => 'nullable|string|max:500',
            'vaitro'      => 'required|integer|in:0,1',
            'trangthai'   => 'required|integer|in:0,1',
        ]);

        // Băm mật khẩu trước khi lưu
        $validated['matkhau'] = Hash::make($validated['matkhau']);

        User::create($validated);

        return redirect()->route('users.index')->with('thongbao', 'Thêm người dùng thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'hoten'       => 'required|string|max:255',
            // Loại trừ ID hiện tại để không lỗi trùng Email
            'email'       => 'required|string|email|max:255|unique:nguoidung,email,' . $user->id,
            'sodienthoai' => 'nullable|string|max:20',
            'diachi'      => 'nullable|string|max:500',
            'vaitro'      => 'required|integer|in:0,1',
            'trangthai'   => 'required|integer|in:0,1',
        ]);

        // Chỉ kiểm tra và cập nhật mật khẩu nếu Admin có nhập mật khẩu mới
        if ($request->filled('matkhau')) {
            $request->validate([
                'matkhau' => ['string', Password::defaults()]
            ]);
            $validated['matkhau'] = Hash::make($request->matkhau);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('thongbao', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('thongbao', 'Xóa người dùng thành công!');
    }

    // ==========================================
    // PHẦN DÀNH CHO USER (GIAO DIỆN KHÁCH HÀNG)
    // ==========================================

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return view('pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'hoten'       => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:nguoidung,email,' . $user->id,
            'sodienthoai' => 'nullable|string|max:20',
            'diachi'      => 'nullable|string|max:500',
        ]);

        // Hỗ trợ User tự đổi mật khẩu nếu muốn
        if ($request->filled('matkhau')) {
            $request->validate([
                'matkhau' => ['string', Password::defaults()]
            ]);
            $validated['matkhau'] = Hash::make($request->matkhau);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('thongbao', 'Cập nhật hồ sơ cá nhân thành công!');
    }
}