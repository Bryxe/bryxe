<?php

$pageTitle = 'Index';
include_once(INCLUDE_PATH . '/socket_function.php');
if (isset($_SESSION['username']) && $_SESSION['username'] != '' && isset($_SESSION['username']) && $_SESSION['username'] != '') {
    header('Location: ' . BASE_URL . 'showposts');
}

/** Join Service Starts * */
if ($_POST['regSubmit'] == 1) {

    if (!$_POST['acceptTerms']) {
        $reg_message = "You must read and accept the terms and privacy conditions to sign up";
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    } else {
        //Check if picture is sent and set flag accordingly
        $pic = '0';
        $picFile = '';
        $protect = '0';
        //Check Ends
        //print_r($_POST);
        //Extract POST Global variable
        extract($_POST);

        //Set FieldsArray
        $fields = array(
            'uname' => $uname,
            'userPwd' => $userPwd,
            'fullName' => $fullName,
            'city' => "",
            'state' => "",
            'country' => "",
            'email' => $email,
            'webPg' => "",
            'bioDesc' => "",
            'timeZone' => 0,
            'pic' => $pic,
            'picFile' => $picFile,
            'protect' => $protect
        );

        //Do Join Service

        if ($register = registration($fields) == true) {
            //If success log him in and forward
            //$user_information = fetch_user_information($uname, $userPwd);
            //if(is_array($user_information) && $user_information == TRUE){
            //Mail Sending
            /* $header  = 'MIME-Version: 1.0' . "\r\n";
              $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $header .= 'MIME-Version: 1.0' . "\r\n";
              $header .= "From:ravid@sevenstarinfotech.com";
              $subject = "Acupic-User Registration"; */
            //$register = registration($fields);
            $_SESSION['username'] = $uname;
            $_SESSION['password'] = $userPwd;
            $_SESSION['level'] = '0';
            /** Get User Data Service Starts * */
            $user_information = fetch_user_information($uname, $userPwd);
            $_SESSION['user_details'] = $user_information;

            $_SESSION["firstTimeSignup"] = true;

            header('Location: ' . BASE_URL . 'showposts');
        } else {
            $reg_message = $_SESSION['mes'];
            if (isset($_SESSION['mes']))
                unset($_SESSION['mes']);
        }
    }
}
/** Join Service Ends * */
/** Login Service Starts * */
if ($_POST['loginSubmit'] == 1) {
    extract($_POST);
    $user_information = fetch_user_information($uname, $userPwd);
    if (is_array($user_information) && $user_information == TRUE) {
        $_SESSION['username'] = $uname;
        $_SESSION['password'] = $userPwd;
        $_SESSION['level'] = '0';
        $_SESSION['user_details'] = $user_information;
        $_SESSION['next_start'] = 0;
        //$hour = time() + 3600;
        //setcookie('ID_my_site', $uname, $hour);
        // setcookie('Key_my_site', $userPwd, $hour);
        $year = time() + 31536000;
        //setcookie('remember_me', $uname, $year);
        if ($_POST['rem']) {
            setcookie('remember_me', $uname, $year);
            setcookie('Key_my_site', $userPwd, $year);
        } elseif (!$_POST['rem']) {
            if (isset($_COOKIE['remember_me'])) {
                $past = time() - 100;
                setcookie(remember_me, gone, $past);
                setcookie(Key_my_site, gone, $past);
            }
        }

        header('Location: ' . BASE_URL . 'showposts');
    } else {
        if (isset($_SESSION['mes'])) {
            $login_message = $_SESSION['mes'];
        } else {
            $login_message = 'Login Failed. Try again or join us.';
        }
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}

if (isset($_SESSION['validation_msg'])) {
    $login_message = $_SESSION['validation_msg'];
    if (isset($_SESSION['validation_msg']))
        unset($_SESSION['validation_msg']);
}
/** Login Service Ends **/