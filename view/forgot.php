<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/forgot.js" type="text/javascript"></script>

<?php
if (!empty($_SESSION["username"])) {
    ?>
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
    <div class="verticalSpacer" style="height: 10px"></div>
    <?php
}
?>

<section class="slideSection slideEditPassword">
    <header>
        <div class="title">Forgot password</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()"
         style="display:  <?= ($create_message == '') ? 'none' : 'block'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage">
            <?php
            if ($create_message != '') {
                echo $create_message;
            }
            ?>
        </span>
    </div>

    <form role="form" onsubmit="return validateData()" target="_self" name="new_pass" method="post"
          enctype="multipart/form-data" action="">

        <!-- Hidden Values -->
        <input type="hidden" name="forgot_submit" value="1">

        <!-- Hidden Values -->

        <input type="text" class="form-control userName" placeholder="Enter your username to recover your password."
               name="uname" id="uname" maxlength="42" required="required">

        <div class="verticalSpacer" style="height: 16px"></div>

        <?php
        if (!empty($_SESSION["username"])) {
            ?>
            <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">
                Cancel
            </button>
            <?php
        }
        ?>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Recover</strong>
        </button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>