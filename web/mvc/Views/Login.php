<?php
// Bắt đầu phiên nếu chưa bắt đầu
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ khởi tạo session nếu chưa có
}

// Kiểm tra nếu phiên người dùng chưa được khởi tạo
if (!isset($_SESSION['user'])) {
    // Nếu chưa có, khởi tạo các giá trị mặc định
    $_SESSION['user'] = [
        'logged' => false,
        'isAdmin' => false
    ];
}

// Kiểm tra và lấy thông báo lỗi từ session nếu có
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
if ($error) {
    unset($_SESSION['error']); // Xóa thông báo lỗi sau khi đã hiển thị
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body {
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: none;
        position: relative;
        overflow: hidden; /* Đảm bảo lớp phủ không vượt ra ngoài */
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('public/images/background/anhnen.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(8px); /* Làm mờ */
        z-index: -2; /* Đặt nền phía sau nội dung */
    }

    body::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Lớp phủ màu tối (đen, 50% trong suốt) */
        z-index: -1; /* Đặt lớp phủ trên nền mờ nhưng dưới nội dung */
    }
</style>
<body class="bg-light d-flex justify-content-center align-items-center">
<div class="card p-4 shadow" style="width: 400px;">
    <h2 class="text-center">Đăng nhập</h2>

    <!-- Hiển thị thông báo lỗi-->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form id="login-form">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" style="border: 2px solid #ffa31a ; border-radius: 15px" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" style="border: 2px solid #ffa31a; border-radius: 15px" required>
                <button type="button" class="btn btn-outline-secondary" id="toggle-password" style="border: 2px solid #ffa31a ; border-radius: 15px">
                    <i id="eye-icon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn w-100" style="background-color: #ffa31a ; border: 5px solid #ffa31a ; border-radius: 15px">Đăng nhập</button>
    </form>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script>
   $(document).ready(function() {
    // Toggle password visibility
        $('#toggle-password').on('click', function() {
            const passwordField = $('#password');
            const eyeIcon = $('#eye-icon');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text'); // Show password
                eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordField.attr('type', 'password'); // Hide password
                eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
    });

    // $.ajax({
    //     url: './LoginController/checkLogged', // Đường dẫn tới file PHP để kiểm tra trạng thái
    //     type: 'GET',
    //     success: function(response) {
    //         var result = JSON.parse(response);
    //         if (response.logged) {
    //             window.location.href = response.redirectUrl;
    //         }
    //     }
    // });


    // Handle form submission via AJAX
    $('#login-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get form data
        const username = $('#username').val(); // Lấy tên đăng nhập
        const password = $('#password').val(); // Lấy mật khẩu

        // Create FormData object
        var formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        // Send data to the server using AJAX
        $.ajax({
            url: './LoginController/authenticate/', // URL của controller
            type: 'POST',
            data: formData,
            processData: false, // Phải đặt processData thành false khi sử dụng FormData
            contentType: false, // Phải đặt contentType thành false khi sử dụng FormData
            dataType: 'json', // Đảm bảo phản hồi là JSON
            success: function(response) {
                if (response.success) {
                    // Chuyển hướng tới trang Home nếu đăng nhập thành công
                    window.location.href = response.redirectUrl;
                } else {
                    // Hiển thị thông báo lỗi nếu đăng nhập thất bại
                    alert(response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
            }
        });
    });
});


</script>
</body>
</html>
