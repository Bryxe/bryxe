<?php
include_once(INCLUDE_PATH . '/check_session.php');
$pageTitle = 'New Post';
include_once(INCLUDE_PATH . '/socket_function.php');
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$protectionlevel = $_SESSION['level'];
