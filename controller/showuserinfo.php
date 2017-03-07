<?php

include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'User Information';
include_once(INCLUDE_PATH . '/socket_function.php');

if (!isset($queryString[0])) {
    $create_message = "User data not found";
} else {
    $vrUsername = $queryString[0];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];


    /** Get User Data Service Starts * */
    $user_information = get_user_information($username, $password, $vrUsername);


//$user_information = $_SESSION['user_details'];
    if (!is_array($user_information) || $user_information == FALSE) {
        $error = 1;
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
    extract($user_information);

//Get User Thumb Image
//Stamps webPg
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

    $user_url = (trim($user_information['webPg'])); //print_r($user_stamp);exit;
    if (isset($user_url) && $user_url != '') {
        $user_url = $user_url;
    } else {
        $user_url = '';
    }
}
//Stamps
/** Get User Data Service Ends **/