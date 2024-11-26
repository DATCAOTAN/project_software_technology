<?php  
   class MenuController extends Controller{
      protected $Homemodel;
      public function __construct() {
         $this->Homemodel = $this->model("MenuModel");
      }

      public function index(){
         $this->view("menu_layout",
         ['paymentMethods'=>$this->getTest()]);
      }

      public function getTotalDrinks() {
         $total = $this->Homemodel->getTotalDrinks();  // Lấy tổng số món uống từ model
         echo $total;  // Trả về số lượng món uống
      }

      // Fetch payment methods and return them as JSON
      public function getTest() {
         // Fetch payment methods from the model
         $total = $this->Homemodel->getAllPaymentMethods();

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
         $drinks = $this->Homemodel->getAllDrinksWithDetails($page, $itemsPerPage);  // Lấy danh sách thức uống từ model
         // Trả về dữ liệu dưới dạng JSON
         $result = array_map(function($item) {
            return $item->toArray();
         }, $drinks);
         header('Content-Type: application/json');
         echo json_encode($result);
      }
   }
?>