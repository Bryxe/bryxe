<?php

include_once(INCLUDE_PATH . '/socket_function.php');

if (isset($queryString[0])) {
    $code = $queryString[0];
    $_SESSION['validation_msg'] = validate_user($code);
    echo $_SESSION['validation_msg'];
    $pageTitle = 'Confirm User';
    //header('Location: ' . BASE_URL);
    echo "<script> setTimeout(function() { window.location = '".BASE_URL."' }, 3000);</script>";
}
