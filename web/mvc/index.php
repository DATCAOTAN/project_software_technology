<?php

require 'Controllers/LoginController.php';
$login = new LoginController();

$action = isset($_GET['action']) ? $_GET['action'] : 'login'; // Mặc định là 'login'

switch ($action) {
    case 'login':
        $login->login();
        break;
    case 'login.authenticate':
        $login->authenticate();
        break;
    case 'logout':
        $login->logout();
        break;
    default:
        echo "404 - Không tìm thấy hành động!";
        break;
}
?>
