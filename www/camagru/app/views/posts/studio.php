<?php require APPROOT.'/views/inc/header.php'?>
<section>
        <div class="container bobo">
            <div class="row">
                <div class="col-sm filter">
                    <div class="" id="">
                        <div class="">
                            <div class="">
                                <input type="radio" name="filter" value="filter1" id="filter1" onchange="live_filter()" />
                                <label for="filter1">
                                    <img src="<?php echo URLROOT;?>/public/images/filter1.png" alt="" /> 
                                </label>
                            </div>
                            <div class="">
                                <input type="radio" name="filter" value="filter2" id="filter2" onchange="live_filter()"/>
                                <label for="filter2">
                                    <img src="<?php echo URLROOT;?>/public/images/filter2.png" alt="" /> 
                                </label>
                            </div>
                            <div class="">
                                <input type="radio" name="filter" value="filter3" id="filter3" onchange="live_filter()"/>
                                <label for="filter3">
                                    <img src="<?php echo URLROOT;?>/public/images/filter3.png" alt="" />
                                </label>
                            </div>
                            <div class="">
                                <input type="radio" name="filter" value="filter4" id="filter4" onchange="live_filter()"/>
                                <label for="filter4">
                                    <img src="<?php echo URLROOT;?>/public/images/filter4.png" alt="" /> 
                                </label>
                            </div>
                            <div class="">
                                <input type="radio" name="filter" value="filter5" id="filter5" onchange="live_filter()" />
                                <label for="filter5">
                                    <img src="<?php echo URLROOT;?>/public/images/filter5.png" alt="" /> 
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm main">
                    <div>
                        <div class="live_filter" id="live_filter"></div>
                        <video id="video" width="400" height="300"></video>
                        <a id="capture"  class="booth-capture-button" disabled>Take photo</a>
                        <canvas id="canvas" width="400" height="300"></canvas>
                    </div>
                </div>
                <div class="col-sm tmb">
                    <img id="photo" src="" alt="">
                </div>
            </div>
        </div>
        
</section>
<?php require APPROOT.'/views/inc/footer.php'?>