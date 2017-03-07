<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Search Users';
include_once(INCLUDE_PATH . '/socket_function.php');

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$protectionlevel = $_SESSION['level'];

//update the counts
updateLevelPostsCounts();

$user_information = fetch_user_information($username, $password);
$_SESSION['user_details'] = $user_information;

if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $create_message = 'User information not found.';
}
//print_r($user_information); exit;
extract($user_information);

//Stamps
$stampPath = ($stampPath);
if (isset($stampPath) && $stampPath != '') {
    $user_local_image_thumb_path = IMAGE_DOWNLOAD_PATH_THUMB . $stampPath;
} else {
    $user_local_image_thumb_path = '';
}

$picPath = ($picPath);
if (isset($picPath) && $picPath != '') {
    $user_local_image_path = IMAGE_DOWNLOAD_PATH . $picPath;
} else {
    $user_local_image_path = '';
}

if (isset($_POST['searchUserSubmit'])) {
    if ($username != $_POST['searchTxt']) {
        $c = 10;
        $s = 0;

        if (isset($_REQUEST['latest_offset'])) {
            $s = (int)$_REQUEST['latest_offset'];
            $s = $s + $c;
        }

        $start = $s;
        $count = $c;
        $searchText = (isset($_POST['searchTxt'])) ? $_POST['searchTxt'] : '';

        if ($search_result = search_users($username, $password, $searchText, $start, $count)) {
            $create_message = '';
        } else {
            $create_message = $_SESSION['mes'];
            if (isset($_SESSION['mes']))
                unset($_SESSION['mes']);
        }
    } else {
        $create_message = 'You cannot search yourself';
    }
}