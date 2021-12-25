<?php
    session_start();
    //$_SESSION['user'] = 'oherba';
    //flash message hel[per]
     
    function flash($name = '', $message = '', $class = 'alert alert-success')
    {
        if (!empty($name))
        {
            if(!empty($message) && empty($_SESSION[$name]))
            {
                if (!empty($_SESSION[$name]))
                {
                    unset($_SESSION[$name]);
                }
                if (!empty($_SESSION[$name. '_class']))
                {
                    unset($_SESSION[$name. '_class']);
                }
                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;
            }
            elseif (empty($message) && !empty($_SESSION[$name]))
            {
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name.'_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>' ;
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }
    
    function isLoggedIn()
        {
            if(isset($_SESSION['user_id']))
            {
                return true;
            }
            else {
                return false;
            }
        }
    function is_user_active($user)
    {
        //print_r($user);
        if ($user->active == 0)
            return false;
        else
            return true;
    }
     function generate_activation_token()
     {
         return bin2hex(random_bytes(16));
     }
?>