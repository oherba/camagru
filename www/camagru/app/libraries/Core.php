<?php 
    /*
        +app core classs
        +creates URL + loads core controller
        +URL format -/controller/method/params
    */


    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];


        public function __construct()
        {
            //print_r($this->getUrl());
            $url = $this->getUrl();
            //Look in controllers for first value
            ///it gives an error accessing 4url[0]
            if (isset($url[0]) && file_exists('../app/controllers/' .ucwords($url[0].'.php')))
            {
                //if exists ,set as controller
                $this->currentController = ucwords($url[0]);
                //unset 0 index
                unset($url[0]);
            }
            //Require the controller
            require_once '../app/controllers/'.$this->currentController . '.php';
            //Instatiate controller class
            $this->currentController = new $this->currentController;
            //check of d seconde part of url
            if (isset($url[1]))
            {
                //check to see if the methode exisists in controller
                if(method_exists($this->currentController,$url[1]))
                {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }
            //echo $this->currentMethod;
            //Get params
            $this->params = $url ? array_values($url) : [];
            //print_r($this->params);            //call a callback with array of params
            call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
            
        }
        public function getUrl(){
            if (isset($_GET['url']))
            {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url,FILTER_SANITIZE_URL);
                $url = explode('/',$url);
                return $url;
            }
        }
    }

   // $core1 = new Core;
?>