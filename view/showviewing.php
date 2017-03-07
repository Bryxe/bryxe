<?php
if (!isset($_REQUEST['latest_offset'])) {//dont include when calling via Ajax with "load more"
    ?>
    <script src="<?php echo JS_PATH; ?>/views/showviewing.js" type="text/javascript"></script>
    <?php
}//endif
?>
<section class="main-container">
    <?php

    $protectionlevel = $_SESSION['level'];
    $protect = $protectionlevel;
    $s = 0;
    $c = 10;

    if (isset($_REQUEST['latest_offset'])) {
        $s = (int)$_REQUEST['latest_offset'];
        $s = $s + $c;
    }

    $start = $s;
    $count = $c;

    $viewing_information = fetch_viewing_information($username, $password, $protect, $start, $count);

    $_SESSION['next_start'] = $start;

    $xo = $s + 1;
    $hasRows = false;
    foreach ($viewing_information as $key => $vinfo) {
        if (!is_int($key)) {
            continue;
        }
        $hasRows = true;
        $user_stamp = (trim($vinfo['stampPicID']));
        if (isset($user_stamp) && $user_stamp != '') {
            $user_stamp = IMAGE_DOWNLOAD_PATH_THUMB . $user_stamp;
        } else {
            $user_stamp = '';
        }
        $user_full = (trim($vinfo['picID']));
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
                        <img src="<?php echo $user_full; ?>" height="100%">
                    </a>
                    <span class="userName"
                          onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($vinfo['uname']); ?>');"><?php echo $vinfo['fullNm']; ?></span>
                    <span class="rowSub clearfix"
                          onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($vinfo['uname']); ?>');">@<?php echo $vinfo['uname']; ?></span>
                </div>
                <div class="rowActions clearfix">
                    <?php
                    $unViewUserUrl = BASE_URL . "showviewing/" . trim($vinfo['uname']) . "/delete";
                    $viewUserUrl = BASE_URL . "showviewing/" . trim($vinfo['uname']) . "/add";
                    ?>
                    <a class="<?= ($vinfo['uviewerBlk'] == '0') ? 'unViewUser' : 'viewUser'; ?> clearfix"
                       onclick="window.parent.showProgressOverlay();"
                       href="<?= ($vinfo['uviewerBlk'] == '0') ? $unViewUserUrl : $viewUserUrl; ?>"></a>
                </div>
            </header>
            <section class="rowContent" onclick="$('.postedTextBody', this).toggleClass('collapsed')">
                <p class="rowTextBody clearfix collapsed"><?php echo $vinfo['bioDesc']; ?></p>
            </section>
            <footer class="rowFooter clearfix"></footer>
        </article>
        <!-- END  BOX -->
        <?php
        $xo++;
    }
    ?>
    <footer class="main-containerFooter clearfix">
        <?php if ($hasRows && ((int)$viewing_information['cntLeft']) > 0) {
            ?>
            <div class="loadMoreData" onclick="loadMoreRows(startRows, '<?php echo BASE_URL; ?>');">Load more</div>
            <?php
        }
        if (!$hasRows) {
            ?>
            <div class="noRowsFound">No users found</div>
            <?php
        }
        ?>
        <div style="height: 10px;"></div>
    </footer>

    <div style="clear: both;height: 20px;"></div>
    <div class="copyrightFooter" style="width: 100%;text-align: center;">© 2017 Acupic - <a
                href="<?php echo BASE_URL; ?>help">Help</a> - <a href="<?php echo BASE_URL; ?>about">About</a> - <a
                href="<?php echo BASE_URL; ?>terms">Terms</a> - <a href="<?php echo BASE_URL; ?>privacy">Privacy</a> -
        <a href="<?php echo BASE_URL; ?>blog">Blog</a> - <a href="<?php echo BASE_URL; ?>contact">Contact</a></div>
</section><!-- #main-container -->
