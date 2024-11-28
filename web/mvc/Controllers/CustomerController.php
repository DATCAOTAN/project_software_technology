<?php  
   class CustomerController extends Controller{
    //   protected $Homemodel;
    //   public function __construct() {
    //      $this->Homemodel = $this->model("HomeModel");
    //   }
      public function index(){  
         $this->view("customer",['page'=>'home',
                                    'pageTitle'=>'Coffee shop'
         ]);
      }
   }
?>