<!DOCTYPE html>
<html class="no-js">
<head>
    <link rel="stylesheet" type="text/css" href="css/generalStyles.css"/>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="googlebot" content="noindex, nofollow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo SITE_NAME . ' - ' . $pageTitle; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="<?php echo CSS_PATH; ?>/normalice_and_bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/swipebox.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/generalStyles.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/dialogs.css" rel="stylesheet" type="text/css"/>

    <!--
    <script src="<?php echo JS_PATH; ?>/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/jquery.swipebox.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/jquery-scrollto.js" type="text/javascript"></script>
    -->

    <script src="<?php echo JS_PATH; ?>/libsPack.min.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/views/header_general.js" type="text/javascript"></script>

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="<?php echo JS_PATH; ?>/html5shiv.js"><\/script>')</script>
    <![endif]-->

</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
    improve your experience.</p>
<![endif]-->

<!--  Signup redirect for first time registration -->
<?php
if ($_SESSION["firstTimeSignup"]) {
    if ($_SESSION["firstTimeSignup"]) {
        $create_message = "Please fill in your account and profile information to complete your registration" . $create_message;
    }
    ?>
    <script type="text/javascript">
        $(function () {
            showContentOnSlide('<?php echo BASE_URL; ?>edit_account');
        });
    </script>
    <?php
    //unset($_SESSION["firstTimeSignup"]);
}//END IF
?>

<!--  Messages and error dialogs -->
<?php
if (isset($create_message) && is_array($create_message) && !empty($create_message["dialog"])) {
    $dialogSource = $create_message["dialog"];
    $dialogTitle = $create_message["title"];
    unset($create_message);
    ?>
    <!-- dialog to display custom messages -->
    <div class="msgDialogBox">
        <?php
        include_once(COMMON_CORE_VIEW . "/" . $dialogSource);
        ?>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".msgDialogBox").dialog({
                title: <?php echo "'" . $dialogTitle . "'"; ?>,
                autoOpen: true,
                modal: true,
                resizable: false,
                autoResize: true,
                minWidth: 200,
                maxWidth: 500,
                width: 'auto',
                height: 'auto'
            });
        });
    </script>
    <!-- END -->
    <?php
}//END IF
?>
<?php if (isset($create_message) && $create_message != '') { ?>
    <div class="operationMessages"><?php echo $create_message; ?></div>
    <script type="text/javascript">

        setTimeout(function () {
            $(".operationMessages").slideUp();
        }, 5000);
        
    </script>
<?php } ?>
<!--  End of Messages and error dialogs -->

<!-- generic progress bar overlay -->
<div class="progressBarOverlay">
    <div class="verticalSpacer"></div>
    <div class="progress progress-striped active" style='width: 50%;max-width: 450px;margin: auto;'>
        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
             style="width: 100%">
        </div>
    </div>
    please wait a moment...
</div>

<header class="header-container">
    <section class="wrapper">
        <nav class="mainNav">
            <div class="menu">
                <div class="submenu" style="display:none;">
                    <div class="menuoption"><a href="#"
                                               onclick="showContentOnSlide('<?php echo BASE_URL; ?>edit_account');">My
                            account</a></div>
                    <div class="menuoption"><a href="#"
                                               onclick="showContentOnSlide('<?php echo BASE_URL; ?>levelselect');">Group
                            selection</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>logout">Logout</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>help">Help</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>about">About</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>terms">Terms</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>privacy">Privacy</a></div>
                    <div class="menuoption"><a href="#">Close menu</a></div>
                </div>
            </div>

            <div class="userProfile">
                <div class="profileImage"
                     onclick="showContentOnSlide('<?php echo BASE_URL; ?>view_or_set/<?php echo $username; ?>');" 
                    <?php
                    if ($user_local_image_thumb_path == '') {
                        $user_local_image_thumb_path = IMAGES_PATH . '/template/image.png';
                    }
                    ?>
                    style="background-image: url(<?php echo $user_local_image_thumb_path; ?>)">
                </div>
                <div class="profileNameAndGroup">
                    <div class="profileNameContainer">
                    <span class="profileName"
                          onclick="showContentOnSlide('<?php echo BASE_URL; ?>view_or_set/<?php echo $username; ?>');">
                        <?php echo $fullName; ?>
                    </span>
                    </div>
                    <div class="profileButtonsContainer">
                        <a class="profileGroupIconLink" onclick="showContentOnSlide('<?php echo BASE_URL; ?>levelselect');"><span class="profileGroupIcon"
                            style="background-image: url(<?php echo IMAGES_PATH; ?>/template/icon-group-white.png)"></span><span><?=$_SESSION['level_name']; ?></span></a>
                        
                        <?php
                            if ((int)$_SESSION['level_post_count']['total_unread'] > 0) {
                                ?><div class="profileGroupBubble" onclick="showContentOnSlide('<?php /*echo BASE_URL; */ ?>levelselect');">

                                <?php echo "new"; //$_SESSION['level_post_count']['total_unread']; ?>

                                </div>
                           <?php }
                            //else echo "new";
                        ?>
                        <!--<span class="profileGroup" onclick="showContentOnSlide('<?php /*echo BASE_URL; */?>levelselect');">
                        <?php /*echo $_SESSION['level_name']; */?>
                    </span>-->
                        <a class="profileGroupIconLink" onclick="showContentOnSlide('<?php echo BASE_URL; ?>topicselect');"><span class="profileGroupIcon"
                            style="background-image: url(<?php echo IMAGES_PATH; ?>/template/icon-topic-white.png)"></span><span><?=$_SESSION['topicName']; ?></span></a>
                        <!--<span class="profileTopic" onclick="showContentOnSlide('<?php /*echo BASE_URL; */?>topicselect');">
                        <?php /*if (!empty($_SESSION['topicName']))
                            echo $_SESSION['topicName'];
                        else
                            echo "Topic: " . "General";
                        */?>
                    </span>-->
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 2)) { ?>
                <div class="editNote" onclick="showContentOnSlide('<?php echo BASE_URL; ?>newpost');"></div>
            <?php } else { ?>
                <div class="addPost" onclick="showContentOnSlide('<?php echo BASE_URL; ?>newpost');"></div>
            <?php } ?>
        </nav>
        <nav class="subNav">
            <div class="tabs">
                <div class="tab25" onclick="window.location = '<?php echo BASE_URL; ?>showposts';">
                    <div class="tabContent<?= ($pageName == "showposts") ? "Selected" : ""; ?>">Posts
                    (<?php echo isset($_SESSION['totalPosts']) ? $_SESSION['totalPosts'] : 0; ?>)
                    </div>
                </div>
                <div class="tab25" onclick="window.location = '<?php echo BASE_URL; ?>showviewer';">
                    <div class="tabContent<?= ($pageName == "showviewer") ? 'Selected' : ""; ?>">Viewers
                    (<?php echo($viewerCount); ?>)</div>
                </div>
                <div class="tab25" onclick="window.location = '<?php echo BASE_URL; ?>showviewing';">
                    <div class="tabContent<?= ($pageName == "showviewing") ? 'Selected' : ""; ?>">Viewing
                    (<?php echo($viewingCount); ?>)</div>
                </div>
                <div class="tab25" onclick="window.location = '<?php echo BASE_URL; ?>search_users';">
                    <div class="tabContent<?= ($pageName == "search_users") ? 'Selected' : ""; ?>">Search
                    </div>
                </div>
            </div>
        </nav>
    </section>
</header>

<div class="mainSlidingPanelOverlay"></div>
<section class="mainSlidingPanel">
    <iframe class="mainSlidingPanelIframe"></iframe>
</section>