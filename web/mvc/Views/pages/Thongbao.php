<!-- Thêm modal "Thêm thông báo" -->
<div class="modal fade" id="modalAddThongBao" tabindex="-1" role="dialog" aria-labelledby="modalAddThongBaoLabel" aria-hidden="true">
    <!-- Nội dung của modal "Thêm thông báo" -->
</div>
<!-- Thêm modal "Sửa thông báo" -->
<div class="modal fade" id="modalEditThongBao" tabindex="-1" role="dialog" aria-labelledby="modalEditThongBaoLabel" aria-hidden="true">
    <!-- Nội dung của modal "Sửa thông báo" -->
</div>
<!-- <?php
print_r($lophoc); 
?> -->
<div class="container-thongbao">
    <h1>Quản lý Thông báo</h1>
      <!-- Button "Thêm thông báo" -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
Thêm thông báo
</button>
    <table class="table-thongbao">
        <tr>
            <th>ID</th>
            <th>Loại</th>
            <th>Nội dung</th>
            <th>Thời gian thi</th>
            <th>Thời gian bắt đầu thi</th>
            <th>Ngày thi</th>
            <th>Thời gian vào thi</th>
            <th>ID Đề thi</th>
            <th>Thao tác</th> <!-- Thêm cột cho các nút sửa xóa -->
        </tr>
        <?php foreach ($thongbao as $row): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['Loai']; ?></td>
                <td><?php echo $row['Noi_dung']; ?></td>
                <td><?php echo $row['Thoi_gian_thi']; ?></td>
                <td><?php echo $row['Thoi_gian_bat_dau_thi']; ?></td>
                <td><?php echo $row['Ngay_thi']; ?></td>         
                <td><?php echo $row['Thoi_gian_vao_thi']; ?></td>
                <td><?php echo $row['ID_DeThi']; ?></td>
                <td>
                <button onclick="confirmDelete(<?php echo $row['ID']; ?>,'<?php echo $row['Thoi_gian_bat_dau_thi']; ?>')" class="delete-btn">Delete</button>
                    <button type="button" class="btn-edit" data-toggle="modal" data-target="#modalEditThongBao<?php echo $row['ID']; ?>">Sửa</button>
                    <button type="button" class="btn-open-modal" data-toggle="modal" data-target="#exampleModal<?php echo $row['ID']; ?>">
                        Chi tiết
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<!-- Modal chi tiết-->
<?php foreach ($thongbao as $row): ?>
    <div class="modal fade" id="exampleModal<?php echo $row['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo $row['ID']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel<?php echo $row['ID']; ?>">Chi tiết thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nội dung modal -->
                    <p>ID: <?php echo $row['ID']; ?></p>
                    <p>Loại: <?php echo $row['Loai']; ?></p>
                    <p>Nội dung: <?php echo $row['Noi_dung']; ?></p>
                    <p>Thời gian thi: <?php echo $row['Thoi_gian_thi']; ?></p>
                    <p>Thời gian bắt đầu thi: <?php echo $row['Thoi_gian_bat_dau_thi']; ?></p>
                    <p>Ngày thi: <?php echo $row['Ngay_thi']; ?></p>
                    <p>Thời gian vào thi: <?php echo $row['Thoi_gian_vao_thi']; ?></p>
                    <p>ID_DeThi: <?php echo $row['ID_DeThi']; ?></p>
                    
                    <!-- Thêm các thông tin khác của thông báo vào đây -->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thêm thông báo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form action="./ThongbaoController/add" method="POST" id="addThongBaoForm">
          <div class="form-group">
            <label for="loai">Loại:</label>
            <input type="text" class="form-control" id="loai" name="loai" required>
          </div>
          <div class="form-group">
            <label for="noi_dung">Nội dung:</label>
            <textarea class="form-control" id="noi_dung" name="noi_dung" rows="4" required></textarea>
          </div>
          <div class="form-group">
            <label for="thoi_gian_thi">Thời gian thi:</label>
            <input type="time" class="form-control" id="thoi_gian_thi" name="thoi_gian_thi" required>
          </div>
          <div class="form-group">
            <label for="thoi_gian_bat_dau_thi">Thời gian bắt đầu thi:</label>
            <input type="time" class="form-control" id="thoi_gian_bat_dau_thi" name="thoi_gian_bat_dau_thi" required>
          </div>
          <div class="form-group">
            <label for="ngay_thi">Ngày thi:</label>
            <input type="date" class="form-control" id="ngay_thi" name="ngay_thi" required>
          </div>
          <div class="form-group">
            <label for="thoi_gian_vao_thi">Thời gian vào thi:</label>
            <input type="time" class="form-control" id="thoi_gian_vao_thi" name="thoi_gian_vao_thi">
          </div>
          <div class="form-group">
            <label for="ten_mon_hoc">Môn học:</label>
            <select class="form-control" id="ten_mon_hoc" name="ten_mon_hoc" required>
            <option value=""></option>
            <?php foreach ($monhoc as $mh): ?>
        <option value="<?php echo $mh['ID']; ?>"><?php echo $mh['Ten']; ?></option>
    <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="id_de_thi">ID Đề thi:</label>
            <select class="form-control" id="id_de_thi" name="id_de_thi" required>
            
            </select>
          </div>
          <div class="form-group" id="lop_hoc_checkbox">
    
