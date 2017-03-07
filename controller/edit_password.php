<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Edit User Password';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];

if ($_REQUEST["closeme"]) {
    unset($_SESSION["firstTimeSignup"]);
}
/** Set User Data Service Starts * */
if ($_POST['editUserPasswordSubmit'] == 1) {
    $pic = '0';
    extract($_POST);

    //Check for passwords match
    if ($userPwd != $cuserPwd) {
        $edit_profile_message = 'Password and Confirm password not matched.';
        $error = 1;
    }

    if (!isset($error) && $error == '') {

        //Set FieldsArray
        $fields = array(
            'uname' => $uname,
            'userPwd' => $oldpassword,
            'fullName' => $fullName,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'email' => $email,
            'webPg' => $webPg,
            'bioDesc' => $bioDesc,
            'nwUpswd' => $userPwd,
            'timeZone' => $timeZone,
            'pic' => $pic,
            'picFile' => $picFile,
            'protect' => $protect
        );
        //Do SetData Service
        $edit_profile = set_user_data($fields);
        if ($edit_profile == TRUE) {
            $edit_profile_message = 'Password Successfully Updated';
            $_SESSION['password'] = $userPwd;
            $password = $userPwd;
            $_REQUEST["closeme"] = true;
        } else {
            $edit_profile_message = $_SESSION['mes'];

            if (isset($_SESSION['mes']))
                unset($_SESSION['mes']);
        }
    }
}
/** Set User Data Service Ends * */
/** Get User Data Service Starts * */
$user_information = fetch_user_information($username, $password);
$_SESSION['user_details'] = $user_information;
if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $create_message = 'User information not found.';
}
extract($user_information);
/** Get User Data Service Ends **/