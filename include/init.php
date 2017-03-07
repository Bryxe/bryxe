<?php
include_once(INCLUDE_PATH . "/general_function.php");
include_once(INCLUDE_PATH . "/socket_function.php");

//Delete all previously downloaded images
deleteOldImages();

$queryString = array();
$pageName = parseRouting($queryString);
$controllerName = $pageName;

//if it is an abstract endpoint just call it and die
if ($pageName == "api") {
    include_once(COMMON_CORE_CONTROLLER . "/" . $controllerName . ".php");
    die();
}

//include the controller
if (file_exists(COMMON_CORE_CONTROLLER . "/" . $controllerName . ".php")) {
    include_once(COMMON_CORE_CONTROLLER . "/" . $controllerName . ".php");
}
flush(); //start sending a response asap
//include the headers
if ($pageName == 'showposts' || $pageName == 'showviewing' || $pageName == 'showviewer' || $pageName == 'search_users') {
    include_once(INCLUDE_PATH . "/header_general.php");
} else if ($pageName == 'index') {
    include_once(INCLUDE_PATH . "/index_header.php");
} else if ($pageName == 'about' || $pageName == 'terms' || $pageName == 'help' || $pageName == 'blog' || $pageName == 'space' || $pageName == 'subscription' || $pageName == 'privacy' || $pageName == 'contact') {
    if ($pageName == "blog") {
        //set seo title and contents...
        $customSeoTitle = "Jungle Challenge on Bryxe | Crossing Jungle Moments | We Need Jungle";
        $customSeoContent = "Bryxe Jungle Challenge: learn and share moments while seeking to win the challenge of crossing a real jungle - that friend of our environment";
    }
    include_once(INCLUDE_PATH . "/header_help.php");
} else {
    include_once(INCLUDE_PATH . "/header_slides.php");
}

//include the view
include_once(COMMON_CORE_VIEW . "/" . $pageName . ".php");
flush();
//include the footer
if ($pageName == 'index')
    include_once(INCLUDE_PATH . "/footer_index.php");
else if ($pageName == 'about' || $pageName == 'terms' || $pageName == 'help' || $pageName == 'blog' || $pageName == 'space' || $pageName == 'subscription' || $pageName == 'privacy' || $pageName == 'contact') {
    include_once(INCLUDE_PATH . "/footer_help.php");
} else
    include_once(INCLUDE_PATH . "/footer_general.php");

flush();
