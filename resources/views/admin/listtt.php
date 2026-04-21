<?php
include "includes/header.php";
?>
<!-- <div>
    <h2>Danh sách thương hiệu </h2>
</div> -->
<!-- DataTales Example -->
  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Tóm tắt</th>
                                            <th>Mô tả </th>
                                            <th>Hình ảnh</th>
                                            <th>Danh mục tin tức</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Tóm tắt</th>
                                            <th>Mô tả </th>
                                            <th>Hình ảnh</th>
                                            <th>Danh mục tin tức</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </tfoot>
                                   <tbody>
                                   <?php
                                        include "../connect/connect.php";
                                        $sql="SELECT * FROM tintuc ORDER BY id";
                                        $result=mysqli_query($conn, $sql);
                                        $stt=0;
                                        if($result->num_rows>0){
                                        while($row=$result->fetch_assoc()){
                                            $stt++;
                                     ?>
                                     <tr>
                                       <td><?=$stt?></td>
                                       <td><?=$row['tieude']?></td>
                                       <td><?=$row['tomtat']?></td>
                                       <td><?=$row['mota']?></td>
                                       <td><img src="../images/<?=$row['hinhanhtt']?>" alt="" height="100px" width="150px"></td>
                                       <td><?=$row['danhmuctintuc']?></td>
                                       <td>
                                        <a href="formsuatt.php?id=<?=$row['id']?>"><button type="button" class="btn btn-secondary">Sửa</button></a>
                                        <button type="button" class="btn btn-danger" onclick="xoa(<?=$row['id']?>)">Xóa</button>
                                       </td>
                                    </tr>
                                    <?php
                                      }
                                    }
                                     mysqli_close($conn);
                                       ?> 
                                   </tbody>
                                </table>
                                <script type="text/javascript">
                                    function xoa(id){
                                      var lt=confirm("Bạn có chắc muốn xóa sản phẩm này không?");
                                      if(lt){
                                        window.location.href='xoatt.php?id='+id;
                                      } 
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
<?php
include "includes/footer.php";
?>