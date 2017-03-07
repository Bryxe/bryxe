<?php

include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Edit User Profile';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];

if ($_REQUEST["closeme"]) {
    unset($_SESSION["firstTimeSignup"]);
}
/** Set User Data Service Starts * */
if ($_POST['editUserProfileSubmit'] == 1) {
    $pic = '0';
    $filename = '';
    //echo 'hi';
    if ($_FILES['imagefile']['name'] != '') {
        $pic = '1';

        $viewStampLnk = $_FILES['imagefile']['tmp_name'];
        $filename = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
    }
    extract($_POST);

    //Set FieldsArray
    $fields = array(
        'uname' => $uname,
        'userPwd' => $password,
        'fullName' => $fullName,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'email' => $email,
        'webPg' => $webPg,
        'bioDesc' => $bioDesc,
        'nwUpswd' => $nwUpswd,
        'timeZone' => $timeZone,
        'pic' => $pic,
        'picFile' => ($picName == null) ? "" : $picName,
        'pic_file' => $filename,
        'protect' => $protect

    ); //print_r($fields);exit;
    //Do SetData Service
    $edit_profile = set_user_data($fields);
    if ($edit_profile == TRUE) {
        $edit_profile_message = 'Profile Successfully Updated.';
        unset($_SESSION["firstTimeSignup"]);
        $_REQUEST["closeme"] = true;
    } else {
        $edit_profile_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}
/** Set User Data Service Ends * */
/** Get User Data Service Starts * */
$user_information = fetch_user_information($username, $password);
$_SESSION['user_details'] = $user_information;
if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $create_message = $_SESSION['mes'];
    if (isset($_SESSION['mes']))
        unset($_SESSION['mes']);
}
//print_r($user_information);
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