@extends('admin.includes.master')

@section('title', 'Quản lý Đánh giá')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Đánh giá Khách hàng</h1>
    </div>

    @if(session('thongbao'))
        <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('thongbao') }}
        </div>
    @endif

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="15%">Người dùng</th>
                            <th width="20%">Sản phẩm</th>
                            <th width="15%">Số sao</th>
                            <th width="35%">Bình luận</th>
                            <th width="10%">Thời gian</th>
                            <th width="5%">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td><strong>{{ $review->user->hoten ?? 'Khách ẩn danh' }}</strong></td>
                                <td><a href="{{ route('product.detail', $review->product->duongdan) }}" target="_blank"
                                        class="text-primary font-weight-bold">{{ $review->product->ten }}</a></td>
                                <td class="text-center text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->sosao)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </td>
                                <td>{{ $review->binhluan }}</td>
                                <td class="text-center text-muted small">
                                    {{ \Carbon\Carbon::parse($review->ngaytao)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không? Mọi điểm trung bình sẽ được tính toán lại.');"
                                            title="Xóa đánh giá vi phạm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có đánh giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-right">
                {{ $reviews->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection