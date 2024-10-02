<?php
class Controller{

    public function model($model){
        require_once "./mvc/Models/".$model.".php";
        return new $model;
    }

    public function view($view,array $data=[]){
        foreach($data as $key=>$value)
        {
            $$key=$value;
        }
        require_once "./mvc/Views/".$view.".php";
    }

}
