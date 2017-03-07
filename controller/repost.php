<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'RePost';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$protectionlevel = $_SESSION['level'];


if (!isset($_REQUEST['oldmessage']) || !isset($_REQUEST['oldtitle'])) {
    exit('Please select any post before you can reply/repost.');
}

$oldtitle = strip_tags(($_REQUEST['oldtitle']));
$oldmessage = strip_tags(($_REQUEST['oldmessage']));
$oldimage = strip_tags(($_REQUEST['oldimage']));
$oldfullimage = strip_tags(($_REQUEST['oldfullimage']));
