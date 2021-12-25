<?php
    class User {
        public function __construct()
        {
           // echo dirname(__FILE__);
            $this->db = new DATABASE;
        }
        //find user by email
        public function findUserByUsername($username)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE username= :username');
            //echo "kikakkk";
            //$this->db->query('select * from users where email = :email');
            $this->db->bind(':username', $username);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0)
            {
                return true;
            }
            else
                return false;
        }

        public function findUserByEmail($email)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE email= :email');
            //echo "kikakkk";
            //$this->db->query('select * from users where email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0)
            {
                return true;
            }
            else
                return false;
        }

        public function returnUserByEmail($email)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE email= :email');
            //echo "kikakkk";
            //$this->db->query('select * from users where email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0)
            {
                return $row;
            }
            else
                return false;
        }

        public function register($data)
        {
            $this->db->query('INSERT INTO camagru.users (username,email,password,token) VALUES(:username,:email,:password,:token)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':token', $data['token']);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }

        }
        public function  send_activation_email($email,$token)
        {
            //create the activation link
            $activation_link = URLROOT."/users/activate?email=$email&token=$token";
            $header = "From: no-reply@camagru.com";
            //set email subject & body
            $subject = 'Please activate your account';
            $message = 'Welcome to Camagru.
            To validate your account, please click on the link below or copy it.
             '
            . $activation_link .
            '
                ---------------
            This mail was send automatically, please do not reply.';
            mail($email, $subject, $message, $header);
        }

        public function  send_reset_password_email($email,$token)
        {
            //create the reset link
            $reset_link = URLROOT."/users/reset_password?email=$email&pwd_token=$token";
            $header = "From: no-reply@camagru.com";
            //set email subject & body
            $subject = 'Please your password';
            $message = 'Welcome to Camagru.
            To reset your password, please click on the link below or copy it.
             '
            . $reset_link .
            '
                ---------------
            This mail was send automatically, please do not reply.';
            mail($email, $subject, $message, $header);
        }

        public function check_token($token,$user_token)
        {
            if ($token == $user_token)
                return true;
            else
                return false;
        }

        public function is_activated($active)
        {
            if ($active == 1)
                    return true;
                else
                    return false;
        }

        public function activate_user($email)
        {
            $this->db->query('UPDATE camagru.users SET active = 1 WHERE email=:email');
            $this->db->bind(':email', $email);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function setPwdToken($email,$pwd_token)
        {
            $this->db->query('UPDATE camagru.users SET pwd_token = :pwd_token WHERE email=:email');
            $this->db->bind(':pwd_token', $pwd_token);
            $this->db->bind(':email', $email);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function editProfile($username,$email)
        {
            //die($username);
            $this->db->query('UPDATE camagru.users SET username=:username ,email=:email WHERE id=:id');
            $this->db->bind(':username', $username);
            $this->db->bind(':email', $email);
            $this->db->bind(':id', $_SESSION['user_id']);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function setPassword($email,$password)
        {
            $this->db->query('UPDATE camagru.users SET password = :password WHERE email=:email');
            $this->db->bind(':password', $password);
            $this->db->bind(':email', $email);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function deleteToken($email)
        {
            $this->db->query('UPDATE camagru.users SET token = "" WHERE email=:email');
            $this->db->bind(':email', $email);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function deletePwdToken($email)
        {
            $this->db->query('UPDATE camagru.users SET pwd_token = "" WHERE email=:email');
            $this->db->bind(':email', $email);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        public function login($username, $password)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE username = :username');
            $this->db->bind(':username',$username);
            $row = $this->db->single();
            $hashed_password = $row->password;
            if(password_verify($password,$hashed_password))
            {
               return $row;
            }
            else {
                return false;
            }

        }

        public function check_old_pass($username, $password)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE username = :username');
            $this->db->bind(':username',$username);
            $row = $this->db->single();
            $hashed_password = $row->password;
            if(password_verify($password,$hashed_password))
            {
               return true;
            }
            else {
                return false;
            }

        }

        public function getUserById($id)
        {
            $this->db->query('SELECT * FROM camagru.users WHERE id=:id');
            $this->db->bind(':id',$id);
            $user = $this->db->single();
            return $user;
        }
    }



?>