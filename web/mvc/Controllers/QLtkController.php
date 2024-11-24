<?php  
   class QltkController extends Controller{
      protected $TaiKhoanModel;
      public function __construct() {
         $this->TaiKhoanModel = $this->model("TaiKhoanModel");
      }
      public function index(){  
         // $leftmenu= $this->showLeftmenu();
         $accounts = $this->TaiKhoanModel->getAll();

         $this->view("master_layout",['page'=>'QLtk',
                                    'pageTitle'=>'Quản lý tài khoản',
                                    'data' => $accounts
                                    // 'view'=>$leftmenu
         ]);
      }

      public function addAccount() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Debug để xem dữ liệu gửi lên
             error_log(print_r($_POST, true));
             
             $name = $_POST['name'] ?? '';
             $pass = $_POST['password'] ?? '';
             
             
             // Thêm nhân viên vào cơ sở dữ liệu
             $result = $this->TaiKhoanModel->addAccount($name, $pass);
             
             if ($result === true) {
                 echo 1;
             } else {
                 echo "ins_failed: Database error";
             }
         } else {
             echo "ins_failed: Invalid request method";
         }
     }
     
     public function editAccount() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Debug để xem dữ liệu gửi lên
         error_log(print_r($_POST, true));
         
         $name = $_POST['name'] ?? '';
         $pass = $_POST['pass'] ?? '';
         $id = $_POST['account_id'] ?? '';
         
         
         // Thêm nhân viên vào cơ sở dữ liệu
         $result = $this->TaiKhoanModel->updateAccount($name, $pass, $id);
         
         if ($result === true) {
             echo 1;
         } else {
             echo "upd_failed: Database error";
         }
     } else {
         echo "upd_failed: Invalid request method";
     }
     }

      public function getAccountById() {
            $id = $_POST['get_account'];
            $employee = $this->TaiKhoanModel->getAccountById($id);
            echo json_encode($employee);
      }
      
      public function deleteAccount() {
            $id = $_POST['id'];
            if($this->TaiKhoanModel->checkAccount($id)){
               echo json_encode(['status' => 'error', 'message' => 'Tài khoản đã có nhân viên sử dụng.']);
               return;
            }
            $result = $this->TaiKhoanModel->deleteAccount($id);
            if ($result) {
               echo json_encode(['status' => 'success', 'message' => 'Xóa thành công!']);
            } else {
               echo json_encode(['status' => 'error', 'message' => 'Xóa thất bại.']);
            }
      }
   }
?>