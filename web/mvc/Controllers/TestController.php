<?php  
   class TestController extends Controller{
      protected $Homemodel;
      public function __construct() {
         $this->Homemodel = $this->model("HomeModel");
      }
      public function index(){  
         $this->view("master_layout",['page'=>'test',
                                    'pageTitle'=>'Coffee shop'
         ]);
      }
   }
?>