<?php

include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Select Level';
include_once(INCLUDE_PATH . '/socket_function.php');

$uname = $_SESSION['username'];
$upswd = $_SESSION['password'];
$viewerid = trim(urldecode($queryString[0]));
$vrUname = trim(urldecode($queryString[1]));

if ($_REQUEST["changeLevel"]) {


    if (isset($_POST['level0'])) {
        $level0 = 1;
    } else {
        $level0 = 0;
    }

    if (isset($_POST['level1'])) {
        $level1 = 1;
    } else {
        $level1 = 0;
    }

    if (isset($_POST['level2'])) {
        $level2 = 1;
    } else {
        $level2 = 0;
    }

    if (isset($_POST['level3'])) {
        $level3 = 1;
    } else {
        $level3 = 0;
    }

    if (isset($_POST['level4'])) {
        $level4 = 1;
    } else {
        $level4 = 0;
    }

    if (isset($_POST['level5'])) {
        $level5 = 1;
    } else {
        $level5 = 0;
    }

    if (isset($_POST['level6'])) {
        $level6 = 1;
    } else {
        $level6 = 0;
    }

    if (isset($_POST['level7'])) {
        $level7 = 1;
    } else {
        $level7 = 0;
    }

    if (isset($_POST['level8'])) {
        $level8 = 1;
    } else {
        $level8 = 0;
    }

    if (isset($_POST['level9'])) {
        $level9 = 1;
    } else {
        $level9 = 0;
    }


//$lev = $_POST['level'];
    //$selected_lev = implode(",",$lev);
    //print_r($lev);exit;
    //echo $numb = count($lev);exit;
    //for($i=0;$i=$numb;$i++;)
    //$protect ='0'.str_pad($_POST['level'], 7, "0", STR_PAD_RIGHT);
    $protect = $level0 . ',' . $level1 . ',' . $level2 . ',' . $level3 . ',' . $level4 . ',' . $level5 . ',' . $level6 . ',' . $level7 . ',' . $level8 . ',' . $level9;


    /* for($i=1;$i=10;$i++){
      $pro ='0'.str_pad($i, 7, "0", STR_PAD_RIGHT);
      $del = delete_level($uname, $password, $pro, $viewerid);
      } */
    if ($add_level = set_level($uname, $upswd, $protect, $viewerid) == TRUE) {
        $create_message = 'Level added successfully.';
    } else {
        $create_message = $_SESSION['mes'];
        if (isset($_SESSION['mes']))
            unset($_SESSION['mes']);
    }
}

$get_le = get_level($uname, $upswd);

$newlevel = rtrim($get_le["level"], ',');
$ge_level = explode(',', $newlevel);

//$oldviewerid = str_replace('%EF%BF%BD','',$oldviewerid);

