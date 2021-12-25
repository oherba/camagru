<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
                <div class="user singinBx">
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/image1.png">
                    </div>
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/login" method="POST">
                            <?php  flash('register_success')?>
                            <h2>Sign In</h2>
                            <input type="text" name="username" placeholder="Username" 
                                class=" <?php echo(!empty($data['username_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['username'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['username_err'];?></span>
                            <input type="password" name="password" placeholder="Password"
                                class=" <?php echo(!empty($data['password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['password_err'];  echo "<br>";?></span>
                            <input type="submit" name="" value="Login" class="border-none">
                            <p class="signup"> Can't remember your password? <a href="<?php echo URLROOT;?>/users/forgot_password">Click here!.</a></p>
                            <p class="signup"> Don't have an account ? <a href="<?php echo URLROOT;?>/users/register">Sign Up.</a></p>
                            
                        </form>
                    </div>
                </div> 
               
            </div>
        </section>
        <script type="text/javascript">
            function toggleForm()
             {
                 var register_container = document.querySelector('.register_container');
                 register_container.classList.toggle('active');
             }
        </script>
<?php require APPROOT.'/views/inc/footer.php'?>