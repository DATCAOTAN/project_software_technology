<?php  
   class QlnvController extends Controller{
      protected $NhanVienModel;
      public function __construct() {
         $this->NhanVienModel = $this->model("NhanVienModel");
      }
      public function index(){  
         $employees = $this->NhanVienModel->getAll();
         $accounts = $this->NhanVienModel->getAccountIDNotUse();
         $this->view("master_layout", [
               'page' => 'QLnv',
               'pageTitle' => 'Quản lý nhân viên',
               'data' => $employees,
               'dataAccountForUser'=>$accounts
         ]);
      }

      public function addEmployee() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Debug để xem dữ liệu gửi lên
             error_log(print_r($_POST, true));
             
             $name = $_POST['name'] ?? '';
             $phone = $_POST['phone'] ?? '';
             $email = $_POST['email'] ?? '';
             $account_id = $_POST['account_id'] ?? '';
             
             // Kiểm tra chi tiết hơn
             if (empty($name) || empty($phone) || empty($email) || empty($account_id)) {
                 echo "ins_failed: Missing data - Name: $name, Phone: $phone, Email: $email, Account: $account_id";
                 return;
             }
             
             // Thêm nhân viên vào cơ sở dữ liệu
             $result = $this->NhanVienModel->addEmployee($name, $phone, $email, $account_id);
             
             if ($result === true) {
                 echo 1;
             } else {
                 echo "ins_failed: Database error";
             }
         } else {
             echo "ins_failed: Invalid request method";
         }
     }
     
     public function editEmployee() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Debug để xem dữ liệu gửi lên
         error_log(print_r($_POST, true));
         
         $name = $_POST['name'] ?? '';
         $phone = $_POST['phone'] ?? '';
         $email = $_POST['email'] ?? '';
         $account_id = $_POST['account_id'] ?? '';
         $employee_id = $_POST['employee_id'] ?? '';
         
         // Kiểm tra chi tiết hơn
         if (empty($name) || empty($phone) || empty($email) || empty($account_id) || empty($employee_id)) {
             echo "upd_failed: Missing data - Name: $name, Phone: $phone, Email: $email, Account: $account_id", "Employee ID: $employee_id";
             return;
         }
         
         // Thêm nhân viên vào cơ sở dữ liệu
         $result = $this->NhanVienModel->updateEmployee($name, $phone, $email, $account_id, $employee_id);
         
         if ($result === true) {
             echo 1;
         } else {
             echo "upd_failed: Database error";
         }
     } else {
         echo "upd_failed: Invalid request method";
     }
     }


    /**
     * Retrieves all employees from the database and returns them in JSON format.
     * Uses the NhanVienModel to fetch data and encodes the result as a JSON response.
     */
     public function getAll(){
         $employees = $this->NhanVienModel->getAll();
         $data = "";
         foreach ($employees as $row) {  // Dùng foreach thay vì while
            $data .= "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['ten']}</td>
                <td>{$row['so_dien_thoai']}</td>
                <td>{$row['email']}</td> 
                <td>{$row['tai_khoan_id']}</td>
                <td>
                    <div class='btn-group' role='group'>
                        <button type='button' onclick='edit_staff($row[id])' class='btn btn-warning btn-sm edit-link' data-bs-toggle='modal' data-bs-target='#edit-employee'>
                                <i class='bi bi-pencil'></i> Sửa
                        </button>
                        <a href='javascript:void(0)' class='btn btn-danger btn-sm delete-link' data-action='delete' data-id='{$row['id']}' onclick='deleteEmployee({$row['id']})'>
                           <i class='bi bi-trash'></i> Xóa
                        </a>
                    </div>
                </td>      
            </tr>
            ";
        }
         echo $data;
     }

     public function getEmployeeById() {
         $id = $_POST['get_employee'];
         $employee = $this->NhanVienModel->getUserById($id);
         echo json_encode($employee);
     }
     
     public function deleteEmployee() {
        // Gọi model để xóa nhân viên
        // Tránh các lệnh echo không cần thiết
        header('Content-Type: application/json');
       

    $id = $_POST['id'];

$result = $this->NhanVienModel->deleteEmployee($id);

if ($result) {
    echo json_encode(['status' => 'success']);
    return;
} else {
    echo json_encode(['status' => 'error']);
    return;
}
exit;  // Kết thúc ngay sau khi gửi JSON



    
   }}
?>