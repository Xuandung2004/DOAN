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
    public function adminIndex()
    {
        $orders = Order::with('user')->orderBy('ngaytao', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate(['trangthaidon' => 'required|integer|in:0,1,2,3']);

        // Xử lý hoàn kho nếu Hủy đơn
        if ($request->trangthaidon == 3 && $order->trangthaidon != 3) {
            foreach($order->orderItems as $item) {
                $item->product->increment('soluong', $item->soluong);
            }
            if ($order->magiamgiaID) \App\Models\Coupon::where('id', $order->magiamgiaID)->decrement('dasudung');
        } 
        elseif ($order->trangthaidon == 3 && $request->trangthaidon != 3) {
             foreach($order->orderItems as $item) {
                $item->product->decrement('soluong', $item->soluong);
            }
        }

        $order->trangthaidon = $request->trangthaidon;
        $order->save();

        return back()->with('thongbao', 'Đã cập nhật trạng thái đơn hàng!');
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