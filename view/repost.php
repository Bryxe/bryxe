<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/repost.js" type="text/javascript"></script>

<section class="slideSection slideRepost">
    <header>
        <div class="title">Repost to Viewers</div>
    </header>
    <hr>
    <section class="postContent" onclick="$('.postedTextBody', this).toggleClass('collapsed')">
        <?php if ($oldimage != '') { ?>
            <div class="postedImageLink">
                <img class="postedImage" src="<?php echo $oldimage; ?>" width="48">
            </div>
            <?php
        }
        ?>
        <p class="postedTextTitle"><?php echo $oldtitle; ?></p>
        <p class="postedTextBody clearfix"><?php echo $oldmessage; ?></p>
    </section>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>

    <form role="form" onsubmit="return validateNewPost()" target="_parent" name="re_post" id="new_post" method="post"
          enctype="multipart/form-data" action="<?php echo BASE_URL; ?>showposts">

        <input type="hidden" name="repost_submit" value="1">

        <input type="hidden" name="old_title" value="<?php echo trim($oldtitle); ?>">
        <input type="hidden" name="old_message" value="<?php echo trim($oldmessage); ?>">
        <input type="hidden" name="old_image" value="<?php echo trim($oldimage); ?>">
        <input type="hidden" name="old_fullimage" value="<?php echo trim($oldfullimage); ?>">

        <div class="notifyFriend">
            Notify a friend about your repost
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                <input type="email" name="email" class="form-control postFriendEmail"
                       placeholder="enter your friend's mail">
            </div>
        </div>

        <div class="verticalSpacer" style="height: 16px"></div>

        <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">
            Cancel
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Repost</strong></button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>