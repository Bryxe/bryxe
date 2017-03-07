<?php
if (!isset($_REQUEST['latest_offset'])) {//dont include when calling via Ajax with "load more"
    ?>
    <script src="<?php echo JS_PATH; ?>/views/showposts.js" type="text/javascript"></script>
    <?php
}//endif
?>
<section class="main-container">
    <?php
    $protectionlevel = $_SESSION['level'];
    $topic = $_SESSION["topic"] ? $_SESSION["topic"] : "";
    $visitunm = "";
    $protect = $protectionlevel;

    $s = 0;
    $c = 10;

    if (isset($_REQUEST['latest_offset'])) {
        $s = (int)$_SESSION['next_start'];
    }

    $start = $s;
    $count = $c;

    $user_posts = fetch_posts($username, $password, $_SESSION['grOwnerId'], $_SESSION['level'], $start, $count, $visitunm, $topic);

    //print_r($user_posts);
    //die();
    if ($user_posts) {
        $_SESSION['next_start'] = $start;


        //////////////////////Checkbox id XO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        $xo = $s + 1;
        $hasPosts = false;
        foreach ($user_posts as $key => $user_post) {
            if (!is_int($key)) {
                continue;
            }
            $hasPosts = true;
            $post_stamp = '';
            $post_full = '';
            $user_stamp = '';
            //get posts stamp picture
            $postRef = $user_post["postRef"];

            $post_stamp = (trim($user_post['viewStampLnk']));

            $userDisplayName = (trim($user_post['ufullname']));
            $userDisplayNameArray = explode(" ", $userDisplayName);
            if (count($userDisplayName) > 2) {
                $userDisplayName = $userDisplayNameArray[0] . " " . $userDisplayNameArray[count($userDisplayNameArray) - 1];
            }


            if (isset($post_stamp) && $post_stamp != '') {
                $post_stamp = IMAGE_DOWNLOAD_PATH_THUMB . $post_stamp;
            } else {
                $post_stamp = '';
            }

            $post_full = (trim($user_post['postedPic']));

            if (isset($post_full) && $post_full != '') {
                $post_full = IMAGE_DOWNLOAD_PATH . $post_full;
            } else {
                if ($post_stamp != '') {
                    $post_full = $post_stamp;
                } else {
                    $post_full = '';
                }
            }

            $user_stamp = (trim($user_post['stampPicID']));
            if (isset($user_stamp) && $user_stamp != '') {
                $user_stamp = IMAGE_DOWNLOAD_PATH_THUMB . $user_stamp;
            } else {
                $user_stamp = IMAGES_PATH . '/template/chat-i.png';
            }

            $user_full = (trim($user_post['fullPicID']));
            if (isset($user_full) && $user_full != '') {
                $user_full = IMAGE_DOWNLOAD_PATH_THUMB . $user_full;
            } else {
                $user_full = $user_stamp;
            }

            $user_post['postedTxt'] = trim(strip_tags($user_post['postedTxt']));
            //$user_post['postedTxt'] = preg_replace('@(?<!href="|">)((www\.)[\w\-\.!~?&=+\*\'(),\/]+)((?!\<\/\a\>).)*@i', '<a href="http://$1" target="_new" style="color:blue;text-decoration:none;display:inline;width:auto;float:none;" >$1</a>', $user_post['postedTxt']);
            $user_post['postedTxt'] = mb_eregi_replace('@(?<!href="|">)((https?:\/\/[\w\-\.!~?&=+\*\'(),\/]+)((?!\<\/\a\>).)|(((www\.)[\w\-\.!~?&=+\*\'(),\/]+)((?!\<\/\a\>).)))*@i', '<a href="$1" target="_new" style="color:blue;text-decoration:none;display:inline;width:auto;float:none;" >$1</a>', $user_post['postedTxt']);
            $user_post['postedTxt'] = str_replace("<a href=\"www.", "<a href=\"http://www.", $user_post["postedTxt"]);
            
            // POST BOX
            ?><article class="graybox" onclick="scrollPostBox(this)" data-start="<?php echo $start; ?>">
                <header class="postHeader">
                    <div class="postData">
                        <a class="roundProfileImage swipebox" rel="gallery-usr-<?php echo $xo; ?>"
                           href="<?php echo $user_full; ?>" target="_new" style="background-image: url(<?php echo $user_stamp; ?>)">
                        </a>
                        <span class="userName"
                              onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($user_post['uname']); ?>');"><?php echo $userDisplayName; ?></span>
                        <span class="postedTime"
                              onclick="showContentOnSlide('<?php echo BASE_URL; ?>showuserinfo/<?php echo($user_post['uname']); ?>');"><?php echo $user_post['postTime']; ?></span>
                    </div>
                    <div class="postActions">
                        <?php
                        $editParams = "postRef=" . urlencode(trim($postRef)) . "&oldusername=" . urlencode(trim($user_post['uname'])) . "&oldtitle=" . urlencode(trim($user_post['title'])) . "&oldmessage=" . urlencode(trim($user_post['postedTxt'])) . "&oldimage=" . urlencode(trim($post_stamp)) . "&oldfullimage=" . urlencode(trim($post_full));
                        $replyParams = "oldusername=" . urlencode(trim($user_post['uname'])) . "&oldtitle=" . urlencode(trim($user_post['title'])) . "&oldmessage=" . urlencode(trim($user_post['postedTxt'])) . "&oldimage=" . urlencode(trim($post_stamp)) . "&oldfullimage=" . urlencode(trim($post_full));
                        $repostParams = "oldusername=" . urlencode(trim($user_post['uname'])) . "&oldtitle=" . urlencode(trim($user_post['title'])) . "&oldmessage=" . urlencode(trim($user_post['postedTxt'])) . "&oldimage=" . urlencode(trim($post_stamp)) . "&oldfullimage=" . urlencode(trim($post_full));

                        $setDisabledClass = '';
                        if ($username == trim($user_post['uname'])) {
                            $setDisabledClass = 'disabled';
                        }
                        ?>
                        <?php
                        if ($user_post['uname'] == $username && isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 2)) {
                            ?>
                            <div class="editpost" onclick="if (!$(this).hasClass('disabled'))
                                    showContentOnSlide('<?php echo BASE_URL; ?>editpost?<?php echo $editParams; ?>');"></div>
                        <?php } ?>


                        <?php
                        //Hide email notification if he's on a private/note group
                        if (isset($_SESSION['level']) && ($_SESSION['level'] == 0)) { ?>
                            <div class="repost"
                                 onclick="if (!$(this).hasClass('disabled'))
                                         showContentOnSlide('<?php echo BASE_URL; ?>repost?<?php echo $repostParams; ?>');"></div>
                        <?php } ?>
                        <?php
                        //Hide email notification if he's on a private/note group
                        if (isset($_SESSION['level']) && ($_SESSION['level'] == 0)) { ?>
                            <div class="reply <?php echo $setDisabledClass; ?>"
                                 onclick="if (!$(this).hasClass('disabled'))
                                         showContentOnSlide('<?php echo BASE_URL; ?>reply?<?php echo $replyParams; ?>');"></div>
                        <?php } ?>



                        <?php
                        if (trim($user_post['fileLnk']) != '') {
                            ?>
                            <a href="//<?php echo trim($user_post['fileLnk']); ?>" target="_new"
                               class="downloadAttachment"></a>
                        <?php } else {
                            ?>
                            <div style="display:none;" class="downloadAttachment"></div>
                            <?php
                        }
                        ?>


                        <?php
                        if ($user_post['postRef'] != "0000000000000" && $_SESSION['level'] >= 0) {
                            ?>

                            <div class="delpost"
                                 onclick="if (confirm('Are you sure you want to remove this post?')) {
                                         $.get('<?php echo BASE_URL; ?>showposts/?delpost=<?php echo($user_post['postRef']); ?>', function (data) {
                                         if (data == 'ok') {
                                         window.location = '<?php echo BASE_URL; ?>showposts/';
                                         } else {
                                         alert(data);
                                         }
                                         });
                                         }"></div>
                            <?php
                        }
                        ?>

                    </div>
                </header>
                <section class="postContent" onclick="$('.postedTextBody', this).toggleClass('collapsed');
                                $('.postedTextReadMore', this).toggleClass('collapsed');">
                    <?php if ($post_stamp != '') { ?>
                        <!--<a href="<?php echo $post_full; ?>" class="swipebox" rel="gallery-<?php echo $xo; ?>"
                           target="_new"><img class="postedImage" src="<?php echo $post_stamp; ?>" width="48"></a>-->
                           <a href="<?php echo $post_full; ?>" class="swipebox" rel="gallery-<?php echo $xo; ?>"
                           target="_new" style="background-image: url(<?php echo $post_stamp; ?>)"></a>
                    <?php } ?>
                    <p class="postedTextTitle"><?php echo $user_post['title']; ?></p>

                    <?php
                    if (strlen($user_post['postedTxt']) > 0) {
                        ?>
                        <p class="postedTextBody collapsed"><?php echo $user_post['postedTxt']; ?></p>
                        <span class="postedTextReadMore">
                            read more
                        </span>
                        <?php
                    }
                    ?>
                </section>
                <footer class="postFooter"></footer>
            </article><?php // END POST BOX
            $xo++;
        }
    }
    ?>
    <footer class="main-containerFooter">
        <?php if ($hasPosts && (int)$start > 0) {
            ?>
            <div class="loadMoreData" onclick="loadMoreRows('<?php echo BASE_URL; ?>');">Load more</div>
            <?php
        } else {
            if ((int)$start > 0 || !$user_posts || $user_posts["count"] == 0) {
                ?>
                <div class="noRowsFound">No posts found</div>
                <?php
            }
        }
        ?>
        <div class="copyrightFooter">© 2017 Acupic - <a
                href="<?php echo BASE_URL; ?>help">Help</a> - <a href="<?php echo BASE_URL; ?>about">About</a> - <a
                href="<?php echo BASE_URL; ?>terms">Terms</a> - <a href="<?php echo BASE_URL; ?>privacy">Privacy</a> -
        <a href="<?php echo BASE_URL; ?>blog">Blog</a> - <a href="<?php echo BASE_URL; ?>contact">Contact</a></div>
        
    </footer>

    

</section><!-- #main-container -->
