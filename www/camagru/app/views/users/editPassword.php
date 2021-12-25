<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
                <div class="user singinBx">
                    <div class="imgBx">
                        <img src="<?php echo URLROOT;?>/public/images/editProfile.png">
                    </div>
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/users/editPassword" method="POST">
                            <?php  flash('register_success')?>
                            <h2>Change Password</h2>
                            <input type="password" name="old_password" placeholder="Old Password"
                                class=" <?php echo(!empty($data['old_password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['old_password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['old_password_err'];?></span>
                            <input type="password" name="new_password" placeholder="New Password"
                                class=" <?php echo(!empty($data['new_password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['new_password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['new_password_err'];?></span>
                            <input type="password" name="confirm_new_password" placeholder="Confirm New Password"
                                class=" <?php echo(!empty($data['confirm_new_password_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['confirm_new_password'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['confirm_new_password_err']; echo "<br>";?></span>
                            <input type="submit" name="" value="Update" class="border-none">
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