<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // ==========================================
    // PHẦN DÀNH CHO ADMIN
    // ==========================================
    public function adminIndex(Request $request)
    {
        // 1. Khởi tạo query gốc (Kèm thông tin user)
    $query = Order::with('user');

    // 2. Bắt từ khóa tìm kiếm
    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;
        
        // Bóc tách chữ DH và dấu # ra để lấy mỗi con số (hỗ trợ cả chữ hoa/thường)
        $idSearch = (int) str_ireplace(['#', 'DH'], '', $keyword);

        // Gom nhóm các điều kiện OR lại với nhau để tìm kiếm chính xác
        $query->where(function($q) use ($idSearch, $keyword) {
            $q->where('id', $idSearch)
              ->orWhere('tennguoinhan', 'like', '%' . $keyword . '%')
              ->orWhere('sodienthoai', 'like', '%' . $keyword . '%');
        });
    }

    // 3. Sắp xếp, phân trang (15 dòng) và giữ từ khóa trên URL
    $orders = $query->orderBy('ngaytao', 'desc')->paginate(15)->withQueryString();

    return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate(['trangthaidon' => 'required|integer|in:0,1,2,3']);

        $trangThaiCu = $order->trangthaidon;
        $trangThaiMoi = $request->trangthaidon;

        // Bỏ qua nếu Admin bấm nhầm vào trạng thái hiện tại
        if ($trangThaiCu == $trangThaiMoi) {
            return back();
        }

        // ==========================================
        // 🛡️ BỘ LỌC BẢO VỆ (STATE MACHINE)
        // ==========================================
        // 1. Chặn: Không cho đổi trạng thái nếu đơn đã Hoàn tất hoặc Đã hủy
        if (in_array($trangThaiCu, [2, 3])) {
            return back()->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã Hoàn tất hoặc Đã hủy!');
        }

        // 2. Chặn: Không cho nhảy cóc từ "Chờ xử lý" (0) lên thẳng "Hoàn tất" (2)
        if ($trangThaiCu == 0 && $trangThaiMoi == 2) {
            return back()->with('error', 'Đơn hàng phải được chuyển sang "Đang giao" trước khi "Hoàn tất"!');
        }

        // ==========================================
        // 📦 XỬ LÝ LOGIC KHO & MÃ GIẢM GIÁ
        // ==========================================
        if ($trangThaiMoi == 3) {
            // Khách hoặc Admin Hủy đơn -> Trả lại hàng vào kho
            foreach($order->orderItems as $item) {
                $item->product->increment('soluong', $item->soluong);
            }
            // Trả lại lượt dùng mã giảm giá
            if ($order->magiamgiaID) {
                \App\Models\Coupon::where('id', $order->magiamgiaID)->decrement('dasudung');
            }
        } 
        
        // (Đã xóa đoạn elseif khôi phục đơn từ Hủy để tránh lỗi kho hàng bị âm)

        // ==========================================
        // 💾 LƯU TRẠNG THÁI MỚI
        // ==========================================
        $order->trangthaidon = $trangThaiMoi;

        // LOGIC TỰ ĐỘNG: Nếu đơn "Hoàn tất" (2) thì mặc định là đã thu được tiền
        if ($trangThaiMoi == 2) {
            $order->trangthaithanhtoan = 1;
        }

        $order->save();

        return back()->with('thongbao', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
    // Admin xem chi tiết 1 đơn hàng
    public function adminShow($id)
    {
        // Lấy đơn hàng + Thông tin khách + Chi tiết sản phẩm + Ảnh sản phẩm
        $order = Order::with(['user', 'orderItems.product.images'])
                      ->findOrFail($id);
                      
        return view('admin.orders.showdetail', compact('order'));
    }


    // ==========================================
    // PHẦN DÀNH CHO USER (KHÁCH HÀNG)
    // ==========================================
    public function history()
    {
        $orders = Order::where('nguoidungID', Auth::id())->orderBy('ngaytao', 'desc')->paginate(10);
        return view('pages.ordershistory', compact('orders'));
    }

    public function show($id)
    {
        // Phải tải thêm 'images' của product để ra ngoài View có ảnh mà hiển thị
        $order = Order::with(['orderItems.product.images'])
                      ->where('nguoidungID', Auth::id())
                      ->where('id', $id)
                      ->firstOrFail();
                      
        return view('pages.orderdetail', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('nguoidungID', Auth::id())->where('id', $id)->firstOrFail();
        
        if ($order->trangthaidon == 0) {
            $order->trangthaidon = 3; 
            $order->save();
            
            foreach($order->orderItems as $item) $item->product->increment('soluong', $item->soluong);
            if ($order->magiamgiaID) \App\Models\Coupon::where('id', $order->magiamgiaID)->decrement('dasudung');

            return back()->with('thongbao', 'Đã hủy đơn hàng thành công!');
        }
        
        return back()->withErrors(['error' => 'Không thể hủy đơn hàng đã được xử lý!']);
    }
}