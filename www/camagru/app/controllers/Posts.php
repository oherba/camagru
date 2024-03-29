<?php 
    class Posts extends Controller
    { 
        public function __construct()
        {
            if (!isLoggedIn())
            {
                redirect('users/login');
            }
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }
        public function index()
        {
            $posts = $this->postModel->getPosts();
            $data = ['posts' => $posts];
            $this->view('posts/index',$data);
        }
        public function studio()
        {
            $data = [];
            $this->view('posts/studio',$data);
        }

        public function mergePic()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['camPicData']))
            
                // Create image instances
                $src = imagecreatefrompng(APPROOT.'/controllers/'.$_POST['filter']);
                $dest = imagecreatefrompng($_POST['camPicData']);
                // Copy and merge
                imagecopy($dest, $src, 0, 0, 0, 0, 150, 150);
                // Output and free from memory
                header('Content-Type: image/gif');
                imagepng($dest);
                
                imagedestroy($dest);
                imagedestroy($src);
        
            
           
                //stock the image in project folder
                //save the path of the stocked image in the database
                //return the path
           
            //$array = ['userName' => $name, 'computedString' => $computedString];
            //echo json_encode($array);
            //merge the captured pic with the selected sticker
            //where is the captured pic 
            
            //i can get the stic with get
        }
        public function add()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //sanitise Post array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = ['title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => trim($_SESSION['user_id']),
                    'title_err' => '',
                    'body_err' => ''];
                //validate data
                if (empty($data['title']))
                {
                    $data['title_err'] = 'Please enter body title';
                }
                if (empty($data['body']))
                {
                    $data['body_err'] = 'Please enter body text';
                }
                //make sure  no errors
                if (empty($data['title_err']) && empty($data['body_err']))
                {
                    //Valdidated
                    if($this->postModel->addPost($data))
                    {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    }
                    else
                    {
                        die('Something went wrong');
                    }
                }
                else
                {
                    //Load the view witn the errors
                    $this->view('posts/add',$data);
                }

            }
            else
            {
                $data = ['title' => '',
                'body' => '',
                'title_err' => '',
                'body_err' => ''];
                $this->view('posts/add',$data);
            }
           
            
        }

        public function edit($id)
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //sanitise Post array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => trim($_SESSION['user_id']),
                    'title_err' => '',
                    'body_err' => ''];
                //validate data
                if (empty($data['title']))
                {
                    $data['title_err'] = 'Please enter body title';
                }
                if (empty($data['body']))
                {
                    $data['body_err'] = 'Please enter body text';
                }
                //make sure  no errors
                if (empty($data['title_err']) && empty($data['body_err']))
                {
                    //Validated
                    if($this->postModel->updatePost($data))
                    {
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    }
                    else
                    {
                        die('Something went wrong');
                    }
                }
                else
                {
                    //Load the view witn the errors
                    $this->view('posts/edit',$data);
                }

            }
            else
            {
                //Get existing p ost from model
                $post = $this->postModel->getPostById($id);
                //Check for owner
                if ($post->user_id != $_SESSION['user_id'])
                {
                    redirect('posts');
                }
                $data = ['title' => $post->title,
                'body' =>  $post->body,
                'title_err' => '',
                'body_err' => '',
                'id' => $id];
                $this->view('posts/edit',$data);
            }
           
            
        }

        public function show($id)
        {
            $post = $this->postModel->getPostById($id);
            $user =$this->userModel->getUserById($post->user_id);

            $data = ['user' => $user,
                    'post' => $post];
            $this->view('posts/show',$data);
        }

        public function delete($id)
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Get existing p ost from model
                $post = $this->postModel->getPostById($id);
                //Check for owner
                if ($post->user_id != $_SESSION['user_id'])
                {
                    redirect('posts');
                }
                if($this->postModel->deletePost($id))
                {
                    flash('post_message', 'Post Removed');
                    redirect('posts');
                }
                else
                {
                    die('Somthing went wrong');
                }
            }
            else
            {
                redirect('posts');
            }

        }
    }




?>