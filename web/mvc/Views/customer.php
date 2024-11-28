<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
        }

        .carousel-item {
            margin: 0 -100% 20px 0;
        }

        .carousel img {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }


        .product-intro {
            background: url('https://image.slidesdocs.com/responsive-images/background/coffee-illustration-poster-border-powerpoint-background_32b72e5f01__960_540.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            width: 100%;
            padding: 1%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-images img {
            margin: 5px;
            object-fit: cover;
            border: #E4E0E1 3px solid;
        }

        .feedback-section {
            display: flex;
            justify-content: space-between;
        }

        .feedback-list, .feedback-form {
            width: 48%;
        }

        footer {
            background-color: #f1f1f1;
            height: 100px;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Content -->
    <div class="content">
        <!-- Carousel -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://ticotravel.com.vn/wp-content/uploads/2022/04/cafe-Can-Tho-20-1-1200x600.jpg" class="d-block w-100" alt="Ảnh 1">
                </div>
                <div class="carousel-item">
                    <img src="https://biz.qdc.vn/pictures/catalog/showroom/bon-cafe/thiet-ke-showroom-bon-cafe-17.jpg" class="d-block w-100" alt="Ảnh 2">
                </div>
                <div class="carousel-item">
                    <img src="https://gotrangtri.vn/wp-content/uploads/2019/06/quan-cafe-dep-o-ha-noi-12.jpg" class="d-block w-100" alt="Ảnh 3">
                </div>
                <div class="carousel-item">
                    <img src="https://images.squarespace-cdn.com/content/v1/5b8bf301e2ccd13e972a0ab4/1536043714474-7POWV2ZPAZ0ZYG10MVKD/interior-design-cafe-vintage-hancoffee3.jpg" class="d-block w-100" alt="Ảnh 4">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container mt-4">
            <!-- Product Introduction Section -->
            <div class="product-intro">
                <!-- Product Images Grid 2x2 -->
                <div class="product-images">
                    <div class="d-flex align-items-center">
                        <img src="https://ghien.cafe/uploads/coffeeshop/lang-cafe-2-14.jpg" alt="Sản phẩm 1" style="margin-left: 20px;">
                        <img src="https://skynext.vn/wp-content/uploads/2021/09/quan-cafe-xoan-truong-chinh-ha-noi-4-200x200.jpg" alt="Sản phẩm 2">
                        <img src="https://ghien.cafe/uploads/coffeeshop/lang-cafe-1-50.jpg" alt="Sản phẩm 3">
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="https://fastly.4sqi.net/img/general/200x200/94741510_cBkNhjl4wmvqYQd8gPA03G0C2nMuurcqPG-a1cBexNo.jpg"  alt="Sản phẩm 4" style="margin-left: 100px;">
                        <img src="https://fastly.4sqi.net/img/general/200x200/70605700_ea4F2rlr6Y9hw27btcCK-6lyIYaJXJCjVjQCe735OoQ.jpg" alt="Sản phẩm 5">
                        <img src="https://ghien.cafe/uploads/coffeeshop/lang-cafe-41.jpg" alt="Sản phẩm 6">
                    </div>
                </div>
                <!-- Menu Button -->
                <div style="color: #3B3030">
                    <h2>Giới Thiệu Sản Phẩm</h2>
                    <p>Khám phá thực đơn đa dạng của chúng tôi.</p>
                    <a href="MenuController" class="btn btn-light btn-lg"style="color: #3B3030;">Xem Menu</a>
                </div>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="feedback-section">
            <?php require_once "./mvc/Views/pages/Feedback.php"; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Bản quyền © 2024 Công ty TNHH XYZ</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


