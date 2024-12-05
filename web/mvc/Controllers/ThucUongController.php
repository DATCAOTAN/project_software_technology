<?php  
   class ThucUongController extends Controller{
    private $ChiTietThucUong;
    private $ThucUong;

    

     public function __construct()
     {
      $this->ChiTietThucUong= $this->model('ChiTietThucUongModel');
      $this->ThucUong=$this->model('ThucUongModel');
         
     }
      public function index(){  
         // $leftmenu= $this->showLeftmenu();
         $this->view("master_layout",['page'=>'ThucUong',
                                    'pageTitle' => 'Quản lý Thức uống',
                                    'ThucUong'=> $this->ThucUong->getAll(),
                                    'pageTitle'=>'Coffee shop',
                                    'ChiTietThucUong'=>$this->ChiTietThucUong->getAll()
                                    // 'view'=>$leftmenu
         ]);
      }

      public function get_chitiet($id){
         $chi_tiet = $this->ThucUong->get_chitiet($id);
         if (!$chi_tiet) {
             http_response_code(404);  // Trả về lỗi 404 nếu không tìm thấy dữ liệu
             echo json_encode(['error' => 'Không tìm thấy chi tiết thức uống']);
             return;
         }
         header('Content-Type: application/json');
         echo json_encode($chi_tiet);
     
      }
      public function add() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $name = $_POST['name'] ?? null;
             $description = $_POST['description'] ?? null;
             $sizeSPrice = $_POST['sizeSPrice'] ?? null;
             $sizeMPrice = $_POST['sizeMPrice'] ?? null;
             $sizeLPrice = $_POST['sizeLPrice'] ?? null;
             $sizeSStatus = $_POST['sizeSStatus'] ?? null;
             $sizeMStatus = $_POST['sizeMStatus'] ?? null;
             $sizeLStatus = $_POST['sizeLStatus'] ?? null;
             if( $sizeSStatus=="1"){
                $sizeSStatus="Dang ban";
              }
              else if($sizeSStatus=="0") $sizeSStatus="Het hang";
              else  $sizeSStatus=false;
              if( $sizeMStatus=="1"){
                $sizeMStatus="Dang ban";
              }
              else if($sizeMStatus=="0") $sizeMStatus="Het hang";
              else  $sizeMStatus=false;
              if( $sizeLStatus=="1"){
                $sizeLStatus="Dang ban";
              }
              else if($sizeLStatus=="0") $sizeLStatus="Het hang";
              else  $sizeLStatus=false;
    
            #Kiểm tra dữ liệu cần thiết
            if (!$name || !$description || !$sizeSPrice || !$sizeMPrice || !$sizeLPrice || !$sizeSStatus || !$sizeLStatus || !$sizeMStatus) {
                echo json_encode(['success' => false, 'message' => "Thiếu dữ liệu"]);
                return;
            }
             // Bước 1: Thêm dữ liệu thức uống vào database trước
             $drinkData = [
                 'Ten_thuc_uong' => $name,
                 'Mo_ta' => $description,
                 'Gia_tien_S' => $sizeSPrice,
                 'Gia_tien_M' => $sizeMPrice,
                 'Gia_tien_L' => $sizeLPrice,
                 'Trang_thai_ban_S' => $sizeSStatus,
                 'Trang_thai_ban_M' => $sizeMStatus,
                 'Trang_thai_ban_L' => $sizeLStatus
             ];
          
     
             // Giả sử $thucUongModel là model thao tác với DB
           
             $drinkId = $this->ThucUong->add($drinkData);  // Phương thức add trả về ID của thức uống vừa thêm
             if ($drinkId<1) {
                 echo json_encode(['success' => false, 'message' => 'hello']);
                 return;
                
                 
             }

             // Bước 2: Xử lý ảnh (nếu có)
             header('Content-Type: application/json');
             $imageUrl = '';
             if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                 $imageTmp = $_FILES['image']['tmp_name'];
                 $imageName = $_FILES['image']['name'];
                 $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
     
                 // Kiểm tra loại file ảnh
                 $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                 if (!in_array(strtolower($imageExt), $allowedExts)) {
                     echo json_encode(['success' => false, 'message' => 'File không hợp lệ']);
                     return;
                 }
     
                 // Đổi tên file ảnh theo ID của thức uống
                 $imageNameNew = "image" . $drinkId .'.'. $imageExt;
                 $uploadDir = 'public/images/thuc_uong/';  // Đảm bảo thư mục này tồn tại và có quyền ghi
                 $imageUrl = $uploadDir . $imageNameNew;
                
     
     
                 // Di chuyển tệp ảnh vào thư mục
                 if (!move_uploaded_file($imageTmp, $imageUrl)) {
                     echo json_encode(['success' => false, 'message' => 'Lỗi khi tải ảnh lên']);
                     return;
                 }
                 else{
                  echo json_encode(['success' => True, 'message' => 'Thêm thành công','data'=> $this->ThucUong->getAll()]);
                     return;
                 }
             }
             else 
             {
               echo json_encode(['success' => True, 'message' => 'Phai them anh','data'=> $this->ThucUong->getAll()]);
                 return;
             }
          
     
         
         } else {
             echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
         }
     }

     public function delete($ID)  {
        $flag = $this->ThucUong->delete($ID);
        if (!$flag) {
            http_response_code(404);  // Trả về lỗi 404 nếu không tìm thấy dữ liệu
            echo json_encode(['error' => 'Xóa không được ']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode( $this->ThucUong->getAll());

     }

     public function edit($ID)
     {
         

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ POST
            $check=false;
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;
            $sizeSPrice = $_POST['sizeSPrice'] ?? null;
            $sizeMPrice = $_POST['sizeMPrice'] ?? null;
            $sizeLPrice = $_POST['sizeLPrice'] ?? null;
            $sizeSStatus = $_POST['sizeSStatus'] ?? null;
            $sizeMStatus = $_POST['sizeMStatus'] ?? null;
            $sizeLStatus = $_POST['sizeLStatus'] ?? null;
            if( $sizeSStatus=="1"){
                $sizeSStatus="Dang ban";
              }
              else if($sizeSStatus=="0") $sizeSStatus="Het hang";
              else  $sizeSStatus=false;
              if( $sizeMStatus=="1"){
                $sizeMStatus="Dang ban";
              }
              else if($sizeMStatus=="0") $sizeMStatus="Het hang";
              else  $sizeMStatus=false;
              if( $sizeLStatus=="1"){
                $sizeLStatus="Dang ban";
              }
              else if($sizeLStatus=="0") $sizeLStatus="Het hang";
              else  $sizeLStatus=false;
    
            #Kiểm tra dữ liệu cần thiết
            if (!$name || !$description || !$sizeSPrice || !$sizeMPrice || !$sizeLPrice || !$sizeSStatus || !$sizeLStatus || !$sizeMStatus) {
                echo json_encode(['success' => false, 'message' => "Thiếu dữ liệu"]);
                return;
            }
    
            // Bước 1: Thêm dữ liệu thức uống vào database trước
            $drinkData = [
                'Ten_thuc_uong' => $name,
                'Mo_ta' => $description,
                'Gia_tien_S' => $sizeSPrice,
                'Gia_tien_M' => $sizeMPrice,
                'Gia_tien_L' => $sizeLPrice,
                'Trang_thai_ban_S' => $sizeSStatus,
                'Trang_thai_ban_M' => $sizeMStatus,
                'Trang_thai_ban_L' => $sizeLStatus
            ];

            $imageUrl = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageName = $_FILES['image']['name'];
                $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
                $check=true;
             
    
                // Kiểm tra loại file ảnh
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($imageExt), $allowedExts)) {
                    echo json_encode(['success' => false, 'message' => 'File không hợp lệ']);
                    return;
                }
    
                // Đổi tên file ảnh theo ID của thức uống
                $imageNameNew = "image" . $ID .'.jpg';
                $uploadDir = 'public/images/thuc_uong/';  // Đảm bảo thư mục này tồn tại và có quyền ghi
                $imageUrl = $uploadDir . $imageNameNew;


                // Kiểm tra xem tệp có tồn tại không
                if (file_exists($imageUrl)) {
                    // Xóa tệp
                    unlink($imageUrl);
                        
                }
     
    
                // Di chuyển tệp ảnh vào thư mục
                if (!move_uploaded_file($imageTmp, $imageUrl)) {
                    echo json_encode(['success' => false, 'message' => 'Lỗi khi tải ảnh lên']);
                    return;
                }
                else{
                    
                    $flag = $this->ThucUong->edit($ID,$drinkData,$check);
                   $data=$this->ThucUong->getAll();
                   header('Content-Type: application/json');
            if ($flag) {
                echo json_encode(['success' => True, 'message' => 'Sửa thành công','data'=>$data]);
                return;
            }
            else{
                echo json_encode(['success' => True, 'message' => 'Sửa ảnh thành công','data'=>$data]);
                return;
            }
                }
            }
            else 
            {
             
            $flag = $this->ThucUong->edit($ID,$drinkData,$check);
            if ($flag) {
                $data=$this->ThucUong->getAll();
                echo json_encode(['success' => True, 'message' => 'Sửa thành công','data'=>$data]);
                return;
            }
            else{
                echo json_encode(['success' => False, 'message' => 'hãy thay đổi dữ liệu']);
                return;
            }

            }
         
    
        
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
     }
     public function search()  {
       
        $data = $this->ThucUong->searchByName($_POST['keyword']);
        if (count($data)<=0) {
          
            echo json_encode(['success' => false,'data'=>$data]);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => True,'data'=>$data]);


     }
     
   }
     
?>