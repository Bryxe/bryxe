<?php

include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Show Posts';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];

if (isset($queryString[0]) && $queryString[0] == 'newgroup') {
    $newgroup = $_REQUEST["name"];
    $res = add_level($username, $password, $newgroup);
    header("Location:/showposts");
}


if (isset($queryString[0]) && $queryString[0] == 'editgroup') {
    $newgroup = $_REQUEST["name"];
    $res = set_level_name($username, $password, $newgroup, $_SESSION["level"]);
    header("Location:/showposts");
}

if (isset($queryString[0]) && $queryString[0] == 'deletegroup') {
    $res = del_level($username, $password, $_SESSION["level"]);
    header("Location:/showposts/add/0");
}


//this is called via ajax so it returns and dies to avoid further
//unnecesary code excecution
if (!empty($_REQUEST["delpost"])) {

    if ($delete_post = delete_post($username, $password, strip_tags($_REQUEST["delpost"])) == TRUE) {
        echo "ok";
    } else {
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes'])) {
            unset($_SESSION['mes']);
        }
        echo "Couldn't delete your post, please try again later";
    }
    die();
    return;
}

/** Add_Level * */
if (isset($queryString[0]) && $queryString[0] == 'add') {

    $level = urldecode($queryString[1]);
    $ownerId = urldecode($queryString[2]);
    $_SESSION['level'] = $level;
    $_SESSION['gr'] = $level;
    $_SESSION['grOwnerId'] = $ownerId;
    $_SESSION['topic'] = 0;
    $_SESSION['topicName'] = "All";

    //$_SESSION['totalPosts']=$_SESSION['level_post_count'][$_SESSION['grOwnerId']][$_SESSION['level']]['levelGral'];

    $protectionlevel = $_SESSION['level'];
    header('Location: ' . BASE_URL . 'showposts');
    return;
}

$groups = get_level($username, $password);
$_SESSION['ownerId'] = $groups["current_user_id"];
$_SESSION['grOwnerId'] = (isset($_SESSION["grOwnerId"])) ? $_SESSION["grOwnerId"] : $_SESSION["ownerId"];

unset($groups["current_user_id"]);
unset($groups["count"]);
unset($groups["result_code"]);
foreach ($groups as $gp) {
    if (($_SESSION['level'] == $gp["level"] && $_SESSION['grOwnerId'] == $gp["owner_id"])) {
        $_SESSION['level_name'] = $gp["level_name"];
        break;
    }
}

$protectionlevel = $_SESSION['level'];

$last_msg_id = (isset($_POST['last_msg_id'])) ? $_POST['last_msg_id'] : "";
$action = (isset($_POST['action'])) ? $_POST['action'] : '';


$topics = get_topics($username, $password, $_SESSION['grOwnerId'], $_SESSION['level']);
if ($topics["result_code"] == 1) {

    unset($topics["result_code"]);
    unset($topics["count"]);


    if (count($topics) > 0)
        $topic = (isset($_REQUEST["topic"])) ? (int)$_REQUEST["topic"] : $topics[0]['topic_id'];
    else
        $topic = (isset($_REQUEST["topic"])) ? (int)$_REQUEST["topic"] : 0;

    foreach ($topics as $tp) {
        if ((int)$tp["topic_id"] == $topic) {
            $_SESSION["topic"] = $tp["topic_id"];
            $_SESSION["topicName"] = $tp["topic"];
            $_SESSION['totalPosts'] = $tp["oldposts"] + $tp["newposts"];
            break;
        }
    }
}


//************************************************************
//ALL PROCESS THAT DEPENDS UPON SELECTION AND SUBMISSION******
//************************************************************

