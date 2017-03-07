<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/editpassword.js" type="text/javascript"></script>
<?php
if ($_REQUEST['closeme']) {
    echo "<script>window.parent.hideContentSlide();</script>";
    return;
}
?>
<?php if (!$_SESSION["firstTimeSignup"]) { ?>
    <div class="btn-group" style="width: 100%">
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_account'">Account
        </button>
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_profile'">Profile
        </button>
        <button type="button" class="btn btn-info" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_password'">Password
        </button>
    </div>
<?php } ?>
<div class="verticalSpacer" style="height: 10px"></div>

<section class="slideSection slideEditPassword">
    <header>
        <div class="title">Set your password</div>
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

    <form role="form" onsubmit="return validateData()" target="_self" name="editUserPassword" id="new_post"
          method="post" enctype="multipart/form-data" action="">

        <!-- Hidden Values -->
        <input type="hidden" name="editUserPasswordSubmit" value="1">

        <input type="hidden" name="timeZone" id="timeZone" class="text_box" value="<?php echo($timeZone); ?>">
        <input type="hidden" name="city" id="city" class="text_box" value="<?php echo($city); ?>">
        <input type="hidden" name="country" id="country" class="text_box" value="<?php echo($country); ?>">
        <input type="hidden" name="uname" id="uname" class="text_box" value="<?php echo($username); ?>">
        <input type="hidden" name="fullName" id="fullName" class="text_box" value="<?php echo($fullName); ?>">
        <input type="hidden" name="state" id="state" class="text_box" value="<?php echo($state); ?>">
        <input type="hidden" name="email" id="email" class="text_box" value="<?php echo($email); ?>">
        <input type="hidden" name="webPg" id="webPg" class="text_box" value="<?php echo($webPg); ?>">
        <input type="hidden" name="bioDesc" id="bioDesc" class="text_box" value="<?php ($bioDesc); ?>">
        <input type="hidden" name="protect" id="protect" value="<?php echo $protect; ?>">
        <!-- Hidden Values -->

        <input type="password" class="form-control userPassword" name="oldpassword" id="oldpassword"
               placeholder="current password" required="required">
        <a class="forgotPassword" href="<?php echo BASE_URL; ?>forgot" target="_self">Forgot your password?</a>
        <input type="password" class="form-control userNewPassword" name="userPwd" id="userPwd"
               placeholder="new password" required="required">
        <input type="password" class="form-control userNewPasswordConfirm" name="cuserPwd" id="cuserPwd"
               placeholder="confirm password" required="required">

        <div class="verticalSpacer" style="height: 16px"></div>

        <button type="button" onclick="window.location ='<?php echo BASE_URL . "edit_password?closeme=1"; ?>'"
                class="btn btn-primary floatLeft clearfix">Cancel
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Done</strong></button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>