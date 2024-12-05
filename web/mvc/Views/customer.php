<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <style>
        :root {
            --primary-color: #4A2C2A;
            --secondary-color: #8B4513;
            --accent-color: #D2691E;
            --light-color: #F5DEB3;
        }

        body {
            font-family: 'Svn-Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--primary-color);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--primary-color);
            padding: 15px 0;
        }

        .navbar-brand {
            color: var(--light-color) !important;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .carousel {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .carousel-item img {
            height: 70vh;
            object-fit: cover;
            filter: brightness(0.8);
            transition: transform 0.3s ease;
        }

        .carousel-item:hover img {
            transform: scale(1.05);
        }

        .product-intro {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--light-color);
            padding: 50px 20px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .product-images img {
            border-radius: 10px;
            transition: all 0.3s ease;
            margin: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .product-images img:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .btn-custom {
            background-color: var(--accent-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .feedback-section {
            background-color: white;
            padding: 50px 0;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        footer {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">☕ Giao đồ uống</a>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://ticotravel.com.vn/wp-content/uploads/2022/04/cafe-Can-Tho-20-1-1200x600.jpg" class="d-block w-100" alt="Ảnh Quán Cà Phê">
            </div>
            <!-- Các slide khác giữ nguyên -->
        </div>
    </div>

    <!-- Giới Thiệu Sản Phẩm -->
    <div class="container mt-4">
        <div class="product-intro">
            <div class="row align-items-center">
                <div class="col-md-6 product-images">
                    <div class="row">
                        <div class="col-4">
                            <img src="https://fastly.4sqi.net/img/general/200x200/94741510_cBkNhjl4wmvqYQd8gPA03G0C2nMuurcqPG-a1cBexNo.jpg" alt="Sản phẩm 1" class="img-fluid">
                        </div>
                        <div class="col-4">
                            <img src="https://skynext.vn/wp-content/uploads/2021/09/quan-cafe-xoan-truong-chinh-ha-noi-4-200x200.jpg" alt="Sản phẩm 2" class="img-fluid">
                        </div>
                        <div class="col-4">
                            <img src="https://fastly.4sqi.net/img/general/200x200/70605700_ea4F2rlr6Y9hw27btcCK-6lyIYaJXJCjVjQCe735OoQ.jpg" alt="Sản phẩm 3" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <h2 class="mb-4">Khám Phá Thế Giới Đồ uống</h2>
                    <p>Chúng tôi mang đến những trải nghiệm đồ uống độc đáo và tinh tế nhất.</p>
                    <a href="MenuController" class="btn btn-custom btn-lg mt-3">Khám Phá Menu</a>
                </div>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="feedback-section mb-4 mt-4">
            <?php require_once "./mvc/Views/pages/Feedback.php"; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-2">© 2024 Giao đồ uống</p>
            <div>
                <a href="#" class="text-light mx-2" style="text-decoration: none;">Facebook</a>
                <a href="#" class="text-light mx-2" style="text-decoration: none;">Instagram</a>
                <a href="#" class="text-light mx-2" style="text-decoration: none;">Liên Hệ</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