</div>
<input type="hidden" id="selectedValues" name="selectedValues" value="">
          <div class="modal-footer">
        <button type="submit" class="btn  btn-danger" id="add-btn">Tạo Thông báo</button>
      </div>
        </form>
        
      </div>
      <!-- Modal footer -->
      
    </div>
  </div>
</div>

<!-- Thêm modal "Sửa thông báo" -->
<!-- Modal Sửa thông báo -->
<?php foreach ($thongbao as $row): ?>
    <div class="modal fade" id="modalEditThongBao<?php echo $row['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditThongBaoLabel<?php echo $row['ID']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditThongBaoLabel<?php echo $row['ID']; ?>">Sửa thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="./ThongbaoController/update/<?php echo $row['ID']; ?>" method="POST" id="editThongbaoForm<?php echo $row['ID']; ?>">
          <div class="form-group">
            <label for="loai">Loại:</label>
            <input type="text" class="form-control" id="edit_loai<?php echo $row['ID']; ?>" name="edit_loai<?php echo $row['ID']; ?>" value="<?php echo $row['Loai']; ?>" >
          </div>
          <div class="form-group">
            <label for="noi_dung">Nội dung:</label>
            <textarea class="form-control" id="edit_noi_dung<?php echo $row['ID']; ?>" name="edit_noi_dung<?php echo $row['ID']; ?>" rows="4" require><?php echo $row['Noi_dung']; ?></textarea>

          </div>
          <div class="form-group">
            <label for="thoi_gian_thi">Thời gian thi:</label>
            <input type="time" class="form-control" id="edit_thoi_gian_thi<?php echo $row['ID']; ?>" name="edit_thoi_gian_thi<?php echo $row['ID']; ?>" value="<?php echo $row['Thoi_gian_thi']; ?>" >
          </div>
          <div class="form-group">
            <label for="thoi_gian_bat_dau_thi">Thời gian bắt đầu thi:</label>
            <input type="time" class="form-control" id="edit_thoi_gian_bat_dau_thi<?php echo $row['ID']; ?>" name="edit_thoi_gian_bat_dau_thi<?php echo $row['ID']; ?>" value="<?php echo $row['Thoi_gian_bat_dau_thi']; ?>">
          </div>
          <div class="form-group">
            <label for="ngay_thi">Ngày thi:</label>
            <input type="date" class="form-control" id="edit_ngay_thi<?php echo $row['ID']; ?>" name="edit_ngay_thi<?php echo $row['ID']; ?>" value="<?php echo $row['Ngay_thi']; ?>">
          </div>
          <div class="form-group">
            <label for="thoi_gian_vao_thi">Thời gian vào thi:</label>
            <input type="time" class="form-control" id="edit_thoi_gian_vao_thi<?php echo $row['ID']; ?>" name="edit_thoi_gian_vao_thi<?php echo $row['ID']; ?>" value="<?php echo $row['Thoi_gian_vao_thi']; ?>">
          </div>
  
          <div class="form-group">
            <label for="ten_mon_hoc">Môn học:</label>
            <select class="form-control" id="edit_ten_mon_hoc<?php echo $row['ID']; ?>" name="edit_ten_mon_hoc<?php echo $row['ID']; ?>">
    <?php foreach ($monhoc as $mh): ?>
        <option value="<?php echo $mh['ID']; ?>"><?php echo $mh['Ten']; ?></option>
    <?php endforeach; ?>
