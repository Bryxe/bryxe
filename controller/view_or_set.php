<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'User Information';
include_once(INCLUDE_PATH . '/socket_function.php');

if (isset($queryString[0])) {
    $username = $queryString[0];
    $password = $_SESSION['password'];
}

/** Get User Data Service Starts **/
//$user_information = fetch_user_information($username, $password);
$user_information = $_SESSION['user_details'];
if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $create_message = 'User information not found.';
}
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
//Stamps
/** Get User Data Service Ends **/