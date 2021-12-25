<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
                <div class="user singinBx">
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/editProfile.png">
                    </div>
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/editProfile" method="POST">
                            <?php  flash('register_success')?>
                            <h2>Edit Your Profile</h2>
                            <input type="text" name="username" placeholder="Edit username" 
                                class=" <?php echo(!empty($data['username_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['username'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['username_err'];?></span>
                            <input type="email" name="email" placeholder="Edit email"
                                class=" <?php echo(!empty($data['email_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['email'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['email_err'];  echo "<br>";?></span>
                            <input type="submit" name="" value="Update" class="border-none">
                            <!-- <p class="signup"> Can't remember your password? <a href="<?php echo URLROOT;?>/users/forgot_password">Click here!.</a></p> -->
                            <!-- <p class="signup"> Don't have an account ? <a href="<?php echo URLROOT;?>/users/register">Sign Up.</a></p> -->
                            
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