@include('layouts.header')

<section id="purchase-history" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Lịch sử mua hàng</h1>
            </div>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#DH001</td>
                                <td>15/04/2026</td>
                                <td>Áo thun bé trai (1)</td>
                                <td>189.000₫</td>
                                <td><span class="badge bg-success">Đã giao</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                            </tr>
                            <tr>
                                <td>#DH002</td>
                                <td>12/04/2026</td>
                                <td>Váy công chúa bé gái (1)</td>
                                <td>299.000₫</td>
                                <td><span class="badge bg-success">Đã giao</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                            </tr>
                            <tr>
                                <td>#DH003</td>
                                <td>10/04/2026</td>
                                <td>Bộ thun năng động (2), Áo khoác phong cách (1)</td>
                                <td>648.000₫</td>
                                <td><span class="badge bg-primary">Đang giao</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                            </tr>
                            <tr>
                                <td>#DH004</td>
                                <td>08/04/2026</td>
                                <td>Áo thun bé trai (3)</td>
                                <td>567.000₫</td>
                                <td><span class="badge bg-success">Đã giao</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có đơn hàng nào? <a href="{{ route('products') }}" class="text-primary">Mua
                        sắm ngay</a></p>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')