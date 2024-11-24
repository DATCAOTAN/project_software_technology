<?php

class LoginController {
    public function login() {
        require 'web/mvc/Views/pages/Login.php'; // trang đăng nhập
    }

    public function authenticate() {
        // Lấy thông tin
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra thông tin đăng nhập (set cứng tài khoản)
        if ($username === 'admin' && $password === 'admin') {
            session_start();
            $_SESSION['user'] = [
                'username' => $username
            ];
            // Chuyển hướng
            header('Location: Views/pages/Home.php');
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng.";
            header('Location: Views/pages/Login.php'); // Chuyển hướng
            exit;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}