</select>
          </div>
          <div class="form-group">
            <label for="id_de_thi">ID Đề thi:</label>
            <select class="form-control" id="edit_id_de_thi<?php echo $row['ID']; ?>" name="edit_id_de_thi<?php echo $row['ID']; ?>">
            
            </select>
          </div>
          <div class="form-group" id="edit_lop_hoc_checkbox<?php echo $row['ID']; ?>">
    
    </div>
<script>
$(document).ready(function(){
    var ID_DeThi = parseInt(<?php echo $row['ID_DeThi']; ?>);
    console.log(ID_DeThi)
    $.ajax({
        url: './ThongbaoController/getMonHocByID_DeThi/' + ID_DeThi,
        type: 'POST',
        dataType: 'json',
        success: function(data) {
          var selectElement = document.getElementById('edit_ten_mon_hoc<?php echo $row['ID']; ?>');
          selectElement.value=data[0]['ID']
          $.ajax({
            url: './GetDeThiByMHController/getDeThiByMonHoc/'+data[0]['ID'],
            type: 'POST',
            dataType: 'json',
            success: function(data){
              $('#edit_id_de_thi<?php echo $row['ID']; ?>').append('<option value=""></option>');
              console.log(data)
          // Duyệt qua mỗi đối tượng trong mảng data và thêm vào combobox
          $.each(data, function(index, deThi){
            var option = $('<option value="' + deThi.ID + '">ID: ' + deThi.ID + '</option>');       
                // Kiểm tra xem ID_DeThi có bằng ID của đối tượng không
                if (ID_DeThi == deThi.ID) {
                    option.prop('selected', true); // Chọn tùy chọn này nếu khớp
                }
                
                $('#edit_id_de_thi<?php echo $row['ID']; ?>').append(option);          });
                      }
        });
        $.ajax({
        url: './GetClassByMonHocAndGVController/getClassByMonHocAndByGV/'+data[0]['ID']+'/'+<?php echo $user_id;?>,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          console.log("class");
          console.log(data)
          $('#edit_lop_hoc_checkbox<?php echo $row['ID']; ?>').empty();
            // Duyệt qua mỗi đối tượng trong mảng data và thêm vào combobox
            $.each(data, function(index, lop) {
              console.log(lop.Ten)
    var checkbox = $('<div class="form-check"></div>');
    var input = $('<input class="form-check-input" type="checkbox" name="class[]" value="' + lop.ID + '">');
    var label = $('<label class="form-check-label">' + lop.Ten+ + '</label>');
   
    $.ajax({
            url: './ThongbaoController/KtraThongBao/'+parseInt(ID_DeThi)+'/'+parseInt(lop.ID),
            type: 'POST',
            dataType: 'json',
            success: function(data){
              console.log(data)
            
              if(data.length>0)
              {
                for (var i = 0; i < data.length; i++) {
                // Lấy phần tử thứ i từ mảng
                var item = data[i];
                var id = <?php echo $row['ID']; ?>;
                if(item.ID==id)
                {
                  var label = $('<label class="form-check-label">' + lop.Ten + '</label>');
                input.prop('checked', true);
                checkbox.append(input).append(label);
                }
                else
                {
                  var label = $('<label class="form-check-label">' + lop.Ten+'(Không được chọn đã tồn tại thông báo)' + '</label>');
                input.prop('checked', true).prop('disabled', true);
                checkbox.append(input).append(label);
                }
                
                // Thực hiện các thao tác bạn muốn với mỗi phần tử ở đây
                console.log("ID:", item.ID);
                console.log("Loai:", item.Loai);
                console.log("Noi dung:", item.Noi_dung);
                console.log("Thoi gian thi:", item.Thoi_gian_thi);
                console.log("Thoi gian bat dau thi:", item.Thoi_gian_bat_dau_thi);
                // Thêm các thao tác khác nếu cần
                }
                
              }
              else{
                var label = $('<label class="form-check-label">' + lop.Ten + '</label>');
                checkbox.append(input).append(label);
              }  
                      }               
        });
        
    $('#edit_lop_hoc_checkbox<?php echo $row['ID']; ?>').append(checkbox);
});
        }
    });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Xử lý lỗi nếu có
        }
    });
  
});
</script>

