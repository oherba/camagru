<?php require APPROOT.'/views/inc/header.php'?>
        <section>
            <div class="register_container" >
               
                <div class="user singinBx">
                    
                    <div class="formBx">
                        <form action="<?php echo URLROOT;?>/posts/edit/<?php echo $data['id'];?>" method="POST">
                            <!-- <?php  flash('register_success')?> -->
                            <a href="<?php echo URLROOT;?>/posts" class="btn btn-light"> <i class="fa fa-backward"></i>Back</a>
                            <h2>Edit Post</h2>
                            <input type="text" name="title" placeholder="title" 
                                class=" <?php echo(!empty($data['title_err']))? 'formati_input_error' : 'border-none'; ?>"
                                value="<?php echo $data['title'];?>">
                            <span class="my_invalid_feedback"><?php echo $data['title_err'];?></span>
                            <textarea name="body" placeholder="body"
                                class=" <?php echo(!empty($data['body_err']))? 'formati_input_error' : 'border-none'; ?>">
                                <?php echo $data['body'];?>
                            </textarea>
                            <span class="my_invalid_feedback"><?php echo $data['body_err'];  echo "<br>";?></span>
                            <input type="submit" name="" value="Save" class="border-none">
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