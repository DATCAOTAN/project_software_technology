
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Phương Thức Thanh Toán</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Danh Sách Phương Thức Thanh Toán</h2>
    <div class="table-responsive-md mx-auto" style="height: 450px; overflow-y: scroll; max-width: 1200px;">
    <table class="table table-striped table-hover table-bordered">
        <thead class="sticky-top">
            <tr class="bg-dark text-light">
                <th>ID</th>
                <th>Tên Phương Thức</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Bank as $method): ?>
                <tr>
                    <td><?php echo $method['id']; ?></td>
                    <td><?php echo htmlspecialchars($method['ten']); ?></td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal<?php echo $method['id']; ?>">Chi Tiết</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Modal chi tiết -->
<?php foreach ($Bank as $method): ?>
<div class="modal fade" id="detailModal<?php echo $method['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?php echo $method['id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel<?php echo $method['id']; ?>">Chi Tiết: <?php echo htmlspecialchars($method['ten']); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-success mb-3 addDetailBtn" id="addDetailBtn<?php echo $method['id']; ?>" data-method-id="<?php echo $method['id']; ?>">Thêm Chi Tiết Thanh Toán</button>

                
                <!-- Form thêm chi tiết thanh toán -->
                <div class="form-container mt-3 addDetailForm" id="addDetailForm<?php echo $method['id']; ?>" style="display: none;">
                    <div class="form-group">
                        <label for="detailName<?php echo $method['id']; ?>">Tên Chi Tiết</label>
                        <input type="text" class="form-control" id="detailName<?php echo $method['id']; ?>" placeholder="Nhập tên chi tiết">
                    </div>
                    <div class="form-group">
                        <label for="detailFee<?php echo $method['id']; ?>">Phí (%)</label>
                        <input type="number" class="form-control" id="detailFee<?php echo $method['id']; ?>" placeholder="Nhập phí (%)">
                    </div>
                    <button type="button" class="btn btn-primary saveDetailBtn" data-method-id="<?php echo $method['id']; ?>">Lưu</button>
                    <button type="button" class="btn btn-secondary cancelAddDetailBtn" data-method-id="<?php echo $method['id']; ?>">Hủy</button>
                </div>

                <table class="table table-bordered" id="detailTable<?php echo $method['id']; ?>">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Chi Tiết</th>
                            <th>Phí (%)</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($Bank_detail) > 0): 
                            $stt = 1;
                            foreach ($Bank_detail as $detail): ?>
                             <?php if($method["id"] == $detail["phuong_thuc_thanh_toan_id"]): ?>
                                <tr>
                                    <td><?php echo $stt++; ?></td>
                                    <td><?php echo htmlspecialchars($detail['ten']); ?></td>
                                    <td><?php echo htmlspecialchars($detail['fee']); ?>%</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm editDetailBtn" data-method-id="<?php echo $method['id']; ?>" data-detail-id="<?php echo $detail['id']; ?>" data-name="<?php echo ($detail['ten']); ?>" data-fee="<?php echo ($detail['fee']); ?>">Sửa</button>
                                        <button class="btn btn-danger btn-sm deleteDetailBtn" data-method-id="<?php echo $method['id']; ?>"data-detail-id="<?php echo $detail['id']; ?>">Xóa</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Chưa có chi tiết nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