<input type="hidden" id="edit_selectedValues<?php echo $row['ID']; ?>" name="edit_selectedValues<?php echo $row['ID']; ?>" value="">
          <div class="modal-footer">
        <button type="submit" class="btn  btn-danger">Sửa</button>
      </div>
        </form>                    
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
$(document).ready(function(){
    // Sự kiện khi combobox môn học thay đổi
    $('#ten_mon_hoc').change(function(){
      $('#lop_hoc_checkbox').empty();
        var monHocId = $(this).val(); // Lấy giá trị ID của môn học được chọn
        var monHocElement = document.getElementById('ten_mon_hoc');
        var selectedMonHocId = monHocElement.value;
        console.log('ID của môn học đã chọn:', monHocId); // In ra giá trị ID của môn học đã chọn
        $.ajax({
            url: './GetDeThiByMHController/getDeThiByMonHoc/'+monHocId,
            type: 'POST',
            dataType: 'json',
            success: function(data){
              $('#id_de_thi').empty();
              $('#id_de_thi').append('<option value=""></option>');
          // Duyệt qua mỗi đối tượng trong mảng data và thêm vào combobox
          $.each(data, function(index, deThi){
              $('#id_de_thi').append('<option value="' + deThi.ID + '">ID: ' + deThi.ID + '</option>');
          });
                      }
        });
    });
    // Sự kiện khi combobox id_de_thi thay đổi
$('#id_de_thi').change(function(){
    var deThiId = $(this).val(); // Lấy giá trị ID của đề thi được chọn
    var monHocElement = document.getElementById('ten_mon_hoc');
    var monHocId = parseInt(monHocElement.value);
    $.ajax({
        url: './GetClassByMonHocAndGVController/getClassByMonHocAndByGV/'+monHocId+'/'+<?php echo $user_id;?>,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          $('#lop_hoc_checkbox').empty();
            // Duyệt qua mỗi đối tượng trong mảng data và thêm vào combobox
            $.each(data, function(index, lop) {
    var checkbox = $('<div class="form-check"></div>');
    var input = $('<input class="form-check-input" type="checkbox" name="class[]" value="' + lop.ID + '">');
    $.ajax({
            url: './ThongbaoController/KtraThongBao/'+parseInt(deThiId)+'/'+parseInt(lop.ID),
            type: 'POST',
            dataType: 'json',
            success: function(data){
              if(data.length>0)
              {
                
                var label = $('<label class="form-check-label">' + lop.Ten+' (Đã có)' + '</label>');
                input.prop('checked', true).prop('disabled', true);
                checkbox.append(input).append(label);
              }
              else{
                var label = $('<label class="form-check-label">' + lop.Ten + '</label>');
                checkbox.append(input).append(label);
              }
                      }
        });
    $('#lop_hoc_checkbox').append(checkbox);
});
        }
    });
});
<?php foreach ($thongbao as $row): ?>
    // Sự kiện onchange cho combobox môn học
    $('#edit_ten_mon_hoc<?php echo $row['ID']; ?>').change(function(){

        var monHocId = $(this).val();
        console.log('ID của môn học đã chọn:', monHocId);
        $('#edit_lop_hoc_checkbox<?php echo $row['ID']; ?>').empty();
        var monHocId = $(this).val(); // Lấy giá trị ID của môn học được chọn
        var monHocElement = document.getElementById('edit_ten_mon_hoc<?php echo $row['ID']; ?>');
        var selectedMonHocId = monHocElement.value;
        console.log('ID của môn học đã chọn:', monHocId); // In ra giá trị ID của môn học đã chọn
        $.ajax({
            url: './GetDeThiByMHController/getDeThiByMonHoc/'+monHocId,
            type: 'POST',
            dataType: 'json',
            success: function(data){
              $('#edit_id_de_thi<?php echo $row['ID']; ?>').empty();
              $('#edit_id_de_thi<?php echo $row['ID']; ?>').append('<option value=""></option>');
          // Duyệt qua mỗi đối tượng trong mảng data và thêm vào combobox
          $.each(data, function(index, deThi){
              $('#edit_id_de_thi<?php echo $row['ID']; ?>').append('<option value="' + deThi.ID + '">ID: ' + deThi.ID + '</option>');
          });
                      }
        });
        // Thực hiện các hành động cần thiết dựa trên sự thay đổi của combobox môn học
    });

    $('#edit_id_de_thi<?php echo $row['ID']; ?>').change(function(){
        var deThiId = $(this).val();
        var monHocElement = document.getElementById('edit_ten_mon_hoc<?php echo $row['ID']; ?>');
        var monHocId = parseInt(monHocElement.value);
        console.log('ID của đề thi đã chọn:', deThiId);
        var deThiId = $(this).val(); 
    $.ajax({
        url: './GetClassByMonHocAndGVController/getClassByMonHocAndByGV/'+monHocId+'/'+<?php echo $user_id;?>,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          $('#edit_lop_hoc_checkbox<?php echo $row['ID']; ?>').empty();
            $.each(data, function(index, lop) {
    var checkbox = $('<div class="form-check"></div>');
    var input = $('<input class="form-check-input" type="checkbox" name="class[]" value="' + lop.ID + '">');
    $.ajax({
            url: './ThongbaoController/KtraThongBao/'+parseInt(deThiId)+'/'+parseInt(lop.ID),
            type: 'POST',
            dataType: 'json',
            success: function(data){
              if(data.length>0)
              {
                for (var i = 0; i < data.length; i++) {
                // Lấy phần tử thứ i từ mảng
                var item = data[i];
                var id = <?php echo $row['ID']; ?>;
                if(item.ID==id)
                {
                  var label = $('<label class="form-check-label">' + lop.Ten + '</label>');
                input.prop('checked', true);
                checkbox.append(input).append(label);
                }
                else
                {
                  var label = $('<label class="form-check-label">' + lop.Ten+'(Không được chọn đã tồn tại thông báo)' + '</label>');
                input.prop('checked', true).prop('disabled', true);
                checkbox.append(input).append(label);
                }
                
                // Thực hiện các thao tác bạn muốn với mỗi phần tử ở đây
                console.log("ID:", item.ID);
                console.log("Loai:", item.Loai);
                console.log("Noi dung:", item.Noi_dung);
                console.log("Thoi gian thi:", item.Thoi_gian_thi);
                console.log("Thoi gian bat dau thi:", item.Thoi_gian_bat_dau_thi);
                // Thêm các thao tác khác nếu cần
                }
              }
              else{
                var label = $('<label class="form-check-label">' + lop.Ten + '</label>');
                checkbox.append(input).append(label);
              }
                      }
        });
    $('#edit_lop_hoc_checkbox<?php echo $row['ID']; ?>').append(checkbox);
});
        }
    });
        // Thực hiện các hành động cần thiết dựa trên sự thay đổi của combobox id_de_thi
    });
    <?php endforeach; ?>
    <?php foreach ($thongbao as $row): ?>
    $('#modalEditThongBao<?php echo $row['ID']; ?>').on('show.bs.modal', function (event) {
        // Lấy ngày thi và thời gian bắt đầu thi từ dữ liệu hiện có của thông báo
        console.log('111111');
     
        var ngayThi = new Date("<?php echo $row['Ngay_thi']; ?>");
        var thoiGianBatDauThiParts = "<?php echo $row['Thoi_gian_bat_dau_thi']; ?>".split(":");
        var gioBatDauThi = new Date();
        gioBatDauThi.setHours(parseInt(thoiGianBatDauThiParts[0], 10));
        gioBatDauThi.setMinutes(parseInt(thoiGianBatDauThiParts[1], 10));

        // Lấy thời gian hiện tại
        var ngayHienTai = new Date();

        // Kiểm tra nếu ngày thi hoặc thời gian bắt đầu thi nhỏ hơn thời gian hiện tại
        if (ngayThi < ngayHienTai || (ngayThi.toDateString() === ngayHienTai.toDateString() && gioBatDauThi.getHours() < ngayHienTai.getHours()) || (ngayThi.toDateString() === ngayHienTai.toDateString() && gioBatDauThi.getHours() === ngayHienTai.getHours() && gioBatDauThi.getMinutes() < ngayHienTai.getMinutes())) {
            // Ngăn chặn hiển thị modal và hiển thị thông báo lỗi
            alert("Không thể sửa thông báo với ngày thi hoặc thời gian bắt đầu thi nhỏ hơn thời gian hiện tại.");
            event.preventDefault();
            
            return;
        }
    });
    $('#editThongbaoForm<?php echo $row['ID']; ?>').submit(function(event) {
        var editcheckboxesSelected = document.querySelectorAll("#edit_lop_hoc_checkbox<?php echo $row['ID']; ?> input[type='checkbox']:checked:not(:disabled)");
        var monHocId = $('#edit_ten_mon_hoc<?php echo $row['ID']; ?>').val();
            var deThiId = $('#edit_id_de_thi<?php echo $row['ID']; ?>').val();
            var noidung=$('#edit_noi_dung<?php echo $row['ID']; ?>').val().replace(/\s/g,"").trim();
            var loai=$('#edit_loai<?php echo $row['ID']; ?>').val().replace(/\s/g, "").trim();
            var thoigianthi=$('#edit_thoi_gian_thi<?php echo $row['ID']; ?>').val();
            var thoigianbatdauthi=$('#edit_thoi_gian_bat_dau_thi<?php echo $row['ID']; ?>').val();
            var ngay_thi=$('#edit_ngay_thi<?php echo $row['ID']; ?>').val();
            var thoigianvaothi=$('#edit_thoi_gian_vao_thi<?php echo $row['ID']; ?>').val();
            // Lấy ngày và thời gian hiện tại
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var currentMonth = currentDate.getMonth() + 1; // Tháng bắt đầu từ 0
            var currentDay = currentDate.getDate();
            var currentHour = currentDate.getHours();
            var currentMinute = currentDate.getMinutes();
            var currentSecond = currentDate.getSeconds();
            // Lấy ngày và thời gian từ trường input
            var selectedDate = new Date(ngay_thi);
            var selectedYear = selectedDate.getFullYear();
            var selectedMonth = selectedDate.getMonth() + 1; // Tháng bắt đầu từ 0
            var selectedDay = selectedDate.getDate();
            var selectedHour = parseInt(thoigianbatdauthi.split(":")[0]);
            var selectedMinute = parseInt(thoigianbatdauthi.split(":")[1]);
            var selectedSecond = parseInt(thoigianbatdauthi.split(":")[2]);
            if(loai.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_loai<?php echo $row['ID']; ?>").focus();
              alert('Loại không được để trống');
              return;
            }
            if(noidung.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_noi_dung<?php echo $row['ID']; ?>").focus();
              alert('Nội dung  không được để trống');
              return;
            } 
            if(thoigianthi.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_thoi_gian_thi<?php echo $row['ID']; ?>").focus();
              alert('Thời gian  không được để trống');
              return;
            }
           
            if(thoigianbatdauthi.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_thoi_gian_bat_dau_thi<?php echo $row['ID']; ?>").focus();
              alert('Thời gian bắt đầu thi  không được để trống');
              return;
            }
        
            
            if(ngay_thi.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_ngay_thi<?php echo $row['ID']; ?>").focus();
              alert('Ngày thi không được để trống');
              return;
            }
          
            if(thoigianvaothi.length==0)
            {
              event.preventDefault();
              document.getElementById("edit_thoi_gian_thi<?php echo $row['ID']; ?>").focus();
              alert('Thời gian vào thi  không được để trống');
              return;
            }
            if(monHocId=="")
            {
              event.preventDefault();
              document.getElementById("edit_ten_mon_hoc<?php echo $row['ID']; ?>").focus();
              alert('Môn học  không được để trống');
              return;
            }
            if(deThiId=="")
            {
              event.preventDefault();
              document.getElementById("edit_id_de_thi<?php echo $row['ID']; ?>").focus();
              alert('Đề thi  không được để trống');
              return;
            }
            if(editcheckboxesSelected.length<=0)
            {
              event.preventDefault();
              document.getElementById("edit_lop_hoc_checkbox<?php echo $row['ID']; ?>").focus();
              alert('Lớp học  không được để trống');
              return;
            }
            if (selectedYear < currentYear || 
                    (selectedYear === currentYear && selectedMonth < currentMonth) || 
                    (selectedYear === currentYear && selectedMonth === currentMonth && selectedDay < currentDay)) {
                      event.preventDefault();
                    alert('Ngày thi phải sau ngày hiện tại');
                    document.getElementById("edit_ngay_thi<?php echo $row['ID']; ?>").focus();
                    return;
                }

            // So sánh thời gian nếu cùng ngày
            if (selectedYear === currentYear && selectedMonth === currentMonth && selectedDay === currentDay) {
                if (selectedHour < currentHour || 
                    (selectedHour === currentHour && selectedMinute < currentMinute) ||
                    (selectedHour === currentHour && selectedMinute === currentMinute && selectedSecond < currentSecond)) {
                      event.preventDefault();
                    alert('Thời gian bắt đầu thi phải sau thời gian hiện tại');
                    document.getElementById("edit_thoi_gian_bat_dau_thi<?php echo $row['ID']; ?>").focus();
                    return;
                }
              }
              var selectedValues = [];
              editcheckboxesSelected.forEach(function(checkbox) {
                  selectedValues.push(checkbox.value);
              });
              var selectedValuesInput = document.getElementById("edit_selectedValues<?php echo $row['ID']; ?>");
              selectedValuesInput.value = selectedValues.join(",");
            // In ra các giá trị đã được chọn trong console
            console.log("Môn học đã chọn: " +   selectedValuesInput.value);
            console.log("thoi gian "+editcheckboxesSelected.length);
            console.log("Đề thi đã chọn: " + noidung.length);

        // Gửi dữ liệu đến máy chủ bằng AJAX
        
    });
