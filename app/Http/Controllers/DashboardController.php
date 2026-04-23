<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Dữ liệu cho 4 thẻ Top Card
        $tongDoanhThu = Order::where('trangthaithanhtoan', 1)->sum('tongtien'); // Chỉ tính đơn đã thanh toán
        $donHangMoi = Order::where('trangthaidon', 0)->count(); // Đơn chờ xử lý
        $tongSanPham = Product::count();
        $tongKhachHang = User::where('vaitro', 0)->count();

        // 2. Dữ liệu cho khối Trạng thái đơn hàng
        $donHoanThanh = Order::where('trangthaidon', 2)->count();
        $donDaHuy = Order::where('trangthaidon', 3)->count();
        $donDangXuLy = Order::where('trangthaidon', 0)->count();
        $donDangGiao = Order::where('trangthaidon', 1)->count();
        $donDaThanhToan = Order::where('trangthaithanhtoan', 1)->count();
        $tongSoDon = Order::count();

        // 3. Dữ liệu cho Biểu đồ Doanh thu từng tháng (Năm hiện tại)
        $doanhThuThang = [];
        $thangHienTai = date('Y');
        for ($i = 1; $i <= 12; $i++) {
            $doanhThuThang[] = Order::where('trangthaithanhtoan', 1)
                                    ->whereYear('ngaytao', $thangHienTai)
                                    ->whereMonth('ngaytao', $i)
                                    ->sum('tongtien');
        }

        // 4. Dữ liệu Biểu đồ Tồn kho danh mục
        $danhMucs = Category::withCount('products')->get();
        $tenDanhMucs = $danhMucs->pluck('ten')->toArray();
        $soLuongSPTrongDM = $danhMucs->pluck('products_count')->toArray();

        // 5. Xử lý Logic lọc Báo cáo Doanh thu (Khoảng, Năm, Tháng, Tuần)
        $ketQuaLoc = null;
        if ($request->has('loai_loc')) {
            $queryDoanhThu = Order::where('trangthaithanhtoan', 1);
            $querySoDon = Order::query(); // Tính tổng số đơn (có thể tính cả đơn chưa TT)
            $tieuDe = '';

            switch ($request->loai_loc) {
                case 'khoang':
                    $queryDoanhThu->whereBetween('ngaytao', [$request->ngay_bat_dau . ' 00:00:00', $request->ngay_ket_thuc . ' 23:59:59']);
                    $querySoDon->whereBetween('ngaytao', [$request->ngay_bat_dau . ' 00:00:00', $request->ngay_ket_thuc . ' 23:59:59']);
                    $tieuDe = "từ {$request->ngay_bat_dau} đến {$request->ngay_ket_thuc}";
                    break;
                case 'nam':
                    $queryDoanhThu->whereYear('ngaytao', $request->nam);
                    $querySoDon->whereYear('ngaytao', $request->nam);
                    $tieuDe = "Năm {$request->nam}";
                    break;
                case 'thang':
                    $queryDoanhThu->whereYear('ngaytao', $request->nam)->whereMonth('ngaytao', $request->thang);
                    $querySoDon->whereYear('ngaytao', $request->nam)->whereMonth('ngaytao', $request->thang);
                    $tieuDe = "Tháng {$request->thang}/{$request->nam}";
                    break;
                case 'tuan':
                    // Xử lý logic lọc theo tuần nếu cần
                    $tieuDe = "Tuần {$request->tuan}/{$request->nam}";
                    break;
            }

            $ketQuaLoc = [
                'tieu_de' => $tieuDe,
                'doanh_thu' => $queryDoanhThu->sum('tongtien'),
                'so_don' => $querySoDon->count()
            ];
        }

        return view('admin.index', compact(
            'tongDoanhThu', 'donHangMoi', 'tongSanPham', 'tongKhachHang', 
            'donHoanThanh', 'donDaHuy', 'donDangXuLy', 'donDangGiao', 'donDaThanhToan', 'tongSoDon',
            'doanhThuThang', 'tenDanhMucs', 'soLuongSPTrongDM', 'ketQuaLoc'
        ));
    }
}