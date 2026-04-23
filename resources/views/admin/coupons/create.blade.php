@extends('admin.includes.master')

@section('title', 'Thêm Mã giảm giá')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Mã giảm giá</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-body p-5">
                    <form action="{{ route('coupons.store') }}" method="POST">
                        @csrf

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Mã: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-uppercase @error('ma') is-invalid @enderror"
                                    name="ma" value="{{ old('ma') }}" placeholder="VD: TET2026" required>
                                @error('ma') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Loại mã: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="loai" required>
                                    <option value="phantram" {{ old('loai') == 'phantram' ? 'selected' : '' }}>Giảm theo Phần
                                        trăm (%)</option>
                                    <option value="tienmat" {{ old('loai') == 'tienmat' ? 'selected' : '' }}>Giảm theo Số tiền
                                        (VNĐ)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giá trị: <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('giatri') is-invalid @enderror"
                                    name="giatri" value="{{ old('giatri') }}" min="0" step="0.01" required>
                                @error('giatri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giá tối thiểu:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="giatridontoithieu"
                                    value="{{ old('giatridontoithieu', 0) }}" min="0">
                                <small class="text-muted">Đơn hàng phải đạt mức này mới được dùng mã.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Giới hạn sử dụng:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="gioihansudung"
                                    value="{{ old('gioihansudung') }}" min="1">
                                <small class="text-muted">Tổng số lượt mã này có thể được dùng. Bỏ trống nếu không giới
                                    hạn.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-sm-3 col-form-label font-weight-bold text-right">Thời hạn:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('hethan') is-invalid @enderror" name="hethan"
                                    value="{{ old('hethan') }}">
                                @error('hethan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm">Thêm</button>
                            <a href="{{ route('coupons.index') }}" class="btn btn-light px-5 py-2 border shadow-sm ml-3">Hủy
                                bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection