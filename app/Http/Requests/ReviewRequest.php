<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\OrderItem;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Chỉ cho phép người dùng đã đăng nhập
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'sanphamID' => 'required|exists:sanpham,id',
            'sosao' => 'required|integer|min:1|max:5',
            'binhluan' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'sosao.required' => 'Vui lòng chọn số sao.',
            'binhluan.required' => 'Vui lòng nhập nội dung đánh giá.',
        ];
    }

    /**
     * BỘ LỌC NGHIỆP VỤ CAO CẤP: Kiểm tra mua hàng và đánh giá trùng
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = Auth::id();
            $productId = $this->input('sanphamID');

            // 1. Kiểm tra xem khách đã mua và nhận hàng thành công chưa (trangthaidon = 2)
            $hasPurchased = OrderItem::where('sanphamID', $productId)
                ->whereHas('order', function ($query) use ($userId) {
                    $query->where('nguoidungID', $userId)
                          ->where('trangthaidon', 2); // 2: Hoàn tất
                })->exists();

            if (!$hasPurchased) {
                $validator->errors()->add('binhluan', 'Bạn phải mua và nhận sản phẩm này thành công mới được đánh giá!');
            }

            // 2. Kiểm tra xem khách đã từng đánh giá sản phẩm này chưa
            $alreadyReviewed = Review::where('nguoidungID', $userId)
                ->where('sanphamID', $productId)
                ->exists();

            if ($alreadyReviewed) {
                $validator->errors()->add('binhluan', 'Bạn đã gửi đánh giá cho sản phẩm này rồi. Xin cảm ơn!');
            }
        });
    }
}