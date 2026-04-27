<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ==========================================
    // PHẦN DÀNH CHO ADMIN
    // ==========================================

    /**
     * Hiển thị danh sách danh mục
     */
    public function index(Request $request)
    {
        // Lấy danh sách, kèm theo số lượng sản phẩm bên trong mỗi danh mục
        // 1. Khởi tạo câu truy vấn gốc (Lấy danh sách kèm số lượng sản phẩm)
    $query = Category::withCount('products');

    // 2. Nếu có từ khóa tìm kiếm được gửi lên thì mới lọc
    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;
        // Tìm những danh mục có tên chứa từ khóa
        $query->where('ten', 'like', '%' . $keyword . '%');
    }

    // 3. Sắp xếp, phân trang và THÊM withQueryString() để giữ từ khóa khi sang trang 2, 3...
    $categories = $query->orderBy('ngaytao', 'desc')->paginate(10)->withQueryString();

    return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form Thêm mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Xử lý Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255|unique:danhmuc,ten',
        ], [
            'ten.required' => 'Vui lòng nhập tên danh mục.',
            'ten.unique' => 'Tên danh mục này đã tồn tại.'
        ]);

        Category::create([
            'ten' => $request->ten,
            // Tự động sinh đường dẫn (slug) từ tên
            'duongdan' => Str::slug($request->ten),
        ]);

        return redirect()->route('categories.index')->with('thongbao', 'Thêm danh mục thành công!');
    }

    /**
     * Hiển thị form Sửa danh mục
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Xử lý Cập nhật danh mục
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            // Bỏ qua kiểm tra unique cho chính danh mục đang sửa
            'ten' => 'required|string|max:255|unique:danhmuc,ten,' . $category->id,
        ], [
            'ten.required' => 'Vui lòng nhập tên danh mục.',
            'ten.unique' => 'Tên danh mục này đã tồn tại.'
        ]);

        $category->update([
            'ten' => $request->ten,
            'duongdan' => Str::slug($request->ten),
        ]);

        return redirect()->route('categories.index')->with('thongbao', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xử lý Xóa danh mục
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // KIỂM TRA RÀNG BUỘC: Nếu có sản phẩm thì KHÔNG ĐƯỢC XÓA
        if ($category->products()->count() > 0) {
            return back()->withErrors(['error' => 'Không thể xóa danh mục đang có sản phẩm.']);
        }

        // Thỏa mãn điều kiện (danh mục rỗng) -> Xóa
        $category->delete();

        return redirect()->route('categories.index')->with('thongbao', 'Xóa danh mục thành công!');
    }
}