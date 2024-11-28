<?php  
   class BankController extends Controller{
    private $Bank;
   
      public function __construct() {
        $this->Bank= $this->model('BankModel');
      }
      public function index(){  
         $this->view("master_layout",['page'=>'Bank',
                                    'pageTitle'=>'Coffee shop',
                                    'Bank'=>$this->Bank->getAll(),
                                    'Bank_detail'=>$this->Bank->get_all_chi_tiet()
         ]);
      }

      public function add(){  
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ POST
            $name = $_POST['ten'] ?? null;
            $fee = $_POST['fee'] ?? null;
            $id=$_POST['phuong_thuc_thanh_toan_id']??null;
         
            $data = [
                'ten' => $name,
                'fee' => $fee,
                'phuong_thuc_thanh_toan_id'=>$id
            ];
    
            // Giả sử $thucUongModel là model thao tác với DB
          
            $flag = $this->Bank->addDetail($data);  // Phương thức add trả về ID của thức uống vừa thêm
    
            if (!$flag) {
                echo json_encode(['success' => false, 'message' => 'Thêm không được']);
                return;   
            }
            $du_lieu=$this->Bank->chi_tiet($id);
            header('Content-Type: application/json');
            echo json_encode(['success' => True, 'data' => $du_lieu,'message' => 'Thêm thành công']);
            
    
        
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
         
      }

      public function edit($id){  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           // Lấy dữ liệu từ POST
           $name = $_POST['ten'] ?? null;
           $fee = $_POST['fee'] ?? null;
           $phuong_thuc_thanh_toan_id=$_POST['phuong_thuc_thanh_toan_id']??null;
           
        
           $data = [
               'ten' => $name,
               'fee' => $fee,
               'phuong_thuc_thanh_toan_id'=>$phuong_thuc_thanh_toan_id
           ];
   
           // Giả sử $thucUongModel là model thao tác với DB
         
           $flag = $this->Bank->editDetail($id,$data);  // Phương thức add trả về ID của thức uống vừa thêm
   
           if (!$flag) {
               echo json_encode(['success' => false, 'message' => 'Sửa  không được']);
               return;   
           }
           header('Content-Type: application/json');
           $du_lieu=[ 'ten' => $name,
           'fee' => $fee];
           echo json_encode(['success' => True, 'data' => $du_lieu,'message' => 'Sửa  thành công']);
           
       } else {
           echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
       }
        
     }
   
   public function delete(){  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // Lấy dữ liệu từ POS    
     
       $flag = $this->Bank->deleteDetail($_POST['id'],$_POST['phuong_thuc_thanh_toan_id']);  // Phương thức add trả về ID của thức uống vừa thêm

       if (!$flag) {
           echo json_encode(['success' => false, 'message' => 'Xóa  không được']);
           return;   
       }
     
       echo json_encode(['success' => True,'message' => 'Xóa  thành công']);
       
   } else {
       echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
   }
    
 }
   }
?>