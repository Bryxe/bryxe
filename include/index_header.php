<!doctype html>
<html class="no-js">
<head>

    <meta name="robots" content="noindex, nofollow"/>
    <meta name="googlebot" content="noindex, nofollow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' - ' . $pageTitle; ?></title>
    <link href="<?php echo CSS_PATH; ?>/normalice.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/generalStyles.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/dialogs.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/forms.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>/index.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo JS_PATH; ?>/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH; ?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            //drop a banner with the error and hide it on clic
            $(".operationMessages").click(function () {
                $(this).slideToggle();
            });
        });
        //hide it automatically after some secs
        //setTimeout(function(){$(".operationMessages").slideUp("slow");},8000)
    </script>
</head>