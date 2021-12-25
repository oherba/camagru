<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
                <div class="user singinBx">
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/image4.png">
                    </div>
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/reset_password" method="POST">
                            <?php  flash('register_success')?>
                            <h2>Change your password</h2>
                            <input type="password" name="password" placeholder="Password"
                                class=" <?php echo(!empty($data['password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['password_err'];  echo "<br>";?></span>
                            <input type="password" name="confirm_password" placeholder="Confirm password"
                                class=" <?php echo(!empty($data['confirm_password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['confirm_password'];?>">
                                <input type="hidden" name="pwd_token_form" value="<?php if ( isset($_GET['pwd_token_form']) && !empty($_GET['pwd_token_form'])) echo $_GET['pwd_token_form']; ?>">
                                <input type="hidden" name="email_form" value="<?php if ( isset($_GET['email_form']) && !empty($_GET['email_form'])) echo $_GET['email_form']; ?>">
                            <span class="my_invalid_feedback"><?php echo $data['confirm_password_err']; echo "<br>";?></span>
                            <input type="submit" name="" value="Change" class="border-none">
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