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
    }
    ?>
    <img class="profileImage" src="<?php echo $user_local_image_thumb_path; ?>">
    <p class="profileFullname"><?php echo $fullName; ?></p>
    <p class="profileUsername clearfix">@<?php echo $username; ?></p>
    <div class="profileBio">
        <?php echo $bioDesc; ?>
        <hr>
        <?php if ($user_url != "") {
            if (strpos($user_url, "://") === false) {
                $user_url = "http://" . $user_url;
            }
            ?>
            <div class="profileWebpage">
                <a target="_blank" href="<?php echo $user_url; ?>">View user's webpage</a>
            </div>
            <?php
        }
        ?>
    </div>


    <div class="verticalSpacer" style="height: 16px"></div>

    <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatRight clearfix">Close
    </button>

    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>