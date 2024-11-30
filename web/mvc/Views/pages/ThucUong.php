<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thức Uống</title>
    <style>
        .card {
            position: relative;
            overflow: hidden;
            border: none;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bóng nhẹ cho card */
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: contain;      /* Cắt hình để lấp đầy khung mà không méo hình */
            transition: transform 0.4s ease, opacity 0.4s ease;
        }

        .card:hover {
            transform: translateY(-10px); /* Nâng card lên khi hover */
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2); /* Tăng bóng đổ */
        }
        .scroll-container {
        max-height: 550px;  /* Điều chỉnh chiều cao theo ý muốn */
        overflow-y: auto;   /* Thanh cuộn dọc */
        width: 100%;
    }

    /* Tùy chỉnh giao diện cho các thẻ */
    .card {
        height: 100%;  /* Đảm bảo các thẻ có chiều cao cố định */
    }

        .card:hover .card-img-top {
            transform: scale(1.05); /* Phóng to nhẹ hình ảnh */
            opacity: 0.9; /* Giảm độ mờ hình ảnh */
        }

        .card-footer {
        padding: 0px;
        display: flex;
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
        height: 100%; /* Đặt chiều cao cố định cho footer */
        background-color: white; /* Nền trắng cho footer */
    }

    .card-title {
        margin: 0; /* Loại bỏ margin mặc định */
    }


        /* Ẩn biểu tượng mặc định */
        .card-icons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-icons button {
            margin-bottom: 5px;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
        }

        .card:hover .card-icons {
            opacity: 1; /* Hiển thị biểu tượng khi hover */
        }
    </style>
</head>
<body>
        <!-- Header Section với nút Thêm và ô tìm kiếm -->
        <div class="d-flex justify-content-between mb-4">
            <button class="btn btn-success" data-toggle="modal" data-target="#drinkModal">Thêm thức uống</button>
  
   <!-- Form tìm kiếm -->
   <form class="form-inline" id="searchForm">
        <input class="form-control mr-sm-2" type="search" id="searchInput" placeholder="Tìm kiếm thức uống" aria-label="Tìm kiếm">
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton" style="margin-right: 20px;">Tìm kiếm</button>
    </form>

        </div>

        <!-- Hiển thị danh sách thức uống -->
        <div class="row scroll-container">
            
        </div>

<!-- Modal -->
<div class="modal fade" id="drinkModal" tabindex="-1" role="dialog" aria-labelledby="drinkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg để làm modal to hơn -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="drinkModalLabel">Thêm Thức Uống</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tên và Mô tả trên cùng một hàng -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-4">
                        <label for="drinkName">Tên</label>
                        <input type="text" class="form-control" id="drinkName" placeholder="Nhập tên thức uống">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="drinkDescription">Mô tả</label>
                        <input type="text" class="form-control" id="drinkDescription" placeholder="Nhập mô tả">
                    </div>
                </div>

                <!-- Size S -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-5 pr-4">
                        <label for="sizeSPrice">Giá Size S</label>
                        <input type="number" class="form-control" id="sizeSPrice" placeholder="Nhập giá Size S"  min="0" step="1">
                    </div>
                    <div class="form-group col-md-5 ml-4">
                        <label for="sizeSStatus">Trạng thái Size S</label>
                        <select class="form-control" id="sizeSStatus">
                            <option selected>Chọn trạng thái</option>
                            <option value="1">Bán</option>
                            <option value="0">Không bán</option>
                        </select>
                    </div>
                </div>

                <!-- Size M -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-5 pr-4">
                        <label for="sizeMPrice">Giá Size M</label>
                        <input type="number" class="form-control" id="sizeMPrice" placeholder="Nhập giá Size M"  min="0" step="1">
                    </div>
                    <div class="form-group col-md-5 ml-4">
                        <label for="sizeMStatus">Trạng thái Size M</label>
                        <select class="form-control" id="sizeMStatus">
                            <option selected>Chọn trạng thái</option>
                            <option value="1">Bán</option>
                            <option value="0">Không bán</option>
                        </select>
                    </div>
                </div>

                <!-- Size L -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-5 pr-4">
                        <label for="sizeLPrice">Giá Size L</label>
                        <input type="number" class="form-control" id="sizeLPrice" placeholder="Nhập giá Size L"  min="0" step="1">
                    </div>
                    <div class="form-group col-md-5 ml-4">
                        <label for="sizeLStatus">Trạng thái Size L</label>
                        <select class="form-control" id="sizeLStatus">
                            <option selected>Chọn trạng thái</option>
                            <option value="1">Bán</option>
                            <option value="0">Không bán</option>
                        </select>
                    </div>
                </div>

                <!-- Import hình ảnh -->
                <div class="form-group">
                <label for="drinkImage">Chọn Hình ảnh:</label>
                <input type="file" class="custom-file-input" id="drinkImage" accept="image/*">
                <label class="file-label" for="drinkImage">Chọn tệp hình ảnh</label>
                <!-- Hình ảnh mặc định tượng trưng từ thư mục public/images -->
        <img id="previewImage" src="public/images/default-image.jpg" alt="Preview Image" class="img-thumbnail mt-3">
            </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary">Thêm</button>
            </div>
        </div>
    </div>
