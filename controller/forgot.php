<?php
$pageTitle = 'Forgot_Password';
include_once(INCLUDE_PATH . '/socket_function.php');


if ($_POST['forgot_submit'] == 1) {

    //Set Posted values to respective variables
    $uname = $_POST['uname'];
    $password = '';

    $new_pass = send_pass($uname, $password);
    //it always returns true...
    $create_message = 'Your password was sent to your email address. Make sure that email will not be blocked.';
}