/** Search User * */
if (isset($_POST['searchUserSubmit'])) {

    $searchText = (isset($_POST['searchTxt'])) ? $_POST['searchTxt'] : '';

    if ($searchResult = search_users($username, $password, $searchText)) {
        header('Location: ' . BASE_URL . 'showposts');
        return;
    } else {
        echo $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
    exit;
}

/** Delete_Level * */
if (isset($queryString[0]) && $queryString[0] == 'del') {
    $oldViewerId = urldecode($queryString[1]);
    //$oldViewerId=' .9.W˜ID';
    $level = urldecode($queryString[2]);
    if ($level_select = delete_level($username, $password, $level, $oldViewerId) == TRUE) {
        header('Location: ' . BASE_URL . 'showposts');
        return;
    } else {
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}
/** Delete_Level * */
/** Reply Service Starts * */
if (isset($_POST['reply_submit']) && $_POST['reply_submit'] == 1) {

    //Set Posted values to respective variables
    $title = $_POST['old_title'];
    $replyTxt = $_POST['postedTxt'];
    $replyTime = date('H:i:s');
    $email = $_POST['email'];

    //Check if picture is sent and set flag accordingly
    $picFl = '0';
    $pic_file = '';
    $picName = '';
    if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '') {
        $picFl = '1';
        $pic_file = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
    }
    $protect = $protectionlevel; //00000000
    //Check Ends

    $title = (strlen($title) > 42) ? substr($title, 0, -6) . '..' : $title;

    //Set FieldsArray
    $reply_fields = array(
        'replyTxt' => $replyTxt,
        'title' => 'Re: ' . $title,
        'oldusername' => strip_tags($_REQUEST["postedby_username"]),
        'replyTime' => $replyTime,
        'picFl' => $picFl,
        'email' => $email,
        'picName' => $picName,
        'filename' => '',
        'protect' => $protect,
        'pic_file' => $pic_file,
        "topic" => $_SESSION["topic"]
    );
    //print_r($reply_fields);exit;
    //Do Reply Service
    if ($reply_post = reply_post($username, $password, $reply_fields) == TRUE) {
        $create_message = 'Reply successfully posted.';
    } else {
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}
/** Reply Service Ends * */
/** Repost Service Starts * */
if (isset($_POST['repost_submit']) && $_POST['repost_submit'] == 1) {

    //Set Posted values to respective variables
    $title = $_POST['old_title'];
    $repostTxt = $_POST['old_message'];
    $repostTime = date('H:i:s');
    $email = $_POST['email'];
    $postedTxt = $repostTxt;

    //Check if picture is sent and set flag accordinglysubstr($str, 4);
    $viewStampLnk = substr($_POST['old_image'], 7);
    if ($viewStampLnk == "") {
        $picFl = '0';
    } else {
        $picFl = '1';
    }
    //$viewStampLnk 	= '';
    $postedPic = substr($_POST['old_fullimage'], 7);
    //$unameFTP 		= '';
    //$pswdFTP 		= '';
    $filename = '';
    if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '') {
        //$picFl = '01000000';
        //$viewStampLnk = $_FILES['imagefile']['tmp_name'];
    }
    $protect = $protectionlevel; //00000000
    //Check Ends

    $title = (strlen($title) > 42) ? substr($title, 0, -6) . '..' : $title;

    //Set FieldsArray
    $fields = array(
        'title' => 'Rp: ' . $title,
        'repostTxt' => $repostTxt,
        'repostTime' => $repostTime,
        'picFl' => $picFl,
        'viewStampLnk' => $viewStampLnk,
        'postedPic' => $postedPic,
        //'unameFTP' 		=> $unameFTP,
        //'pswdFTP' 		=> $pswdFTP,
        'filename' => $filename,
        'email' => $email,
        'protect' => $protect,
        "topic" => $_SESSION["topic"]
    );
    //print_r($fields);exit;
    //Do Repost Service
    if ($re_post = re_post($username, $password, $fields) == TRUE) {
        $create_message = 'Repost successfully added';
    } else {
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}
/** Repost Service Starts * */
/** New Post Service Starts * */
if (isset($_POST['newpost_submit']) && $_POST['newpost_submit'] == 1) {
    //Set Posted values to respective variables
    $title = $_POST['title'];
    $postedTxt = $_POST['postedTxt'];
    $postTime = date('H:i:s');
    $email = $_POST['email'];
    //Check if picture is sent and set flag accordingly

    $filename = '';
    if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '' AND $_FILES['fileUploadField']['name'] != '') {
        $picFl = '1';
        $pic_file = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
        $file_file = $_FILES['fileUploadField']['tmp_name'];
        $file_flsz = filesize($file_file);
        if ($file_flsz < 1024) {
            $file_flsz = 1;
        } else {
            $file_flsz = $file_flsz / 1024;
            $file_flsz = round($file_flsz);
        }
        $filename = $_FILES['fileUploadField']['name'];
    } else if ($_FILES['imagefile']['name'] != '' AND $_FILES['fileUploadField']['name'] == '') {
        $picFl = '1';
        $pic_file = $_FILES['imagefile']['tmp_name'];
        $picName = $_FILES['imagefile']['name'];
        $file_flsz = '0';
    } else if ($_FILES['imagefile']['name'] == '' AND $_FILES['fileUploadField']['name'] != '') {
        $picFl = '0';
        $file_file = $_FILES['fileUploadField']['tmp_name'];
        $file_flsz = filesize($file_file);
        if ($file_flsz < 1024) {
            $file_flsz = 1;
        } else {
            $file_flsz = $file_flsz / 1024;
            $file_flsz = round($file_flsz);
        }
        $filename = $_FILES['fileUploadField']['name'];
    }//else if ($_FILES['imagefile']['name'] =='' AND $_FILES['file']['name'] !=''){
    //	$picFl = '01000000';
    //	}
    $filename = $_FILES['fileUploadField']['name'];
    $picName = $_FILES['imagefile']['name'];
    $protectionlevel = $_SESSION['level'];
    $protect = $protectionlevel; //00000000
    //Set FieldsArray
    $fields = array(
        'postedTxt' => $postedTxt,
        'title' => $title,
        'postTime' => $postTime,
        'picFl' => $picFl,
        'email' => $email,
        'picName' => $picName,
        'filename' => $filename,
        'file_file' => $file_file,
        'file_flsz' => $file_flsz,
        'protect' => $protect,
        'pic_file' => $pic_file,
        "topic" => $_SESSION["topic"]
    );
    //print_r($fields);exit;
    //Do New Post Service
    $new_post = create_new_post($username, $password, $fields);

    if ($new_post) {
        header('Location: ' . BASE_URL . 'showposts');
        return;
    } else {
        if (isset($_SESSION['mes']['redirect']) && $_SESSION['mes']['redirect'] !== false) {
            header('Location: ' . BASE_URL . $_SESSION['mes']['redirect']);
        }
        $create_message = $_SESSION['mes'];
    }

    if (isset($_SESSION['mes']))
        unset($_SESSION['mes']);
}

//*********************************************
//ALL DEFAULT PROCESSES************************
//*********************************************
//update the counts
updateLevelPostsCounts();

/** Get User Data Service Starts * */
$user_information = fetch_user_information($username, $password);
$_SESSION['user_details'] = $user_information;

if (!is_array($user_information) || $user_information == FALSE) {
    $error = 1;
    $create_message = $_SESSION['mes'];
    if (isset($_SESSION['mes']))
        unset($_SESSION['mes']);
}
//print_r($user_information); exit;
extract($user_information);
$_SESSION['total_posts'] = $countPosts;

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
