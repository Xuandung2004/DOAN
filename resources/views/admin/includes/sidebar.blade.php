<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KAIRA <sup>07</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Quản lý Cửa hàng</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
            aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-store-alt"></i>
            <span>Danh mục </span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý Danh mục:</h6>
                <a class="collapse-item" href="{{ route('categories.index') }}">Danh sách Danh mục</a>
                <a class="collapse-item" href="{{ route('categories.create') }}">Thêm mới Danh mục</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
            aria-expanded="true" aria-controls="collapseProducts">
            <i class="fab fa-product-hunt"></i>
            <span>Sản phẩm</span>
        </a>
        <div id="collapseProducts" class="collapse" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý Sản phẩm:</h6>
                <a class="collapse-item" href="{{ route('products.index') }}">Danh sách Sản phẩm</a>
                <a class="collapse-item" href="{{ route('products.create') }}">Thêm mới Sản phẩm</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.orders.index') }}">
            <i class="fas fa-wallet"></i>
            <span>Đơn hàng</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupons"
            aria-expanded="true" aria-controls="collapseCoupons">
            <i class="fas fa-ticket-alt"></i>
            <span>Mã giảm giá</span>
        </a>
        <div id="collapseCoupons" class="collapse" aria-labelledby="headingCoupons" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý Mã giảm giá:</h6>
                <a class="collapse-item" href="{{ route('coupons.index') }}">Danh sách Mã</a>
                <a class="collapse-item" href="{{ route('coupons.create') }}">Thêm Mã mới</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.reviews.index') }}">
            <i class="fas fa-comments"></i>
            <span>Đánh giá</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.chat') }}">
            <i class="fas fa-fw fa-headset"></i>
            <span class="font-weight-bold text-warning">Hỗ trợ Chat</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true"
            aria-controls="collapseUsers">
            <i class="fas fa-users"></i>
            <span>Người dùng</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý Tài khoản:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">Danh sách Người dùng</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Thêm Người dùng</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>