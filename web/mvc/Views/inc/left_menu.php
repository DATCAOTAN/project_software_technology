<!-- left_menu.php -->
<?php
$current_page = basename($_SERVER['REQUEST_URI']); // Lấy tên trang hiện tại
?>
<div class="sidebar "> <!-- Kéo dài chiều rộng của sidebar -->
    <h4 class="mb-4 text-dark">Quản lý</h4>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-dark <?= $current_page == 'QLtkController' ? 'active' : '' ?>" href="QLtkController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-user-cog mr-2"></i>
                    Tài khoản
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark <?= $current_page == 'QLnvController' ? 'active' : '' ?>" href="QLnvController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-users mr-2"></i>
                    Nhân viên
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark  <?= $current_page == 'ThucUongController' ? 'active' : '' ?>" href="ThucUongController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-coffee mr-2"></i>
                    Thức uống
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark <?= $current_page == 'BankController' ? 'active' : '' ?>" href="BankController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-credit-card mr-2"></i>
                    Phương thức thanh toán
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark <?= $current_page == 'InvoiceController' ? 'active' : '' ?>" href="InvoiceController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-box mr-2"></i>
                    Đơn hàng
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark <?= $current_page == 'FeedbackController' ? 'active' : '' ?>" href="FeedbackController" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-comments mr-2"></i>
                    Xem phản hồi
                </div>
                <i class="fas fa-chevron-right fa-xs"></i> 
            </a>
        </li>
    </ul>
</div>
