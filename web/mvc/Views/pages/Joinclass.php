<div class="container mt-5">
    <h2 class="mb-4">Danh sách lớp học</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#joinClassModal">Tham gia lớp học</button>
    <div class="class-container">
        <div class="row">
            <?php
            foreach ($lophoc as $class) {
                echo '<div class="col-12">
                        <div class="class-card" onclick="redirectToController(' . $class['ID'] . ')">
                            <h4>' . $class['Ten'] . '</h4>
                            <p><strong>ID:</strong> ' . $class['ID'] . '</p>
                            <p><strong>ID Giảng Viên:</strong> ' . $class['ID_GiangVien'] . '</p>
                            <p><strong>ID Môn Học:</strong> ' . $class['ID_MonHoc'] . '</p>
                        </div>
                      </div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Modal nhập mã lớp học -->
<div class="modal fade" id="joinClassModal" tabindex="-1" role="dialog" aria-labelledby="joinClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinClassModalLabel">Nhập mã lớp học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="joinClassForm" method="POST">
                    <input type="text" class="form-control" id="classCodeInput" name="classCodeInput" placeholder="Nhập mã lớp học">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="joinClass()">Tham gia</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function redirectToController(classID) {
        // Thay đổi URL để chuyển hướng đến controller mới với classID như một tham số
        window.location.href = './ClassStudent/index/' + classID;
    }

    function joinClass() {
        console.log("hello");
        var classCode = document.getElementById("classCodeInput").value.trim();
        var ID_LopHoc = parseInt(classCode);
        var checkInput = classCode.replace(/\s/g, "");
        if (checkInput == 0) {
            alert('Dữ liệu đầu vào không hợp lệ');
        } else {
            console.log("okee ka");
            $.ajax({
                url: './JoinclassController/addLophocAjax/',
                type: 'POST',
                data: {
                    ID_LopHoc: ID_LopHoc,
                    ID_user: <?php echo $user_id;?>
                },
                success: function(response) {
                   if(response==2)
                   {
                    alert("Sinh viên đã tham gia lớp học") ;
                   }
                   else if(response==-1)
                   {
                    alert("Lớp học không tồn tại") ;
                   }
                   else{
                    alert("Tham gia thành công") ;
                   }
                   window.location.href =  "http://localhost/Project_web2/web/JoinclassController";
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed: " + textStatus + ", " + errorThrown);
            alert("Đã có lỗi xảy ra. Vui lòng thử lại.");
        }
            });
        }
    }

    $(document).ready(function() {
        $('#joinClassForm').submit(function(event) {
            // Ngăn chặn form được gửi đi mặc định
            event.preventDefault();
        });
    });
</script>
<style>
    .class-card {
        border: 3px solid black;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        cursor: pointer;
    }
    .class-card h4 {
        margin-top: 0;
    }
    .class-container {
        max-height: 480px;
        overflow-y: auto;
        padding: 10px;
    }
</style>
