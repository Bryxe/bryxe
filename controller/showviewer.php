<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Show Viewer';
include_once(INCLUDE_PATH . '/socket_function.php');

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$last_msg_id = $_POST['last_msg_id'];
$action = $_POST['action'];
$protectionlevel = $_SESSION['level'];


//update the counts
updateLevelPostsCounts();

/** Get User Data Service Starts * */
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
