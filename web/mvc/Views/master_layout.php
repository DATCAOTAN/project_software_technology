<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Đảm bảo chiều cao đầy đủ cho body và html */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Đảm bảo chiều cao của container chiếm toàn bộ màn hình */
        .container-fluid {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Sử dụng flexbox để chia layout */
        .row.no-gutters {
            flex: 1;
        }

        /* Left Menu */
        .sidebar {
            min-height: 90vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Main Content */
        .main-content {
            min-height: 90vh;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Card for main content */
        .card {
            margin-top: 20px;
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
            <div class="left_menu">
                <?php include("inc/left_menu.php");?>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <?php require_once "./mvc/Views/pages/".$page.".php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