</div>



<!-- CSS Tùy Chỉnh -->
<style>
    .form-group label {
        font-weight: bold;  /* Làm đậm nhãn */
    }
    .modal-dialog {
        max-width: 800px;  /* Điều chỉnh kích thước modal */
    }
    .form-group + .form-group {
        margin-left: 30px;  /* Khoảng cách giữa các cột giá và trạng thái */
    }

     /* Ẩn tên tệp hình ảnh từ input */
     .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        .file-label {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 10px 15px;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #previewImage {
            max-width: 200px;  /* Chiều rộng tối đa */
            max-height: 200px; /* Chiều cao tối đa */
            display: block;
            margin-top: 10px;
            object-fit: contain;  /* Giữ tỷ lệ hình ảnh */
        }
</style>



    <!-- Link Bootstrap và jQuery (cần thiết để modal hoạt động) -->

<script>
$(document).ready(function() {


    var flag=0;
    var imageNumber,imageUrl,target,card




    $(document).ready(function() {
        // Khi người dùng chọn một file
        $('#drinkImage').change(function(event) {
            var file = event.target.files[0];
            if (file) {
                // Đọc và hiển thị hình ảnh chọn
                var reader = new FileReader();
                reader.onload = function(e) {
                    target=e.target.result   
                    $('#previewImage').attr('src', e.target.result).show();  // Hiển thị hình ảnh
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không có file, ẩn hình ảnh và giữ hình ảnh mặc định
                $('#previewImage').attr('src', 'public/images/default-image.jpg').show();
            }
        });
    });
    // Xử lý khi click vào card
   
    $(document).on('click', '.card', function() {
        // Lấy thông tin từ card
        const drinkName = $(this).find('.card-title').text();
        imageUrl = $(this).find('.card-img-top').attr('src');
        const imageName = imageUrl.split('/').pop();  
         imageNumber = parseInt(imageName.match(/\d+/)[0]) 
        chi_tiet()
        // Đưa dữ liệu vào modal
        $('#drinkModalLabel').text('Chi tiết Thức Uống'); // Đổi tiêu đề modal
        $('#drinkName').val(drinkName).prop('readonly', true); // Tên không sửa được
        $('#drinkDescription').prop('readonly', true); // Mô tả không sửa được
        $('#sizeSPrice, #sizeMPrice, #sizeLPrice').prop('readonly', true); // Giá không sửa được
        $('#sizeSStatus, #sizeMStatus, #sizeLStatus').prop('disabled', true); // Trạng thái không thay đổi
        $('#drinkImage').prop('disabled', true); // Tắt chọn hình ảnh
        $('#previewImage').attr('src', imageUrl); // Hiển thị hình ảnh
        // Ẩn nút "Thêm"
        $('.btn-primary').hide();
        // Mở modal
        $('#drinkModal').modal('show');
    });

    $('.btn-success').click(function() {
    // Đặt lại tất cả các trường trong form chính của modal
   flag=1
    resetDrinkForm()


    // Đặt lại thuộc tính readonly và disabled
    $('#drinkName, #drinkDescription').prop('readonly', false); 
    $('#sizeSPrice, #sizeMPrice, #sizeLPrice').prop('readonly', false); 
    $('#sizeSStatus, #sizeMStatus, #sizeLStatus').prop('disabled', false); 
    $('#drinkImage').prop('disabled', false); 

    // Cập nhật tiêu đề modal và nút Thêm
    $('#drinkModalLabel').text('Thêm thức uống');
    $('.btn-primary').text('Thêm').show();

    
});

 
$(document).on('click', '.btn-primary', function() {
    // Đặt lại tất cả các trường trong form chính của modal
    var formData = new FormData();
formData.append('name', $('#drinkName').val());
formData.append('description', $('#drinkDescription').val());
formData.append('sizeSPrice', $('#sizeSPrice').val());
formData.append('sizeMPrice', $('#sizeMPrice').val());
formData.append('sizeLPrice', $('#sizeLPrice').val());
formData.append('sizeSStatus', $('#sizeSStatus').val());
formData.append('sizeMStatus', $('#sizeMStatus').val());
formData.append('sizeLStatus', $('#sizeLStatus').val());
formData.append('image', $('#drinkImage')[0].files[0]);
  if(flag==1){
   // Gửi AJAX request
$.ajax({
    url: './ThucUongController/add/', // Thay bằng endpoint API thêm thức uống của bạn
    method: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,  // Đảm bảo không xử lý dữ liệu trong request
    contentType: false,  // Đảm bảo header là multipart/form-data
    success: function (response) {
        console.log(response.success);
        if (response.success) {
            alert('Thêm thành công');
            loadScrollContainer(response.data)
        } else {
            alert(response.message || 'Có lỗi xảy ra!');
        }
    },
    error: function () {
        alert('Không thể thêm thức uống,Tên bị trùng !');
    }
});
  }
  if(flag==0){
    if (confirm(`Bạn có chắc chắn muốn sửa thức uống  không?`)) {
        $.ajax({
        url: './ThucUongController/edit/' + imageNumber,
        type: 'POST',
      data: formData,
    dataType: 'json',
    processData: false,  // Đảm bảo không xử lý dữ liệu trong request
    contentType: false,  // Đảm bảo header là multipart/form-data
    success: function (response) {
        console.log(response.success);
        if (response.success) {
            alert('Sửa thành công');
             loadScrollContainer(response.data)
            
        } else {
            alert(response.message || 'Có lỗi xảy ra!');
        }
    },
    error: function () {
        alert('Không thể sửa thức uống. Vui lòng thử lại sau!');
    }
   
        
        });
          
        }
  }
    
     
    
});
function resetDrinkForm() {
    // Reset tất cả các trường input trong form
    $('#drinkName').val('');
    $('#drinkDescription').val('');
    $('#sizeSPrice').val('');
    $('#sizeMPrice').val('');
    $('#sizeLPrice').val('');

    // Reset các trường select về trạng thái mặc định
    $('#sizeSStatus').prop('selectedIndex', 0);
    $('#sizeMStatus').prop('selectedIndex', 0);
    $('#sizeLStatus').prop('selectedIndex', 0);

    // Reset file input
    $('#drinkImage').val('');

    // Reset hình ảnh preview
    $('#previewImage').attr('src', 'public/images/default-image.jpg');
}

    // Sự kiện khi click vào nút xóa

    $(document).on('click', '.btn-outline-danger', function(event){
        event.stopPropagation();  // Ngăn chặn sự kiện click vào card
        const drinkName = $(this).closest('.card').find('.card-title').text();
        if (confirm(`Bạn có chắc chắn muốn xóa thức uống "${drinkName}" không?`)) {
            // Thực hiện hành động xóa tại đây
            // Ví dụ: gọi AJAX để xóa trên server hoặc cập nhật giao diện
        const card = $(this).closest('.card');
        imageUrl = card.find('.card-img-top').attr('src');
        const imageName = imageUrl.split('/').pop();  // 'image1.jpg'
         imageNumber = parseInt(imageName.match(/\d+/)[0])  // Lấy số '1'
        $.ajax({
        url: './ThucUongController/delete/' + imageNumber,
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            alert(`Đã xóa thức uống: ${drinkName}`);
            loadScrollContainer(data)
          
    },
    error: function(xhr, status, error) {
        console.error('Lỗi:', status, error);
    }
   
        
        });
          
        }
    });

    $(document).on('click', '.btn-outline-primary', function(event) {
        event.stopPropagation();  // Ngăn chặn sự kiện click vào card
        flag=0
        $('#drinkName').prop('readonly', false); // Tên không sửa được
        $('#drinkDescription').prop('readonly', false); // Mô tả không sửa được
        $('#sizeSPrice, #sizeMPrice, #sizeLPrice').prop('readonly', false); // Giá không sửa được
        $('#sizeSStatus, #sizeMStatus, #sizeLStatus').prop('disabled', false); // Trạng thái không thay đổi
        $('#drinkImage').prop('disabled', false); // Tắt chọn hình ảnh
        card = $(this).closest('.card');
        const drinkName = card.find('.card-title').text();
        imageUrl = card.find('.card-img-top').attr('src');
        const imageName = imageUrl.split('/').pop();  // 'image1.jpg'
         imageNumber = parseInt(imageName.match(/\d+/)[0])  // Lấy số '1'
        chi_tiet()
        $('#previewImage').attr('src', imageUrl);
        // Đưa dữ liệu vào modal chỉnh sửa
        $('#drinkModalLabel').text('Chỉnh Sửa Thức Uống');  // Đổi tiêu đề modal
        $('.btn-primary').text('Sửa').show();
        // Mở modal
        $('#drinkModal').modal('show');
    });

    function chi_tiet()
    {  
        console.log(imageUrl)
       var mo_ta = '';
       var ten_thuc_uong='';
        $.ajax({
        url: './ThucUongController/get_chitiet/' + imageNumber,
        type: 'POST',
        dataType: 'json',
        success: function(data) {
        console.log('Dữ liệu trả về:', data);
        mo_ta=data[0]['mo_ta']
        ten_thuc_uong=data[0]['ten_thuc_uong']
        console.log( mo_ta);
        $('#drinkDescription').val(mo_ta)
        $('#drinkName').val(ten_thuc_uong)
        
        $.each(data, function(index, thuc_uong){
           if(thuc_uong.Size=="S"){
            $('#sizeSPrice').val(thuc_uong.Gia_tien)
                if(thuc_uong.Trang_thai_ban=="Het hang") $('#sizeSStatus').val("0")
                else $('#sizeSStatus').val("1")
           }
                
           else if(thuc_uong.Size=="M"){
            $('#sizeMPrice').val(thuc_uong.Gia_tien)
                if(thuc_uong.Trang_thai_ban=="Het hang") $('#sizeMStatus').val("0")
                else $('#sizeMStatus').val("1")
           }
           else if(thuc_uong.Size=="L"){
            $('#sizeLPrice').val(thuc_uong.Gia_tien)
                if(thuc_uong.Trang_thai_ban=="Het hang") $('#sizeLStatus').val("0")
                else $('#sizeLStatus').val("1")
           }

             
        });
        
    },
    error: function(xhr, status, error) {
        console.error('Lỗi:', status, error);
    }
   
        
        });
      

    }


    function loadScrollContainer(data) {
    $('.scroll-container').empty(); // Xóa nội dung cũ
    
    data.forEach(function(item) {
        // Tạo HTML mới cho từng item và thêm vào container
        const cardHtml = `
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 position-relative overflow-hidden text-center">
                    <img src="public/images/thuc_uong/${item.image_URL}" class="card-img-top" alt="${item.Ten_thuc_uong}">
                    <div class="card-icons">
                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <h5 class="card-title">${item.Ten_thuc_uong}</h5>
                    </div>
                </div>
            </div>`;
        
        $('.scroll-container').append(cardHtml); // Thêm HTML mới vào container
    });
}
const data = <?php echo json_encode($ThucUong); ?>;
loadScrollContainer(data)
$(document).ready(function() {

            $('#searchButton').on('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của nút

                // Lấy giá trị từ ô input tìm kiếm
                var keyword = $('#searchInput').val().trim();

                // Kiểm tra nếu ô tìm kiếm không trống
                if (keyword !== '') {
                    console.log("Từ khóa tìm kiếm: " + keyword);

                    // Gửi từ khóa tìm kiếm đến server bằng AJAX
                    $.ajax({
                        url: './ThucUongController/search/' + keyword, // Đường dẫn đến controller xử lý tìm kiếm
                        type: 'POST', // Phương thức GET
                        dataType: 'json',
                        success: function(response) {
                            // Xử lý dữ liệu trả về từ server
                        
                            console.log(response.data)
                            loadScrollContainer(response.data);
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });
                } else {
                    alert('Vui lòng nhập từ khóa tìm kiếm.');
                }
            });

         

});
});



</script>

</body>
</html>
