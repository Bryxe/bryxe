<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/vieworset.js" type="text/javascript"></script>
<section class="slideSection slideViewOrSetProfile">
    <header>
        <div class="title">User profile</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>

    <?php
    if ($user_local_image_thumb_path == '') {
        $user_local_image_thumb_path = IMAGES_PATH . '/template/image.png';
        $user_local_image_path = IMAGES_PATH . '/template/image.png';
    }
    ?>
    <a class="swipebox" rel="gallery-usr-profile" href="<?php echo $user_local_image_path; ?>" target="_new">
        <img class="profileImage" src="<?php echo $user_local_image_thumb_path; ?>">
    </a>
    <p class="profileFullname"><?php echo $fullName; ?></p>
    <p class="profileUsername clearfix">@<?php echo $username; ?></p>
    <p class="profileBio"><?php echo $bioDesc; ?></p>

    <div class="verticalSpacer" style="height: 16px"></div>

    <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">Cancel
    </button>
    <button type="button" onclick="window.location='<?php echo BASE_URL; ?>edit_account'"
            class="btn btn-primary floatRight clearfix"><strong>Edit account</strong></button>

    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>