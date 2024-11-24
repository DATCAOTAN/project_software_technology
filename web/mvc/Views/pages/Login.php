<?php
session_start();

// Kiểm tra
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
if ($error) {
    unset($_SESSION['error']); // Xóa thông báo lỗi
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
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
<div class="card p-4 shadow" style="width: 400px;">
    <h2 class="text-center">Đăng nhập</h2>

    <!-- Hiển thị thông báo lỗi-->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="../../index.php?action=login.authenticate" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" style="border: 2px solid #ffa31a ; border-radius: 15px" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-group" >
                <input  type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" style="border: 2px solid #ffa31a;  border-radius: 15px "required>
                <button style="border: 2px solid #ffa31a ; border-radius: 15px" type="button" class="btn btn-outline-secondary" id="toggle-password">
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

    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    togglePassword.addEventListener('click', function () {

        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;


        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>
