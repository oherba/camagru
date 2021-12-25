<?php
    class Users extends Controller {
        public function __construct()
        {
            //echo "11111111";
            $this->userModel = $this->model('User');
        }
        public function index()
        {
            //$this->view('hello');
           
            
            $data = ['title'=> 'Camagru',
        'description'=> 'This is camagru Home'];
            
            $this->view('pages/index',$data);
        }
        public function register()
        {
            // check for the Post
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Process form
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'username' =>trim($_POST['username']),
                    'email' =>trim($_POST['email']),
                    'password' =>trim($_POST['password']),
                    'confirm_password' =>trim($_POST['confirm_password']),
                    'username_err' =>'',
                    'email_err' =>'',
                    'password_err' =>'',
                    'confirm_password_err' =>'',
                    'token' => '',
                ];
                //validate name
                if (empty($data['username']))
                {
                    $data['username_err'] = 'Please enter an username';
                }
                //validat email
                if (empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                else
                {
                    //check email
                    if($this->userModel->findUserByEmail($data['email']))
                    {
                        $data['email_err'] = 'Email already taken ';
                    }
                }
                //validate password
                if (empty($data['password']))
                {
                    $data['password_err'] = 'Please enter password';
                }
                elseif(strlen($data['password']) < 6)
                {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }
                //validate confirm password
                if (empty($data['confirm_password']))
                {
                    $data['confirm_password_err'] = 'Please confirm your password';
                }
                else
                {
                    if ($data['password'] != $data['confirm_password'])
                    {
                        $data['confirm_password_err'] = 'Passwords do not match' ;  
                    }
                }
                //Make sure errors are empty
                if (empty ($data['username_err']) && empty($data['email_err']) &&
                    empty ($data['password_err']) && empty ($data['confirm_password_err']))
                {
                    //VALIDATED
                    //create token
                    $token = generate_activation_token();
                    //hash password
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                    //hash token
                    $data['token'] = password_hash($data['token'],PASSWORD_DEFAULT);
                    //register user
                   if($this->userModel->register($data))
                   {
                       $this->userModel->send_activation_email($data['email'],$data['token']);
                       flash('register_success', 'Please check your email to activate your account before signing in');
                       redirect('users/login');
                   }
                   else{
                       die('Something went wrong');
                   }
                   // die('SUCCESS');
                }
                else
                {
                    //load view with errors
                    $this->view('users/register', $data);
                }
            }
            else
            {
                // init data
                $data = [
                    'username' =>'',
                    'email' =>'',
                    'password' =>'',
                    'confirm_password' =>'',
                    'username_err' =>'',
                    'email_err' =>'',
                    'password_err' =>'',
                    'confirm_password_err' =>'',
                ];

                //Load view
                $this->view('users/register',$data);
              
            }
        }
        
        public function activate()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                //process link
                //sanirize GET data
                $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
                 // init data
                 $data = [
                    'email' =>trim($_GET['email']),
                    'token' =>trim($_GET['token']),
                    'email_err' =>'',
                    'token_err' =>'',
                ];
                if (empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                if (empty($data['token']))
                {
                    $data['token_err'] = 'no token';
                }
                 //check for user email
                $user = $this->userModel->returnUserByEmail($data['email']);
                if ($user)
                {
                    if ($this->userModel->is_activated($user->active))
                    {
                        $data['email_err'] = 'already verified';
                    }
                    else if($this->userModel->check_token($data['token'], $user->token))
                    {
                        
                    }
                    else
                        $data['email_err'] = 'token not matched';
                }
                else
                {
                    $data['email_err'] = 'No user found';
                }
                if (empty($data['email_err']) &&
                    empty ($data['token_err']))
                {   
                    if ($this->userModel->activate_user($data['email']))
                    {
                        if ($this->userModel->deleteToken($data['email']))
                        {
                            //die('dkheel');
                            flash('register_success', 'Your account has been activated successfully. Please login here.');
                            redirect('users/login');
                        }
                    }
                }
                else if ($data['email_err'] === 'already verified')
                {
                    flash('register_success', 'Your account has been  already activated. Please login here.');
                    redirect('users/login');
                }
                else
                {
                    //die('flashhshshs');
                    flash('activation_success', 'The activation link is not valid, please register again.');
                    redirect('users/register');
                }
            }
            // redirect to the register page in other cases
            // flash('activation_failure', 'The activation link is not valid, please register again.');
            // redirect('users/register');

        }

        public function login()
        {
            // check for the Post
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Process form
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'username' =>trim($_POST['username']),
                    'password' =>trim($_POST['password']),
                    'username_err' =>'',
                    'password_err' =>'',
                ];
                if (empty($data['username']))
                {
                    $data['user_name_err'] = 'Please enter an Username';
                }
                if (empty($data['password']))
                {
                    $data['password_err'] = 'Please enter password';
                }
                //check for user email
                if($this->userModel->findUserByUsername($data['username']))
                {
                    //user found
                }
                else
                {
                    //user not found
                    $data['username_err'] = 'No user found';
                }
                //make sure errors are empty
                if (empty($data['username_err']) &&
                    empty ($data['password_err']))
                {
                    //VALIDATED
                    //check and set logged in user
                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                    if(!$loggedInUser)
                    {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login', $data);
                    }
                    if(is_user_active($loggedInUser))
                    {
                        $this->createUserSession($loggedInUser);
                    }
                    else
                    {
                        //flash('Not activated account', 'Your account is not activated . Please check your email.');
                        //redirect('users/login');
                        $data['username_err'] = 'Your account is not activated . Please check your email.';
                        $this->view('users/login', $data);
                    }
                   
                }
                else
                {
                    //load view with errors
                    $this->view('users/login', $data);
                }
            }
            else
            {
                // init data
                $data = [
                    'username' =>'',
                    'password' =>'',
                    'username_err' =>'',
                    'password_err' =>'',
                ];
                //Load view
                $this->view('users/login',$data);
            }
        }

        public function forgot_password()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Process form
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'email' =>trim($_POST['email']),
                    'email_err' =>'',
                    'pwd_token' => '',
                ];
                if (empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                //check for user email
                else if($this->userModel->findUserByEmail($data['email']))
                {
                    //user found
                }
                else
                {
                    //user not found
                    $data['email_err'] = 'No user with that e-mail address exists.';
                }
                if (empty($data['email_err']))
                {
                    //VALIDATED
                    //create password token
                    $pwd_token = generate_activation_token();
                     //hash token
                     $data['pwd_token'] = password_hash($data['pwd_token'],PASSWORD_DEFAULT);
                     //forgot password 
                    if ($this->userModel->setPwdToken($data['email'],$data['pwd_token']))
                    {
                        $this->userModel->send_reset_password_email($data['email'],$data['pwd_token']);  
                        flash('register_success', 'Please check your email to reset your password');
                        redirect('users/forgot_password');  
                    }
                  
                }
                else
                {
                    //die($data['email']);
                    //load view with errors
                    $this->view('users/forgot_password', $data);
                }

            }
            else
            {
                //init data
                $data = [
                    'email' =>'',
                    'email_err' => '',
                    'pwd_token' => '',
                ];
                //LOAD the view
                $this->view('users/forgot_password',$data);
            }
        }
        public function editProfile()
        {
            if (!isLoggedIn())
            {
                redirect('users/login');
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'username' =>trim($_POST['username']),
                    'email' =>trim($_POST['email']),
                    'username_err' =>'',
                    'email_err' =>'',
                ];
                if (empty($data['username']))
                {
                    $data['user_name_err'] = 'Please enter an Username';
                }
                if (empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                if (empty($data['username_err']) &&
                    empty ($data['email_err']))
                {
                    $editUser = $this->userModel->editProfile($data['username'], $data['email']);
                    if(!$editUser)
                    {
                        // die('kikaaaaa');
                        $data['username_err'] = 'Error or user Not found';
                        $this->view('users/editProfile', $data);
                    }
                    else
                    {
                        $this->updateUserSession($data['email'],$data['username']);
                        flash('register_success', 'Your Profile has been Updated successfully.');
                        //redirect('users/editProfile');
                        $this->view('users/editProfile', $data);
                    }
                }
                else
                {
                    //load view with errors
                    $this->view('users/editProfile', $data);
                }

            }
            else
            {
                //init data
                $data = [
                    'username'=>$_SESSION['user_name'],
                    'email'=>$_SESSION['user_email'],
                    'username_err'=>'',
                    'email_err'=>'',
                ];
                //Load the view
                $this->view('users/editProfile',$data);
            }
        }

        public function editPassword()
        {
            if (!isLoggedIn())
            {
                redirect('users/login');
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'old_password' =>trim($_POST['old_password']),
                    'new_password' =>trim($_POST['new_password']),
                    'confirm_new_password' =>trim($_POST['confirm_new_password']),
                    'old_password_err' =>'',
                    'new_password_err' =>'',
                    'confirm_new_password_err' =>'',
                ];
                if (empty($data['old_password']))
                {
                    $data['old_password_err'] = 'Please enter the old password';
                }
                if (empty($data['new_password']))
                {
                    $data['new_password_err'] = 'Please enter a new passsowrd';
                }
                elseif(strlen($data['new_password']) < 6)
                {
                    $data['new_password_err'] = 'Password must be at least 6 characters';
                }
                if (empty($data['confirm_new_password']))
                {
                    $data['new_password_err'] = 'Please confirm the new passsowrd';
                }
                else
                {
                    if ($data['new_password'] != $data['confirm_new_password'])
                    {
                        $data['confirm_new_password_err'] = 'Passwords do not match' ;  
                    }
                }
                if (!$this->userModel->check_old_pass($_SESSION['user_name'], $data['old_password']))
                {
                    $data['old_password_err'] = 'Password incorrect' ;
                }
                if (empty($data['old_password_err']) &&
                empty($data['new_password_err']) && empty($data['confirm_err_password_err']))
                {
                    $data['new_password'] = password_hash($data['new_password'],PASSWORD_DEFAULT);
                    $editpass = $this->userModel->setPassword( $_SESSION['user_email'],$data['new_password']);
                    if(!$editpass)
                    {
                        $data['username_err'] = 'Error or user Not found';
                        $this->view('users/editProfile', $data);
                    }
                    else
                    {
                        $data = [
                            'old_password' =>'',
                            'new_password' =>'',
                            'confirm_new_password' =>'',
                            'old_password_err' =>'',
                            'new_password_err' =>'',
                            'confirm_new_password_err' =>'',
                        ];
                        flash('register_success', 'Your Password has been Updated successfully.');
                        $this->view('users/editPassword',$data);
                    }

                }
                else
                {
                    //load view with errors
                    $this->view('users/editPassword', $data);
                }

            }
            else
            {
                //init data
                $data = [
                    'old_password' =>'',
                    'new_password' =>'',
                    'confirm_new_password' =>'',
                    'old_password_err' =>'',
                    'new_password_err' =>'',
                    'confirm_new_password_err' =>'',
                ];
                //Load the view
                $this->view('users/editPassword',$data);
            }
        }

        public function reset_password()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email']) && isset($_GET['pwd_token']) )
            {
                //process link
                //sanirize GET data
                $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
                 // init data
                 $data = [
                    'email' =>trim($_GET['email']),
                    'pwd_token' =>trim($_GET['pwd_token']),
                    'email_err' =>'',
                    'pwd_token_err' =>'',
                ];
                if (empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                if (empty($data['pwd_token']))
                {
                    $data['pwd_token_err'] = 'no token';
                }
                 //check for user email
                $user = $this->userModel->returnUserByEmail($data['email']);
                if ($user)
                {
                    if(!($this->userModel->check_token($data['pwd_token'], $user->pwd_token)))
                    {
                        $data['pwd_token_err'] = 'pwd_token not matched';
                    }
                    // else
                    // {
                    //     $data['pwd_token_err'] = 'pwd_token not matched';
                    //     //die('toktoktokotk');
                    // }
                }
                else
                {
                    $data['email_err'] = 'No user found';
                }
                if (empty($data['email_err']) &&
                    empty ($data['pwd_token_err']))
                {   
                    //die('kikaoooa');
                    //if ($this->userModel->deletePwdToken($data['email']))
                    //{
                        redirect("users/reset_password?email_form=".$data['email']."&pwd_token_form=".$data['pwd_token']);
                    //}
                }
                else
                {
                    // die('kikaaaaaa');
                    flash('activation_success', 'The reset link is not valid.');
                    redirect('users/login');
                }
            }

            else if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //die($_POST['pwd_token_form']);
                //Process form
                //sanitize Post data
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                // init data
                $data = [
                    'password' =>trim($_POST['password']),
                    'confirm_password' =>trim($_POST['confirm_password']),
                    'pwd_token_form' =>trim($_POST['pwd_token_form']),
                    'email_form' =>trim($_POST['email_form']),
                    'password_err' =>'',
                    'confirm_password_err' =>'',
                    'pwd_token_form_err' =>'',
                    'email_form_err' =>'',
                ];
                if (empty($data['email_form']))
                {
                    $data['email_form_err'] = 'Please enter email';
                }
                if (empty($data['pwd_token_form']))
                {
                    $data['pwd_token_form_err'] = 'Please enter token';
                }
                //validate password
                if (empty($data['password']))
                {
                    $data['password_err'] = 'Please enter password';
                }
                elseif(strlen($data['password']) < 6)
                {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }
                //validate confirm password
                if (empty($data['confirm_password']))
                {
                    $data['confirm_password_err'] = 'Please confirm your password';
                }
                else
                {
                    if ($data['password'] != $data['confirm_password'])
                    {
                        $data['confirm_password_err'] = 'Passwords do not match' ;  
                    }
                }
                $user = $this->userModel->returnUserByEmail($data['email_form']);
                if ($user)
                {
                    if(!($this->userModel->check_token($data['pwd_token_form'], $user->pwd_token)))
                    {
                        $data['pwd_token_form_err'] = 'pwd_token_form not matched';
                    }
                    
                }
                else
                {
                    $data['email_err_form'] = 'No user found';
                }
                //make sure errors are empty
                if (empty ($data['password_err']) && empty ($data['confirm_password_err']) && 
                    empty ($data['pwd_token_err_form']) && empty ($data['email_err_form']))
                {
                    //VALIDATED
                    if ($this->userModel->deletePwdToken($data['email_form']))
                    {
                        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                        if ($this->userModel->setPassword($data['email_form'],$data['password']))
                        {
                            flash('register_success', 'Your password has been changed successfully. Please login here.');
                            redirect('users/login');
                        }
                    }
                }
                else
                {
                    //load view with errors
                    $this->view('users/change_password', $data);
                }
            }
            else
            {
                $data = [
                    'password' =>'',
                    'confirm_password' =>'',
                    'pwd_token' =>'',
                    'password_err' =>'',
                    'confirm_password_err' =>'',
                    'pwd_token_err' =>'',
                ];
                //die("ksiri");
                //Load view
                $this->view('users/change_password',$data);
            }
            // redirect to the register page in other cases
            // flash('activation_failure', 'The activation link is not valid, please register again.');
            // redirect('users/register');

        }
        

        public function createUserSession($user)
        {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->username;
            redirect('posts');
        }
        public function updateUserSession($user_email,$user_username)
        {
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_name'] = $user_username;
        }

        public function logout()
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');
        }

        
    }


?>