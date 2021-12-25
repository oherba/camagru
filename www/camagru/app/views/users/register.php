<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container  <?php 
                echo (isset($_GET['action']) &&  $_GET['action'] == 'register') ?
                 "active" : null ?>">
                <div class="user singupBx">
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/register" method="POST">
                            <h2>Create an account</h2>
                            <input type="text" name="username" placeholder="Username" 
                                class=" <?php echo(!empty($data['username_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['username'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['username_err'];?></span>
                            <input type="email" name="email" placeholder="Email Address" 
                                class=" <?php echo(!empty($data['email_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['email'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['email_err'];?></span>
                            <input type="password" name="password" placeholder="Create Password"
                                class=" <?php echo(!empty($data['password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['password_err'];?></span>
                            <input type="password" name="confirm_password" placeholder="Confirm Password"
                                class=" <?php echo(!empty($data['confirm_password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['confirm_password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['confirm_password_err']; echo "<br>";?></span>
                            <input type="submit" name="" value="register" class="border-none">
                            <p class="signup"> Already have an account ? <a href="<?php echo URLROOT;?>/users/login">Sign In.</a></p>
                        </form>
                    </div>
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/image2.jpeg">
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