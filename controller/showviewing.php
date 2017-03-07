<?php

include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Show Viewing';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$last_msg_id = $_POST['last_msg_id'];
$action = $_POST['action'];
$protectionlevel = $_SESSION['level'];


if ($queryString[1] == 'add') {
    $uname = $_SESSION['username'];
    $userNm = $queryString[0];
    $protect = $protectionlevel;
    if ($uname == $userNm) {
        $create_message = 'you can not add your self';
    } else {
//function add_viewing($uname, $password, $protect, $userNm)
        if ($add_view = add_viewing($uname, $password, $protect, $userNm) == TRUE) {
            $create_message = 'Add successfully.';
            header('Location:' . BASE_URL . 'showviewing');
        } else {
            $create_message = $_SESSION['mes'];
            if (isset($_SESSION['mes']))
                unset($_SESSION['mes']);
            header('Location:' . BASE_URL . 'showviewing');
        }
    }
} //echo $queryString[1];

if ($queryString[1] == 'delete') { //echo 'hi'; exit; 
    $uname = $_SESSION['username'];
    $userNm = $queryString[0];
    $protect = $protectionlevel;

    if ($delete_view = delete_viewing($uname, $password, $protect, $userNm) == TRUE) { //echo 'here';exit;
        $create_message = 'Deleted successfully.';
        header('Location:' . BASE_URL . 'showviewing');
    } else { //echo 'no';exit;
        $create_message = 'Delete failed.';
        header('Location:' . BASE_URL . 'showviewing');
    }
//delete_viewing($uname, $password, $protect, $userNm)
}

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
//Stamps
/** Get User Data Service Ends * */
/** Get Viewing Service Starts * */
$protect = $protectionlevel; //00000000

