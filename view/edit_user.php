<body>
<style type="text/css">
    .title_left {
        width: 100px;
    }
</style>
<div class="main_bg">
    <div class="header_main">
        <div class="popup_main">
            <form name="editProfile" method="post" enctype="multipart/form-data" action="">
                <input type="hidden" name="editProfileSubmit" value="1">
                <?php if ($_SESSION['mes'] != '') { ?>
                    <br/><span class="operationMessages"><?php echo $_SESSION['mes']; ?></span>
                <?php } ?>

                <div class="title_div">
                    <div class="title_left font-gray">Username:</div>
                    <div class="title_right"><input type="text" name="uname" id="uname" class="text_box"
                                                    value="<?php echo $username; ?>"></div>
                </div>

                <div class="title_div">
                    <div class="title_left font-gray">Full Name:</div>
                    <div class="title_right"><input type="text" name="fullName" id="fullName" class="text_box"
                                                    value="<?php echo $fullName; ?>"></div>
                </div>

                <div class="title_div">
                    <div class="title_left font-gray">City:</div>
                    <div class="title_right"><input type="text" name="city" id="city" class="text_box"
                                                    value="<?php echo pack('H*', str_replace('0', '', bin2hex($city))); ?>">
                    </div>
                </div>

                <div class="title_div">
                    <div class="title_left font-gray">State:</div>
                    <div class="title_right"><input type="text" name="state" id="state" class="text_box"
                                                    value="<?php echo pack('H*', str_replace('0', '', bin2hex($state))); ?>">
                    </div>
                </div>


                <div class="title_div">
                    <div class="title_left font-gray">Email:</div>
                    <div class="title_right"><input type="text" name="email" id="email" class="text_box"
                                                    value="<?php echo pack('H*', str_replace('0', '', bin2hex($email))); ?>">
                    </div>
                </div>

                <div class="title_div">
                    <div class="title_left font-gray">Web Page:</div>
                    <div class="title_right"><input type="text" name="webPg" id="webPg" class="text_box"
                                                    value="<?php echo pack('H*', str_replace('0', '', bin2hex($webPg))); ?>">
                    </div>
                </div>

                <div class="title_div">
                    <div class="title_left font-gray">Bio Desc:</div>
                    <div class="title_right"><input type="text" name="bioDesc" id="bioDesc" class="text_box"
                                                    value="<?php echo pack('H*', str_replace('0', '', bin2hex($bioDesc))); ?>">
                    </div>
                </div>

                <input type="hidden" name="protect" id="protect" value="<?php echo $protect; ?>">
                <input type="hidden" name="timeZone" id="timeZone" value="<?php echo $timeZone; ?>">

                <div class="button_div">
                    <a href="<?php echo BASE_URL; ?>showposts" target="_parent"><input type="button" name="cancel"
                                                                                       value="Cancel"
                                                                                       class="button margin_left"
                                                                                       onClick="window.parent.location='<?php echo BASE_URL; ?>showposts'"></a>
                </div>

                <div style="clear:both;"></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