<?php endforeach; ?>
  
})
document.getElementById("addThongBaoForm").addEventListener("submit", function(event) {
    var ngayThiInput = document.getElementById("ngay_thi").value;
    var ngayThi = new Date(ngayThiInput);
    var ngayHienTai = new Date();
    console.log(ngayThi);
    console.log(ngayHienTai);
    
    var checkboxesSelected = document.querySelectorAll("#lop_hoc_checkbox input[type='checkbox']:checked:not(:disabled)");

    // So sánh ngày thi với ngày hiện tại
    if (ngayThi.toDateString() === ngayHienTai.toDateString()) {
        var gioBatDauThiInput = document.getElementById("thoi_gian_bat_dau_thi").value;
        var gioBatDauThi = new Date();
        var gioBatDauThiParts = gioBatDauThiInput.split(":");
        gioBatDauThi.setHours(parseInt(gioBatDauThiParts[0], 10));
        gioBatDauThi.setMinutes(parseInt(gioBatDauThiParts[1], 10));
        
        // So sánh giờ bắt đầu thi với giờ hiện tại
        if (gioBatDauThi.getHours() < ngayHienTai.getHours() || 
            (gioBatDauThi.getHours() === ngayHienTai.getHours() && gioBatDauThi.getMinutes() < ngayHienTai.getMinutes())) {
            event.preventDefault();
            alert("Giờ bắt đầu thi phải lớn hơn giờ hiện tại nếu ngày thi là ngày hiện tại.");
            document.getElementById("thoi_gian_bat_dau_thi").focus();
            return;
        }
    }

    // Kiểm tra nếu ngày thi nhỏ hơn ngày hiện tại
    if (ngayThi.setHours(0, 0, 0, 0) < ngayHienTai.setHours(0, 0, 0, 0)) {
        event.preventDefault();
        alert("Ngày thi phải lớn hơn hoặc bằng ngày hiện tại.");
        document.getElementById("ngay_thi").focus();
        return;
    }

    // Kiểm tra nếu không có checkbox nào được chọn
    if (checkboxesSelected.length <= 0) {
        event.preventDefault();
        alert("Vui lòng chọn ít nhất một lớp học.");
        return;
    }

    // Nếu tất cả điều kiện đều thỏa mãn, tiếp tục xử lý dữ liệu
    var selectedValues = [];
    checkboxesSelected.forEach(function(checkbox) {
        selectedValues.push(checkbox.value);
    });
    var selectedValuesInput = document.getElementById("selectedValues");
    selectedValuesInput.value = selectedValues.join(",");
});

