<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ==========================================
    // PHẦN DÀNH CHO ADMIN (QUẢN TRỊ VIÊN)
    // ==========================================

    /**
     * Danh sách sản phẩm (Admin)
     */
    public function index(Request $request)
    {
        // 1. Khởi tạo query gốc (Kèm danh mục và điều kiện trạng thái)
    $query = Product::with('category')->where('trangthai', '>=', 0);

    // 2. Bắt từ khóa tìm kiếm (Nếu có)
    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;
        // Lọc những sản phẩm có tên chứa từ khóa
        $query->where('ten', 'like', '%' . $keyword . '%');
    }

    // 3. Sắp xếp, phân trang và THÊM withQueryString() để giữ từ khóa trên URL
    $products = $query->orderBy('ngaytao', 'desc')->paginate(10)->withQueryString();

    return view('admin.products.index', compact('products'));
    }

    /**
     * Form thêm sản phẩm
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm & Upload nhiều ảnh
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten'       => 'required|string|max:255',
            'danhmucID' => 'required|exists:danhmuc,id',
            'gia'       => 'required|numeric|min:0',
            'giagiam'   => 'nullable|numeric|min:0',
            'soluong'   => 'required|integer|min:0',
            'mota'      => 'nullable|string',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Validate mảng ảnh
        ]);

        // Tạo sản phẩm mới, tự động sinh đường dẫn (slug) từ tên
        $product = Product::create([
            'ten'           => $request->ten,
            'duongdan'      => Str::slug($request->ten) . '-' . time(), // Thêm time() để đảm bảo unique 100%
            'danhmucID'     => $request->danhmucID,
            'gia'           => $request->gia,
            'giagiam'       => $request->giagiam ?? 0,
            'soluong'       => $request->soluong,
            'mota'          => $request->mota,
            'trangthai'     => 1, // Mặc định hiển thị
            'diemtrungbinh' => 0,
        ]);

        // Xử lý upload NHIỀU ẢNH cùng lúc
          if ($request->hasFile('images')) {
    foreach ($request->file('images') as $file) {
        // 1. Lấy tên gốc của file ảnh
        $filename = $file->getClientOriginalName();
        
        // 2. Định nghĩa đường dẫn đích trong thư mục public/images
        $destinationPath = public_path('images');

        // 3. Kiểm tra nếu file chưa tồn tại thì mới di chuyển vào thư mục
        if (!file_exists($destinationPath . '/' . $filename)) {
            $file->move($destinationPath, $filename);
        }

        // 4. Lưu vào Database đường dẫn tương ứng để hiển thị (bỏ chữ storage/)
        ProductImage::create([
            'sanphamID'   => $product->id,
            'duongdananh' => 'images/' . $filename
        ]);
    }
}

        return redirect()->route('products.index')->with('thongbao', 'Thêm sản phẩm thành công!');
    }

    /**
     * Form sửa sản phẩm
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ten'       => 'required|string|max:255',
            'danhmucID' => 'required|exists:danhmuc,id',
            'gia'       => 'required|numeric|min:0',
            'giagiam'   => 'nullable|numeric|min:0',
            'soluong'   => 'required|integer|min:0',
            'mota'      => 'nullable|string',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Cập nhật thông tin cơ bản
        $product->update([
            'ten'       => $request->ten,
            'duongdan'  => Str::slug($request->ten) . '-' . $product->id,
            'danhmucID' => $request->danhmucID,
            'gia'       => $request->gia,
            'giagiam'   => $request->giagiam ?? 0,
            'soluong'   => $request->soluong,
            'mota'      => $request->mota,
        ]);

        // Xử lý upload ảnh bổ sung (nếu có chọn thêm ảnh)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Đổi sang logic lưu vào public/images giống hệt hàm store
                $filename = $file->getClientOriginalName();
                $destinationPath = public_path('images');

                if (!file_exists($destinationPath . '/' . $filename)) {
                    $file->move($destinationPath, $filename);
                }

                ProductImage::create([
                    'sanphamID'   => $product->id,
                    'duongdananh' => 'images/' . $filename
                ]);
            }
        }

        return redirect()->route('products.index')->with('thongbao', 'Cập nhật sản phẩm thành công!');
    }
     /**
     * Xóa mềm sản phẩm (Đổi trạng thái thay vì xóa cứng khỏi DB)
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Thay vì dùng $product->delete() để xóa cứng, ta đổi trạng thái
        // Quy ước: -1 là Đã xóa (vào thùng rác)
        $product->trangthai = -1; 
        $product->save();

        return redirect()->route('products.index')->with('thongbao', 'Đã chuyển sản phẩm vào thùng rác!');
    }
    /**
     * Ẩn / Hiện sản phẩm (Thay vì xóa cứng)
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        
        $product->trangthai = $product->trangthai == 1 ? 0 : 1;
        $product->save();

        $thongBao = $product->trangthai == 1 ? "Đã HIỂN THỊ sản phẩm!" : "Đã ẨN sản phẩm khỏi cửa hàng!";
        return back()->with('thongbao', $thongBao);
    }

    /**
     * Xóa 1 bức ảnh cụ thể của sản phẩm (Dùng AJAX hoặc gọi trực tiếp)
     */
    public function destroyImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        
        // 1. Tìm và xóa file vật lý thật sự nằm trong thư mục public/images
        $imagePath = public_path($image->duongdananh); // Lấy đường dẫn tuyệt đối trên ổ cứng
        if (file_exists($imagePath)) {
            unlink($imagePath); // Dùng lệnh unlink thuần của PHP để xóa file rác
        }

        // 2. Xóa record (dòng dữ liệu) trong Database
        $image->delete();

        return back()->with('thongbao', 'Đã xóa ảnh thành công!');
    }


    // ==========================================
    // PHẦN DÀNH CHO USER (GIAO DIỆN KHÁCH HÀNG)
    // ==========================================

    /**
     * Trang danh sách sản phẩm có bộ lọc (Shop)
     */
    public function shop(Request $request)
    {
        // Chỉ lấy sản phẩm đang Hiển thị (trangthai = 1)
        $query = Product::with(['images', 'category'])->where('trangthai', 1);

        // Lọc theo danh mục
        if ($request->filled('danhmuc')) {
            $query->where('danhmucID', $request->danhmuc);
        }

        // Lọc theo khoảng giá
        if ($request->filled('gia_tu')) {
            $query->where('gia', '>=', $request->gia_tu);
        }
        if ($request->filled('gia_den')) {
            $query->where('gia', '<=', $request->gia_den);
        }

        // Tìm kiếm theo tên
        if ($request->filled('timkiem')) {
            $query->where('ten', 'LIKE', '%' . $request->timkiem . '%');
        }

        // Sắp xếp
        $sapxep = $request->get('sapxep', 'moi');
        switch ($sapxep) {
            case 'gia-tang':
                $query->orderBy('gia', 'ASC'); break;
            case 'gia-giam':
                $query->orderBy('gia', 'DESC'); break;
            case 'ten':
                $query->orderBy('ten', 'ASC'); break;
            default:
                $query->orderBy('ngaytao', 'DESC');
        }

        $sanphams = $query->paginate(12)->appends($request->query());
        $danhmucs = Category::all(); 

        return view('pages.products', compact('sanphams', 'danhmucs'));
    }

    /**
     * Trang chi tiết 1 sản phẩm
     */
    public function detail($slug)
    {
        // Tìm sản phẩm theo đường dẫn (slug) và phải đang hiển thị
        $product = Product::with(['images', 'category', 'reviews.user'])
                          ->where('duongdan', $slug)
                          ->where('trangthai', 1)
                          ->firstOrFail();

        // Lấy các sản phẩm liên quan (Cùng danh mục, trừ sản phẩm hiện tại)
        $relatedProducts = Product::with('images')
                                  ->where('danhmucID', $product->danhmucID)
                                  ->where('id', '!=', $product->id)
                                  ->where('trangthai', 1)
                                  ->take(4)
                                  ->get();

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}