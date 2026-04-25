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
// mở khóa tài khoản (thay thế cho xóa cứng)
    public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    
    // Nếu đang là 1 (Hoạt động) thì thành 0 (Khóa) và ngược lại
    $user->trangthai = ($user->trangthai == 1) ? 0 : 1;
    $user->save();

    $message = $user->trangthai == 1 ? 'Đã mở khóa tài khoản!' : 'Đã khóa tài khoản thành công!';
    return back()->with('thongbao', $message);
}

    // ==========================================
    // PHẦN DÀNH CHO USER (GIAO DIỆN KHÁCH HÀNG)
    // ==========================================

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Lấy thêm danh sách đơn hàng của User này để ném ra view
        $orders = \App\Models\Order::where('nguoidungID', $user->id)->orderBy('ngaytao', 'desc')->get();
        
        return view('pages.profile', compact('user', 'orders'));
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

        // LOGIC ĐỔI MẬT KHẨU (Có check mật khẩu cũ và xác nhận mật khẩu mới)
        if ($request->filled('matkhau_cu') || $request->filled('matkhau')) {
            $request->validate([
                'matkhau_cu' => [
                    'required',
                    function ($attribute, $value, $fail) use ($user) {
                        // Kiểm tra xem mật khẩu cũ gõ vào có khớp với DB không
                        if (!Hash::check($value, $user->matkhau)) {
                            $fail('Mật khẩu hiện tại không chính xác.');
                        }
                    }
                ],
                // Rule 'confirmed' bắt buộc ở Frontend phải có ô input tên là 'matkhau_confirmation'
                'matkhau' => ['required', 'string', 'min:8', 'confirmed'], 
            ], [
                'matkhau_cu.required' => 'Vui lòng nhập mật khẩu hiện tại.',
                'matkhau.required' => 'Vui lòng nhập mật khẩu mới.',
                'matkhau.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
                'matkhau.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.'
            ]);

            $validated['matkhau'] = Hash::make($request->matkhau);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('thongbao', 'Cập nhật thành công!');
    }
}