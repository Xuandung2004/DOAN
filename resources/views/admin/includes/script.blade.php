<script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('admin_assets/vendor/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('admin_assets/js/demo/chart-pie-demo.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin_assets/js/dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Khởi tạo DataTables cho bảng có id="dataTable"
        if ($('#dataTable').length) {
            let table = new DataTable('#dataTable');
        }
    });
</script>