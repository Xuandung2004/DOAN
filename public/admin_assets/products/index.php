<?php include __DIR__ . "/../includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Thông báo Flash Message -->
    <?php if(isset($_SESSION['thongbao'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?php echo $_SESSION['thongbao']; unset($_SESSION['thongbao']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-box mr-2"></i> Quản lý Sản phẩm
        </h1>
        <a href="products_add.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Thêm sản phẩm
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 5%">STT</th>
                            <th style="width: 25%">Tên sản phẩm</th>
                            <th style="width: 15%">Danh mục</th>
                            <th style="width: 12%">Giá</th>
                            <th style="width: 12%">Số lượng</th>
                            <th style="width: 10%">Trạng thái</th>
                            <th style="width: 21%">Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        // Mock data - Thay thế bằng dữ liệu thực từ database
                        $sanphams = array(
                            array(
                                'id' => 1,
                                'ten' => 'Sản phẩm A',
                                'danhmuc' => 'Danh mục 1',
                                'gia' => 100000,
                                'soluong' => 50,
                                'trangthai' => 1
                            ),
                            array(
                                'id' => 2,
                                'ten' => 'Sản phẩm B',
                                'danhmuc' => 'Danh mục 2',
                                'gia' => 200000,
                                'soluong' => 30,
                                'trangthai' => 1
                            ),
                            array(
                                'id' => 3,
                                'ten' => 'Sản phẩm C',
                                'danhmuc' => 'Danh mục 1',
                                'gia' => 150000,
                                'soluong' => 0,
                                'trangthai' => 0
                            ),
                        );
                        
                        $stt = 0;
                        foreach($sanphams as $sp):
                            $stt++;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $stt; ?></td>
                            <td>
                                <strong><?php echo $sp['ten']; ?></strong>
                            </td>
                            <td>
                                <span class="badge badge-primary"><?php echo $sp['danhmuc']; ?></span>
                            </td>
                            <td class="text-right">
                                <strong class="text-primary"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo $sp['soluong']; ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($sp['trangthai'] == 1): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>Hiển thị
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-times mr-1"></i>Ẩn
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="products_edit.php?id=<?php echo $sp['id']; ?>" class="btn btn-sm btn-warning" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" title="Xóa" onclick="confirmDelete(<?php echo $sp['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?\n(Sản phẩm sẽ chuyển sang trạng thái ẩn)')) {
            window.location.href = 'products_delete.php?id=' + id;
        }
    }
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
