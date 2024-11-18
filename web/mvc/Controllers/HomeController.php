<?php  
   class HomeController extends Controller{
      protected $Homemodel;
      public function __construct() {
         $this->Homemodel = $this->model("HomeModel");
      }
      public function index(){  
         // $leftmenu= $this->showLeftmenu();
         $this->view("master_layout",['page'=>'home',
                                    'pageTitle'=>'Quiz'
                                    // 'view'=>$leftmenu
         ]);
      }
      public function showLeftmenu(){
         $userId = $_POST['userId'];
         $user= $this->Homemodel->getTinhNangByQuyen($userId);
         header('Content-Type: application/json');
         echo json_encode($user);
      }
      public function showData($id){
         $user= $this->Homemodel->getthongtintaikhoan($id);
         header('Content-Type: application/json');
         echo json_encode($user);
      }
   }
?>