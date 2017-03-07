<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Edit User Account';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];

if ($_REQUEST["closeme"]) {
    unset($_SESSION["firstTimeSignup"]);
}
/** Set User Data Service Starts **/
if ($_POST['editUserAccountSubmit'] == 1) {
    $pic = '0';
    extract($_POST);
    //$timeZone = ($timeZone == 'GMT‐01:00')?'0000000000000000':'0000000001000000';

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
        'picFile' => ($picFile == null) ? "" : $picFile,
        'protect' => $protect
    ); //print_r($fields);exit;
    //Do SetData Service
    $edit_profile = set_user_data($fields);
    if ($edit_profile == TRUE) {
        $edit_profile_message = 'Account Successfully Updated.';
        if ($_SESSION["firstTimeSignup"]) {
            header('Location: ' . BASE_URL . 'edit_profile');
        } else {
            $_REQUEST["closeme"] = true;
        }

    } else {
        $edit_profile_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}
/** Set User Data Service Ends **/


/** Get User Data Service Starts **/
$user_information = fetch_user_information($username, $password);
$_SESSION['user_details'] = $user_information;

if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $edit_profile_message = $_SESSION['mes'];
    if (isset($_SESSION['mes']))
        unset($_SESSION['mes']);
}

extract($user_information);
$_SESSION["tz"] = $timeZoneHr;
//print_r($user_information);exit;
/** Get User Data Service Ends **/