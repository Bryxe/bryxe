<?php

$pageTitle = 'Confirm User';
include_once(INCLUDE_PATH . '/general_function.php');

if (isset($queryString[0])) {
    $email = $queryString[0];

    $content = "Just Content";
    $subject = "Please confirm your email!";
    $from = "contact@bryxe.com";
    $res = sendEmail("thgsantos16@gmail.com", $content, $subject, $from);
    echo $res;
}
