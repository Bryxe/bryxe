<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'Select Level';
//include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];

$oldviewerid = (isset($queryString[0])) ? $queryString[0] : '';

//$oldviewerid = str_replace('%EF%BF%BD','',$oldviewerid);