<header >
           <a href="<?php echo URLROOT;?>" class="logo"><?php echo SITENAME;?></a>
           <ul class="navigation">
               <li><a href="<?php echo URLROOT;?>/posts">Gallery</a></li>
               <!-- <li><a href="<?php echo URLROOT;?>/pages/about">About</a></li> -->
               <?php if(isset($_SESSION['user_id'])) {?>
                <li><a href="<?php echo URLROOT;?>/posts/studio">Studio</a></li>
                <li><a href="#">Welcome <?php echo $_SESSION['user_name']; ?></a></li>
               <?php } else { ?>
               <li><a href="<?php echo URLROOT;?>/users/register">Register</a></li>
               <li><a href="<?php echo URLROOT;?>/users/login">Login</a></li>
               <?php }?>
              
           </ul>
           <?php if(isset($_SESSION['user_id'])) {?>
                <div class="action">
                    <div class="profile" onclick="menuToggle();">
                        <img src="<?php echo URLROOT;?>/public/images/prof.png">">
                    </div>
                    <div class="menu">
                        <h3> TOTO Famous <br><span>Web Camagru</span></h3>
                        <ul>
                            <li><img src="<?php echo URLROOT;?>/public/images/user.png"><a href="#">My profile</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/edit.png"><a href="<?php echo URLROOT;?>/users/editProfile">Edit Profile</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/edit.png"><a href="<?php echo URLROOT;?>/users/editPassword">Edit Password</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/inbox.png"><a href="#">Inbox</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/settings.png"><a href="#">Settings</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/help.png"><a href="#">Help</a></li>
                            <li><img src="<?php echo URLROOT;?>/public/images/logout.png"><a href="<?php echo URLROOT;?>/users/logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            <?php }?>
           <!-- <div class="search">
               <input type="text" placeholder="Search">
               <i class="fas fa-search"></i>
           </div> -->
           <script>
               function menuToggle()
               {
                   const toggleMenu = document.querySelector('.menu');
                   toggleMenu.classList.toggle('activeMenu')
               }
           </script>
</header>