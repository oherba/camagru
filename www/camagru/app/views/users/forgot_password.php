<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
                <div class="user singinBx">
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/image3.png">
                    </div>
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/forgot_password" method="POST">
                            <?php  flash('register_success')?>
                            <h2>Forgotten Password</h2>
                            <input type="email" name="email" placeholder="Email Address" 
                                class=" <?php echo(!empty($data['email_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['email'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['email_err'];echo "<br>";?></span>
                            <input type="submit" name="" value="Forgot" class="border-none">
                            <p class="signup"> Know your password? <a href="<?php echo URLROOT;?>/users/login">Sign In here.</a></p>
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