<?php  
   class HomeController extends Controller{
      protected $Homemodel;
      public function __construct() {
         $this->Homemodel = $this->model("HomeModel");
      }
      public function index(){  
         $this->view("master_layout",['page'=>'home',
                                    'pageTitle'=>'Coffee shop'
         ]);
      }
   }
?>