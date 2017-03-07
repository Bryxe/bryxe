<?php
if (!isset($_REQUEST['latest_offset'])) {//dont include when calling via Ajax with "load more"
    ?>
    <script src="<?php echo JS_PATH; ?>/views/searchusers.js" type="text/javascript"></script>
    <?php
}
?>

<section class="main-container">

    <?php
    if (!isset($_REQUEST['latest_offset'])) {//dont include when calling via Ajax with "load more"
        ?>
        <div class="verticalSpacer" style="height: 4px;"></div>
        <form name="searchUser" method="post" action="" onsubmit="window.parent.showProgressOverlay();">
            <div class="input-group" style="margin-left: 4px;margin-right: 4px;position: initial;">
                <input type="text" name="searchTxt" id="searchTxt" class="form-control"
                       placeholder="username, email or person’s name..."
                       value="<?php echo (isset($_POST['searchTxt']) && $_POST['searchTxt'] != '') ? $_POST['searchTxt'] : ''; ?>">
                <span class="input-group-btn" style="position: initial;">
                    <button type="submit" class="btn btn-default" style="position: initial;">
                        <span class="searchButtonLabel" style="display:none;">Search</span> <img
                                src="<?php echo IMAGES_PATH . '/template/magni@2x.png'; ?>" width="18" height="18">
                    </button>
                </span>
            </div>
            <input type="hidden" name="searchUserSubmit" value="1">
        </form>
        <div class="verticalSpacer" style="height: 4px;"></div>
        <?php
    }//endif
    ?>

    <?php if (empty($search_result) && isset($_POST['searchTxt']) && !isset($_REQUEST['latest_offset'])) {
        ?>
        <article class="graybox clearfix">
            <section class="rowContent">
                <p class="rowTextBody clearfix">No results found...</p>
            </section>
            <footer class="rowFooter clearfix"></footer>
        </article>
        <?php
    }
    ?>

    <?php
    if (!empty($search_result) && isset($_POST['searchTxt'])) {


        $xo = 0;
        foreach ($search_result as $key => $sr) {

            if (!is_int($key)) {
                continue;
            }
            $user_stamp = (trim($sr['picPath']));
            if (isset($user_stamp) && $user_stamp != '') {
                $user_stamp = IMAGE_DOWNLOAD_PATH_THUMB . $user_stamp;
            } else {
                $user_stamp = IMAGES_PATH . '/template/chat-i.png';
            }

            $user_full = (trim($sr['picID']));
            if (isset($user_full) && $user_full != '') {
                $user_full = IMAGE_DOWNLOAD_PATH_THUMB . $user_full;
            } else {
                $user_full = IMAGES_PATH . '/template/chat-i.png';
            }
            ?>


            <!--  BOX -->
            <article class="graybox clearfix" onclick="scrollBox(this)">
                <header class="rowHeader">
                    <div class="rowData clearfix">
                        <a class="roundProfileImage swipebox" rel="gallery-usr-<?php echo $xo; ?>"
                           href="<?php echo $user_full; ?>" target="_new">
                            <img src="<?php echo $user_stamp; ?>" height="100%">
                        </a>
                        <span class="userName"
                              onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($sr['uname']); ?>');"><?php echo $sr['fullName']; ?></span>
                        <span class="rowSub clearfix"
                              onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($sr['uname']); ?>');">@<?php echo $sr['uname']; ?></span>
                    </div>
                    <div class="rowActions clearfix">
                        <?php
                        $unViewUserUrl = BASE_URL . "showviewing/" . trim($sr['uname']) . "/delete";
                        $viewUserUrl = BASE_URL . "showviewing/" . trim($sr['uname']) . "/add";
                        ?>
                        <a class="<?= ($sr['uviewerBlk'] == '0') ? 'unViewUser' : 'viewUser'; ?> clearfix"
                           onclick="window.parent.showProgressOverlay();"
                           href="<?= ($sr['uviewerBlk'] == '0') ? $unViewUserUrl : $viewUserUrl; ?>"></a>
                    </div>
                </header>
                <section class="rowContent" onclick="$('.postedTextBody', this).toggleClass('collapsed')">
                    <p class="rowTextBody clearfix collapsed"><?php echo $sr['bioDesc']; ?></p>
                </section>
                <footer class="rowFooter clearfix"></footer>
            </article>
            <!-- END  BOX -->
            <?php
            $xo++;
        }
        ?>
        <footer class="main-containerFooter clearfix">
            <?php
            if (((int)$search_result['cntLeft']) > 0) {
                ?>


                <div class="loadMoreData" onclick="loadMoreRows(startRows, '<?php echo BASE_URL; ?>');">Load more</div>
                <?php
            }
            ?>
            <div style="height: 10px;"></div>
        </footer>
        <?php
    }
    ?>

    <div style="clear: both;height: 20px;"></div>
    <div class="copyrightFooter" style="width: 100%;text-align: center;">© 2017 Acupic - <a
                href="<?php echo BASE_URL; ?>help">Help</a> - <a href="<?php echo BASE_URL; ?>about">About</a> - <a
                href="<?php echo BASE_URL; ?>terms">Terms</a> - <a href="<?php echo BASE_URL; ?>privacy">Privacy</a> -
        <a href="<?php echo BASE_URL; ?>blog">Blog</a> - <a href="<?php echo BASE_URL; ?>contact">Contact</a></div>
</section><!-- #main-container -->
