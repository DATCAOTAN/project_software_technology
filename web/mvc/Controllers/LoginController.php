<?php

class LoginController extends Controller{
    protected $LoginModel;
    public function __construct() {
        $this->LoginModel = $this->model("LoginModel");
     }
    public function index(){  
        $this->view("login",['pageTitle'=>'Coffee shop']);
     }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->LoginModel->getUser($username, $password);
    
            // Kiểm tra xem người dùng có tồn tại trong cơ sở dữ liệu hay không
            if ($user) {
                // Kiểm tra nếu tài khoản là 'admin'
                if ($user['ten_tai_khoan'] === 'admin') {
                    $_SESSION['user'] = [
                        'userID' => $user['id'],
                        'logged' => true,
                        'isAdmin' => true // Đặt isAdmin = true cho admin
                    ];
                    echo json_encode([
                        'success' => true,
                        'message' => 'Đăng nhập thành công',
                        'logged' => true,
                        'isAdmin' => true,
                        'redirectUrl' => './ThucUongController' // Địa chỉ trang cần chuyển hướng
                    ]);
                } else {
                    $_SESSION['user'] = [
                        'userID' => $user['id'],
                        'logged' => true,
                        'isAdmin' => false // Đặt isAdmin = false cho người dùng bình thường
                    ];
                    echo json_encode([
                        'success' => true,
                        'message' => 'Đăng nhập thành công',
                        'logged' => true,
                        'isAdmin' => false,
                        'redirectUrl' => './ThucUongController' // Địa chỉ trang chuyển hướng cho người dùng thường
                    ]);
                }
            } else {
                // Nếu không có tài khoản nào trùng khớp
                $_SESSION['user'] = [
                    'logged' => false,
                    'isAdmin' => false
                ];
                echo json_encode([
                    'success' => false,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
                    'logged' => false,
                    'isAdmin' => false
                ]);
            }
        }
    }
    
    // public function checkLogged() {
    //     // Kiểm tra nếu người dùng đã đăng nhập
    //     if (isset($_SESSION['user']) && $_SESSION['user']['logged'] === true) {
    //         // Nếu đã đăng nhập, chuyển hướng về trang Home
    //         echo json_encode([
    //             'redirectUrl' => './ThucUongController' // Địa chỉ trang chuyển hướng cho người dùng thường
    //         ]);
    //     }
    // }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Chỉ khởi tạo session nếu chưa có
        }

        if (isset($_SESSION['user'])) {
            $_SESSION['user']['userID'] = null;
            $_SESSION['user']['logged'] = false;
            $_SESSION['user']['isAdmin'] = false;
        }

        // Xóa cache
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Chuyển hướng về trang đăng nhập
        header("Location: /project_software_technology/web/index.php?controller=LoginController");
        exit;
    }
}
