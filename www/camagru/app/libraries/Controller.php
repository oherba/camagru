<?php 
    /*
        +base controller
        +loads the models ans views
    */
    class Controller{
        //Load model
        public function model($model)
        {
           // print_r($model);
            //echo dirname($model)."\n";
           // exit;
            //require model file
            require_once('../app/models/' .$model .'.php');  
            //instatiate model
            return new $model; 
        }

        //load view
        public function view($view, $data = [])
        {
           if (file_exists('../app/views/' .$view. '.php'))
           {
               require_once('../app/views/' .$view. '.php');
           } 
           else {
               //view does not exists
               die('View does not exists');
           }
        }
    }

?>