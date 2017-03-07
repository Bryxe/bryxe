<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/editprofile.js" type="text/javascript"></script>

<?php
if ($_REQUEST['closeme']) {
    echo "<script>window.parent.location = '" . BASE_URL . "showposts';</script>";//reload showposts to update the image
    return;
}
?>

<?php if (!$_SESSION["firstTimeSignup"]) { ?>
    <div class="btn-group" style="width: 100%">
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_account'">Account
        </button>
        <button type="button" class="btn btn-info" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_profile'">Profile
        </button>
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_password'">Password
        </button>
    </div>
<?php } ?>
<div class="verticalSpacer" style="height: 10px"></div>

<section class="slideSection slideEditProfile">
    <header>
        <div class="title">Public info everyone sees</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()"
         style="display:  <?= ($edit_profile_message == '') ? 'none' : 'block'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage">
            <?php
            if ($edit_profile_message != '') {
                echo $edit_profile_message;
            }
            ?>
        </span>
    </div>

    <form role="form" onsubmit="return validateData()" target="_self" name="editUserProfile" id="new_post" method="post"
          enctype="multipart/form-data" action="">

        <!-- Hidden Values -->
        <input type="hidden" name="editUserProfileSubmit" value="1">

        <input type="hidden" name="timeZone" id="timeZone" class="text_box" value="<?php echo($timeZone); ?>">
        <input type="hidden" name="city" id="city" class="text_box" value="<?php echo($city); ?>">
        <input type="hidden" name="country" id="country" class="text_box" value="<?php echo($country); ?>">
        <input type="hidden" name="uname" id="uname" class="text_box" value="<?php echo($username); ?>">
        <input type="hidden" name="fullName" id="fullName" class="text_box" value="<?php echo($fullName); ?>">
        <input type="hidden" name="state" id="state" class="text_box" value="<?php echo($state); ?>">
        <input type="hidden" name="email" id="email" class="text_box" value="<?php echo($email); ?>">
        <input type="hidden" name="protect" id="protect" value="<?php echo $protect; ?>">
        <input type="hidden" name="nwUpswd" id="nwUpswd" value="">
        <!-- Hidden Values -->

        <div class="bigButton uploadPhoto">
            <input class="photoUpload" id="file_1" name="imagefile" type='file' accept="image/*"
                   onchange="processPhoto(this);"/>
            <div class="buttonImage">
                <?php
                $defaultImg = ($user_local_image_thumb_path != '') ? $user_local_image_thumb_path : IMAGES_PATH . "/template/camera@2x.png";
                $imgSelectTitle = ($user_local_image_thumb_path != '') ? "current photo" : "select photo";
                $imgSelectSubTitle = ($user_local_image_thumb_path != '') ? "click to change" : "no photo selected";
                ?>
                <img class="photoUploadIcon" src="<?php echo $defaultImg; ?>" height="45" alt="add photo">
                <img id="prevImage" height="45" width="auto">
            </div>
            <div class="btnTitle"><?php echo $imgSelectTitle; ?></div>
            <div class="btnSubtitle"><?php echo $imgSelectSubTitle; ?></div>

        </div>
        <aside class="bigButtonCaption clearfix">
            <span class="glyphicon glyphicon-arrow-left"></span>
            This is the picture to identify you everywhere
        </aside>

        <textarea id="bioDesc" name="bioDesc" class="form-control counterLimit profileText" rows="5"
                  placeholder="tell about yourself in 170 characters"
                  maxlength="170"><?php echo($bioDesc); ?></textarea>
        <input type="text" class="form-control profileUrl" name="webPg" id="webPg"
               placeholder="put your webpage or blog address here" value="<?php echo($webPg); ?>">

        <div class="verticalSpacer" style="height: 8px"></div>

        <button type="button" onclick="window.location = '<?php echo BASE_URL . "edit_profile?closeme=1"; ?>'"
                class="btn btn-primary floatLeft clearfix">Cancel
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Done</strong></button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>