$(document).ready(function() {
    // Thêm chi tiết
    var flag=0,methodId,detailId
    $('.addDetailBtn').on('click', function() {
        flag=1
         methodId = $(this).data('method-id');
        $('#addDetailForm' + methodId).show();
        $('#detailTable' + methodId).hide();
    });

    // Hủy thêm chi tiết
    $('.cancelAddDetailBtn').on('click', function() {
         methodId = $(this).data('method-id');
        $('#addDetailForm' + methodId).hide();
        $('#detailTable' + methodId).show();
        $('#addDetailBtn' + methodId).show();
        $('#detailName' + methodId).val("");
        $('#detailFee' + methodId).val("");
    });

// Sửa chi tiết
$(document).on('click', '.editDetailBtn', function() {
    flag = 0;
    methodId = $(this).data('method-id');
    detailId = $(this).data('detail-id');
    console.log(methodId, detailId);
    var row = $('#detailTable' + methodId + ' tbody')
                        .find('button[data-detail-id="' + detailId + '"]')
                        .closest('tr');

    // Lấy giá trị mới nhất từ các thuộc tính data-name và data-fee
    var name = row.find('.editDetailBtn').attr('data-name');
   
    var fee =  row.find('.editDetailBtn').attr('data-fee')
    console.log(name, fee);  // Kiểm tra giá trị sau khi lấy từ data-*.

    // Điền dữ liệu vào form sửa
    $('#detailName' + methodId).val(name);
    $('#detailFee' + methodId).val(fee);

    // Ẩn nút "Thêm Chi Tiết"
    $('#addDetailBtn' + methodId).hide();

    // Hiển thị form sửa và thay đổi nút "Lưu" thành "Cập Nhật"
    $('#addDetailForm' + methodId).show().find('.saveDetailBtn').text('Cập Nhật');

    // Ẩn bảng chi tiết
    $('#detailTable' + methodId).hide();
});



//Lưu hoặc cập nhật
$('.saveDetailBtn').on('click', function() {
    var name = $('#detailName' + methodId).val();
    var fee = $('#detailFee' + methodId).val();
    
    // Kiểm tra dữ liệu trước khi gửi
    if (name === '' || fee === '') {
        alert('Vui lòng nhập đầy đủ thông tin.');
        return;
    }
    var formData = new FormData();
formData.append('ten', name);
formData.append('fee', fee);
formData.append('phuong_thuc_thanh_toan_id', methodId);
if(flag==1)
{
    $.ajax({
    url: './BankController/add/', // Thay bằng endpoint API thêm thức uống của bạn
    method: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,  // Đảm bảo không xử lý dữ liệu trong request
    contentType: false,  // Đảm bảo header là multipart/form-data
    success: function (response) {
        alert("thêm thành công")
        if (response.success) {
        $('#addDetailForm' + methodId).hide();
        $('#detailTable' + methodId).show();
        $('#addDetailBtn' + methodId).show();
        $('#detailName' + methodId).val("");
        $('#detailFee' + methodId).val("");
            
            // Xóa hết nội dung hiện tại của bảng
            $('#detailTable' + methodId + ' tbody').empty();
            
            // Thêm các dòng mới từ dữ liệu chi tiết cập nhật
            var stt = 1;
            response.data.forEach(function(detail) {
    var newRow = `
        <tr>
            <td>${stt++}</td>
            <td>${detail.ten}</td>
            <td>${detail.fee}%</td>
            <td>
                <button class="btn btn-warning btn-sm editDetailBtn" 
                        data-method-id="${methodId}" 
                        data-detail-id="${detail.id}" 
                        data-name="${detail.ten}" 
                        data-fee="${detail.fee}">
                    Sửa
                </button>
                <button class="btn btn-danger btn-sm deleteDetailBtn" 
                      data-method-id="${methodId}"  data-detail-id="${detail.id}">
                    Xóa
                </button>
            </td>
        </tr>`;

    // Thêm dòng vào bảng
    $('#detailTable' + methodId + ' tbody').append(newRow);

});

           
        } else {
            alert(response.message || 'Có lỗi xảy ra!');
        }
    },
    error: function () {
        alert('Không thể thêm thức uống. Vui lòng thử lại sau!');
    }
});
}
else{
    $.ajax({
    url: './BankController/edit/' + detailId,
    method: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,  // Không xử lý dữ liệu trong request
    contentType: false,  // Đảm bảo header là multipart/form-data
    success: function (response) {
        console.log(response.success);
        if (response.success) {
            alert("Cập nhật thành công!");

            // Cập nhật dữ liệu trong bảng
           
            var newName = response.data.ten;
            var newFee = response.data.fee;

            // Tìm hàng tương ứng trong bảng bằng detail-id
            var row = $('#detailTable' + methodId + ' tbody')
                        .find('button[data-detail-id="' + detailId + '"]')
                        .closest('tr');

            // Cập nhật dữ liệu trong hàng
            row.find('td:eq(1)').text(newName);  // Cập nhật tên
            row.find('td:eq(2)').text(newFee+'%');  // Cập nhật phí
            row.find('.editDetailBtn').attr('data-name', response.data.ten);
            row.find('.editDetailBtn').attr('data-fee', response.data.fee);

            // Kiểm tra sau khi cập nhật
            console.log( row.find('.editDetailBtn').attr('data-name'),  row.find('.editDetailBtn').attr('data-fee'));
            // Ẩn form chỉnh sửa, hiển thị bảng
            $('#addDetailForm' + methodId).hide();
            $('#detailTable' + methodId).show();
            $('#addDetailBtn' + methodId).show();

            // Reset form
            $('#detailName' + methodId).val("");
            $('#detailFee' + methodId).val("");
        } else {
            alert(response.message || 'Có lỗi xảy ra!');
        }
    },
    error: function () {
        alert('Không thể cập nhật. Vui lòng thử lại sau!');
    }
});

}
});
  $(document).on('click', '.deleteDetailBtn', function() {
    detailId = $(this).data('detail-id');
    methodId = $(this).data('method-id');
    console.log(methodId,detailId)

            if (confirm('Bạn có chắc chắn muốn xóa chi tiết này không?')) {
                $.ajax({
    url: './BankController/delete/',
    method: 'POST',
    dataType: 'json',
    data: {  // Truyền dữ liệu dưới dạng object
                id: detailId,
                phuong_thuc_thanh_toan_id: methodId
            },
    success: function (response) {
        console.log(response.success);
        if (response.success) {
            alert("Xóa thành công!");

            

            // Tìm hàng tương ứng trong bảng bằng detail-id
            var row = $('#detailTable' + methodId + ' tbody')
                        .find('button[data-detail-id="' + detailId + '"]')
                        .closest('tr');
            row.remove(); 

            // Ẩn form chỉnh sửa, hiển thị bảng
            $('#addDetailForm' + methodId).hide();
            $('#detailTable' + methodId).show();
            $('#addDetailBtn' + methodId).show();

            // Reset form
            $('#detailName' + methodId).val("");
            $('#detailFee' + methodId).val("");
        } else {
            alert(response.message || 'Có lỗi xảy ra!');
        }
    },
    error: function () {
        alert('Không thể cập nhật. Vui lòng thử lại sau!');
    }
});
    
            }
        });
});
</script>




</body>
</html>
