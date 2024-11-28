<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['logged'] !== true) {
    header("Location: /project_software_technology/web/index.php?controller=LoginController");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Đảm bảo chiều cao đầy đủ cho body và html */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Đảm bảo chiều cao của container chiếm toàn bộ màn hình */
        .container-fluid {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
        }

        /* Sử dụng flexbox để chia layout */
        .row.no-gutters {
            flex: 1;
        }

        /* Left Menu */
        .sidebar {
            min-height: 80vh;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Main Content */
        .main-content {
            min-height: 80vh;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Card for main content */
        .card {
            margin-top: 20px;
        }

        .sidebar .nav-link {
            transition: background-color 0.3s ease, color 0.3s ease;
            /* Hiệu ứng chuyển đổi mượt */
        }

        .sidebar .nav-link:hover {
            background-color: #f1f1f1;
            /* Màu nền khi hover */
            color: #007bff;
            /* Màu chữ khi hover */
            text-decoration: none;
            /* Không gạch chân */
        }

        .sidebar .nav-link.active {
            font-weight: bold;
            /* Làm đậm chữ */
            color: #007bff;
            /* Màu xanh đậm hoặc tùy chọn */
            background-color: #f8f9fa;
            /* Nền sáng hơn */
            border-left: 4px solid #007bff;
            /* Đường kẻ bên trái */
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="header">
            <?php include("inc/header.php"); ?>
        </div>

        <div class="row no-gutters">
            <!-- Left Menu -->
            <div class="left_menu col-md-2 sidebar">
                <?php include("inc/left_menu.php"); ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <?php require_once "./mvc/Views/pages/" . $page . ".php"; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".sidebar .nav-link");
            const currentUrl = window.location.pathname;

            links.forEach(link => {
                if (link.getAttribute("href") === currentUrl) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>

</html>