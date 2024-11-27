<?php  
   class MenuController extends Controller{
      protected $MenuModel;
      public function __construct() {
         $this->MenuModel = $this->model("MenuModel");
      }

      public function index() {
         // Kiểm tra xem cookie userID có tồn tại không
         if (!isset($_COOKIE['userID'])) {
             // Nếu không có cookie, tạo khách hàng mới và lưu userID vào cookie
             $userID = $this->MenuModel->createUser();
             // Lưu userID vào cookie, có thể thiết lập thời gian hết hạn là 30 ngày
             setcookie('userID', $userID, time() + (30 * 24 * 60 * 60), '/'); // Cookie tồn tại trong 30 ngày
         } else {
             // Nếu đã có cookie, lấy userID từ cookie
             $userID = $_COOKIE['userID'];
         }
 
         // Truyền userID vào view hoặc sử dụng theo nhu cầu
         $this->view("menu_layout", ['userID' => $userID, 'paymentMethods' => $this->getTest()]);
     }

      public function getTotalDrinks() {
         $total = $this->MenuModel->getTotalDrinks();  // Lấy tổng số món uống từ model
         echo $total;  // Trả về số lượng món uống
      }

      // Fetch payment methods and return them as JSON
      public function getTest() {
         // Fetch payment methods from the model
         $total = $this->MenuModel->getAllPaymentMethods();

         // Convert each PaymentMethodDTO object to an array
         $result = array_map(function($paymentMethod) {
            return [
               'id' => $paymentMethod->getId(),
               'name' => $paymentMethod->getName(),
               'details' => $paymentMethod->getDetails()
            ];
         }, $total);

         // Return the data as an array (for controller or view usage)
         return $result;
      }
     
      public function getDrinksByPage($page = 1) {
         $itemsPerPage = 6;  // Số món mỗi trang
         $drinks = $this->MenuModel->getAllDrinksWithDetails($page, $itemsPerPage);  // Lấy danh sách thức uống từ model
         // Trả về dữ liệu dưới dạng JSON
         $result = array_map(function($item) {
            return $item->toArray();
         }, $drinks);
         header('Content-Type: application/json');
         echo json_encode($result);
      }

      public function createOrder() {
         // Lấy dữ liệu từ POST request
         $orderData = json_decode(file_get_contents('php://input'), true);
 
         $khachHangId = $orderData['customerId'];
         $paymentMethod = $orderData['paymentMethod'];
         $totalAmount = $orderData['totalAmount'];
         $items = $orderData['items'];

         $tongTien = $totalAmount; 
 
         // Gọi phương thức trong model để tạo hóa đơn
         try {
             $hoaDonId = $this->MenuModel->createInvoice($khachHangId, $tongTien, $paymentMethod, $items);
 
             // Trả về kết quả thành công
             echo json_encode(['success' => true, 'hoaDonId' => $hoaDonId]);
         } catch (Exception $e) {
             // Nếu có lỗi xảy ra
             echo json_encode(['success' => false, 'message' => $e->getMessage()]);
         }
      }

      public function viewOrders() {
         $customerId = $_COOKIE['userID'];
         // Lấy danh sách hóa đơn của khách hàng
         $invoices = $this->MenuModel->getInvoicesByCustomerId($customerId);
         // Trả về dữ liệu dưới dạng JSON
         echo json_encode(['orders' => $invoices]);
      }
   }
?>