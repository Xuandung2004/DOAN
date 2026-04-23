@extends('admin.includes.master')

@section('title', 'Sửa Mã giảm giá')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sửa Mã giảm giá</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-body p-5">
                    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Mã: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-uppercase @error('ma') is-invalid @enderror"
                                    name="ma" value="{{ old('ma', $coupon->ma) }}" required>
                                @error('ma') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Loại mã: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="loai" required>
                                    <option value="phantram" {{ old('loai', $coupon->loai) == 'phantram' ? 'selected' : '' }}>
                                        Giảm theo Phần trăm (%)</option>
                                    <option value="tienmat" {{ old('loai', $coupon->loai) == 'tienmat' ? 'selected' : '' }}>
                                        Giảm theo Số tiền (VNĐ)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giá trị: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('giatri') is-invalid @enderror"
                                    name="giatri" value="{{ old('giatri', (int) $coupon->giatri) }}" min="0" step="0.01"
                                    required>
                                @error('giatri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giá tối thiểu:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="giatridontoithieu"
                                    value="{{ old('giatridontoithieu', (int) $coupon->giatridontoithieu) }}" min="0">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giới hạn sử dụng:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="gioihansudung"
                                    value="{{ old('gioihansudung', $coupon->gioihansudung) }}" min="1">
                                <small class="text-muted">Hiện tại đã có <strong
                                        class="text-danger">{{ $coupon->dasudung }}</strong> lượt sử dụng.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Thời hạn:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('hethan') is-invalid @enderror" name="hethan"
                                    value="{{ old('hethan', $coupon->hethan ? \Carbon\Carbon::parse($coupon->hethan)->format('Y-m-d') : '') }}">
                                @error('hethan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm">Lưu</button>
                            <a href="{{ route('coupons.index') }}" class="btn btn-light px-5 py-2 border shadow-sm ml-3">Hủy
                                bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection