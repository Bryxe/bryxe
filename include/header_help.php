<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="googlebot" content="noindex, nofollow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?php if (empty($customSeoTitle)) { ?>
        <title><?php echo SITE_NAME . ' - Help Center'; ?></title>
        <meta name="description" content="">
        <?php
    } else {
        ?>
        <title><?php echo $customSeoTitle; ?></title>
        <meta name="description" content="<?php echo $customSeoContent; ?>">
        <?php
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="<?php echo CSS_PATH; ?>/normalice_and_bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/swipebox.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/generalStyles.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/generalStylesHelpsection.css" rel="stylesheet" type="text/css"/>
    <!--
        <script src="<?php echo JS_PATH; ?>/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH; ?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH; ?>/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH; ?>/jquery.swipebox.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH; ?>/jquery-scrollto.js" type="text/javascript"></script>
        -->
    <script src="<?php echo JS_PATH; ?>/libsPack.min.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/views/header_help.js" type="text/javascript"></script>

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
            <div class="menu clearfix">
                <div class="submenu" style="display:none;">
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>index">Home</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>help">Help</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>blog">Blog</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>about">About</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>terms">Terms</a></div>
                    <div class="menuoption"><a href="<?php echo BASE_URL; ?>privacy">Privacy</a></div>
                    <div class="menuoption"><a href="#">Close menu</a></div>
                </div>
            </div>

            <div class="topTitle clearfix">
                <div class="topTitleContents clearfix">
                    <span class="topSectionTitle">Help center</span>
                </div>
            </div>
        </nav>

    </section>
</header>

<div class="mainSlidingPanelOverlay"></div>
<section class="mainSlidingPanel">
    <iframe class="mainSlidingPanelIframe"></iframe>
</section>

<section class="main-container" style="margin-top: 50px;">