<?php 
    class Pages extends Controller{
        public function __construct()
        {
            
           // echo'pages loaded bro';
        }

        public function index()
        {
            //$this->view('hello');
           
            if(isLoggedIn())
            {
                redirect('posts');
            }
            $data = ['title'=> 'Camagru',
        'description'=> 'This is camagru Home'];
            
            $this->view('pages/index',$data);
        }
        public function about()
        {
            //echo' this is about    '.$id;
            $data = ['title'=> 'About us',
            'description'=> 'This is ABOUT'];
            $this->view('pages/about',$data);
        }
    }

?>