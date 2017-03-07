<?php
/** Repost Service Starts * */
/** New Post Service Starts * */
$pageTitle = 'Show Posts';

if (isset($_POST['newpost_submit']) && $_POST['newpost_submit'] == 1) {
    //Set Posted values to respective variables
    include_once(INCLUDE_PATH . '/check_session.php');
    include_once(INCLUDE_PATH . '/socket_function.php');
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $overwrite = (int)$_POST['overwrite'];
    if ($overwrite != 1) {
        $overwrite = 2;
    }

    $title = $_POST['title'];
    $postedTxt = $_POST['postedTxt'];
    $postTime = date('H:i:s');
    $email = $_POST['email'];
    //Check if picture is sent and set flag accordingly

    $filename = '';
    if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '' AND $_FILES['fileUploadField']['name'] != '') {
        $picFl = '1';
        $pic_file = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
        $file_file = $_FILES['fileUploadField']['tmp_name'];
        $file_flsz = filesize($file_file);
        /* if ($file_flsz < 1024) {
          $file_flsz = 1;
          } else {
          $file_flsz = $file_flsz / 1024;
          $file_flsz = round($file_flsz);
          } */
        $filename = $_FILES['fileUploadField']['name'];
    } else if ($_FILES['imagefile']['name'] != '' AND $_FILES['fileUploadField']['name'] == '') {
        $picFl = '1';
        $pic_file = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
        $file_flsz = '0';
    } else if ($_FILES['imagefile']['name'] == '' AND $_FILES['fileUploadField']['name'] != '') {
        $picFl = '0';
        $file_file = $_FILES['fileUploadField']['tmp_name'];
        $file_flsz = filesize($file_file);
        /* if ($file_flsz < 1024) {
          $file_flsz = 1;
          } else {
          $file_flsz = $file_flsz / 1024;
          $file_flsz = round($file_flsz);
          } */
        $filename = $_FILES['fileUploadField']['name'];
    }//else if ($_FILES['imagefile']['name'] =='' AND $_FILES['file']['name'] !=''){
    //	$picFl = '01000000';
    //	}
    $filename = $_FILES['fileUploadField']['name'];
    $picName = $_FILES['imagefile']['name'];
    $protectionlevel = $_SESSION['level'];
    $protect = $protectionlevel; //00000000
    //Set FieldsArray
    $fields = array(
        'postedTxt' => $postedTxt,
        'title' => $title,
        'postTime' => $postTime,
        'picFl' => $picFl,
        'email' => $email,
        'picName' => $picName,
        'filename' => $filename,
        'file_file' => $file_file,
        'file_flsz' => $file_flsz,
        'protect' => $protect,
        'pic_file' => $pic_file,
        "topic" => $_SESSION["topic"]
    );
    //print_r($fields);exit;
    //Do New Post Service
    $new_post = create_new_post($username, $password, $fields, $overwrite);

    $result = false;
    $resultMsg = 'Post sent';

    if ($new_post) {
        echo '<script type="text/javascript">window.parent.location="/showposts";</script>';
        return;
    } else {
        if (isset($_SESSION['mes']['redirect']) && $_SESSION['mes']['redirect'] !== false) {
            echo '<script type="text/javascript">window.parent.location="' . BASE_URL . $_SESSION['mes']['redirect'] . '";</script>';
            return;
        }
        $resultMsg = 'Error sending post, please check that all required fields are ok';
        if ($_SESSION['mes']) {
            $resultMsg = $_SESSION['mes'];
        }
    }

    if (isset($_SESSION['mes']))
        unset($_SESSION['mes']);
}
?>
<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/newpost.js" type="text/javascript"></script>

<section class="slideSection slideNewpost">
    <?php if (isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 2)) { ?>
        <header>
            <div class="title">Edit note</div>
        </header>
    <?php } else { ?>
        <header>
            <div class="title">Add new post</div>
            <?php if (isset($_SESSION["topicName"])) { ?><p class="topic-line">
                <span>Posting in <?php echo $_SESSION["topicName"]; ?></span></p><?php } ?>
        </header>
    <?php } ?>
    <hr>
    <?php if ($resultMsg) { ?>
        <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="errorMessage"><p><?php echo $resultMsg; ?></p></span>
        </div>
    <?php } ?>

    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>

    <form role="form" onsubmit="return validateNewPost()" target="_self" name="new_post" id="new_post" method="post"
          enctype="multipart/form-data" action="/newpost">

        <input type="hidden" name="newpost_submit" value="1">
        <input type="text" class="form-control postTitle" name="title" placeholder="enter a post title" maxlength="42"
               required="required">
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
        <?php
        if ($_SESSION['level'] > 0) {
            ?>
            <div class="bigButton uploadFile clearfix">
                <input class="fileUpload" name="fileUploadField" type='file' onchange="processFile(this);"/>

                <div class="buttonImage">
                    <img class="fileUploadIcon" src="<?php echo IMAGES_PATH; ?>/template/file@2x.png" width="40"
                         height="44" alt="attach file">
                    <img id="prevFile" src="<?php echo IMAGES_PATH; ?>/template/file_green@2x.png" width="40"
                         height="44" alt="attach file">
                </div>

                <div class="btnTitle">attach file</div>
                <div class="btnSubtitle">no file selected</div>
            </div>
            <label style="font-weight: normal">
                <input type="checkbox" name="overwrite" value="1">
                Overwrite file if it already exists?
            </label>
        <?php } ?>
        <textarea name="postedTxt" class="form-control counterLimit postText" rows="5" placeholder="enter a post text"
                  maxlength="200"></textarea>
        <button type="button" style="margin-top: -36px;margin-right: 2px;display: none;"
                onclick="increaseTextAreaSpace()" class="btn btn-success floatRight firstTime increaseText">Add more
            text
        </button>


        <?php
        //Hide email notification if he's on a private/note group
        if (isset($_SESSION['level']) && ($_SESSION['level'] == 0)) { ?>
            <div class="notifyFriend">
                Notify a friend about your post
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="email" name="email" class="form-control postFriendEmail"
                           placeholder="enter your friend's email">
                </div>
            </div>
        <?php } ?>

        <div class="verticalSpacer" style="height: 8px"></div>

        <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">
            Cancel
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Post!</strong></button>

    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>