// Lặp qua từng thông báo để thêm sự kiện cho modal sửa thông báo

function confirmDelete(rowId,thoigianbatdauthi) {
  console.log(rowId)
    if (confirm("Are you sure you want to delete this row?")) {
        window.location.href = "ThongbaoController/deleteThongBao/" + rowId;
    }
}
</script>
<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
 /* CSS cho header */
 .header {
    width: 100%;
    display: flex;
    background-color: white;
    align-items: center;
    height: 10vh;
}
.header #header_left{
    display:flex;
    width: 15%;
    background-color: #3162B9;
    /* justify-content: center; */
    align-items: center;
}
.header #header_left #SGU{
    color: white;
    font-family:Arial;
    margin: 30px 0px 30px 30px;
}
.header #header_left #Quiz{
    margin-left: 5px;
    color: white;
    font-family:Arial;
}
.header #user{
    border-radius: 10px;
    padding: 12px 14px 12px 14px;
    background-color: #e0e0e0;
    margin-left: auto;
    margin-right: 80px;
}
/* CSS cho left menu */
#left_menu {
    width: 15%;
    background-color: #f2f2f2;
    height: 90vh;
    overflow-y: auto; /* Cho phép cuộn nếu nội dung quá dài */
    float: left;
    display: flex;
    flex-direction: column;
    padding: 20px 10px;
}
#left_menu h4{
    color: #878787;
    padding-left: 10px;
    font-family:Arial;
}
#left_menu ul {
    list-style-type: none;
}
#left_menu li{
    margin:0px 5px;
}
#left_menu a{
    margin: 10px 0px;
    border-radius: 5px;
    display: block;
    padding: 10px 20px;
    text-decoration: none;
    color: #878787;
    font-family:Arial;
}

#left_menu a:hover {
    background-color: #cce2fe;
    color: black;
}
/* CSS cho phần detail */
.detail {
    margin-left: 15%; /* Chiều rộng của left menu */
    padding: 20px;
    height: 90vh;
    background-color: #E0E0E0;
}
.table-thongbao{
    border-collapse: collapse;
        width: 100%;
}
.table-thongbao th,td{
    border: 5px solid black;
        padding: 8px;
        text-align: left;
}
.table-thongbao th{
    background-color: #f2f2f2;
}
.checkbox-container {
    display: flex;
    flex-wrap: wrap;
}

.checkbox-container label {
    margin-right: 20px; /* Khoảng cách giữa các checkbox */
}
    </style>