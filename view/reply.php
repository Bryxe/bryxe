<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/reply.js" type="text/javascript"></script>

<section class="slideSection slideReply">
    <header>
        <div class="title">Reply to <strong><?php echo $oldusername; ?></strong></div>
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
        <p class="postedTextBody collapsed clearfix"><?php echo $oldmessage; ?></p>
    </section>
    <div class="verticalSpacer" style="height: 16px"></div>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>

    <form role="form" onsubmit="return validateNewPost()" target="_parent" name="reply" id="new_post" method="post"
          enctype="multipart/form-data" action="<?php echo BASE_URL; ?>showposts">

        <input type="hidden" name="reply_submit" value="1">
        <input type="hidden" name="old_title" value="<?php echo $oldtitle; ?>">
        <input type="hidden" name="postedby_username" value="<?php echo $oldusername; ?>">


        <textarea name="postedTxt" class="form-control counterLimit postText" rows="5" placeholder="enter a reply text"
                  maxlength="200"></textarea>
        <button type="button" style="margin-top: -36px;margin-right: 2px;display: none;"
                onclick="increaseTextAreaSpace()" class="btn btn-success floatRight firstTime increaseText">Add more
            text
        </button>

        <div class="bigButton uploadPhoto">
            <input class="photoUpload" name="imagefile" type='file' accept="image/*" onchange="processPhoto(this);"/>
            <div class="buttonImage">
                <img class="photoUploadIcon" src="<?php echo IMAGES_PATH; ?>/template/camera@2x.png" width="50"
                     height="45" alt="add photo">
                <img id="prevImage" alt="add photo">
            </div>
            <div class="btnTitle">select photo</div>
            <div class="btnSubtitle">no photo selected</div>

        </div>

        <div class="notifyFriend">
            <div class="verticalSpacer"></div>
            Notify a friend about your reply
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                <input type="email" name="email" class="form-control postFriendEmail" placeholder="friend's mail">
            </div>
        </div>

        <div class="verticalSpacer" style="height: 16px"></div>

        <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">
            Cancel
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Reply</strong></button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>