<?php
session_start();
set_time_limit(0);
error_reporting(0);
ini_set('max_execution_time', 0);
//date_default_timezone_set('Asia/Calcutta');

define("FROM_ADDRESS", "contact@bryxe.com");
define("CONTACT_TO_ADDRESS", "frmpst@bryxe.com");
define("SITE_NAME", "Bryxe");
define("SITE_URL", "");
define("SITE_PATH", $_SERVER["DOCUMENT_ROOT"] . SITE_URL);
define("COMMON_CORE_PATH", SITE_PATH . "/common_class");
define("INCLUDE_PATH", SITE_PATH . "/include");
define("COMMON_CORE_MODEL", SITE_PATH . "/model");
define("COMMON_CORE_CONTROLLER", SITE_PATH . "/controller");
define("COMMON_CORE_VIEW", SITE_PATH . "/view");
define("SENT_FILE", SITE_PATH . "/SentFiles");

define("BASE_URL", "//" . $_SERVER['HTTP_HOST'] . SITE_URL . "/");
define("CSS_PATH", BASE_URL . "css");
define("JS_PATH", BASE_URL . "js");
define("IMAGES_PATH", BASE_URL . "images");
define("IMAGES_SIZE", 700000);

define("FTP_SERVER", "www.acupic.com");
/*define("IMAGE_DOWNLOAD_PATH", BASE_URL . "downloads/");
define("IMAGE_DOWNLOAD_PATH_THUMB", BASE_URL . "downloads/thumb/");*/
define("IMAGE_DOWNLOAD_PATH", "//");
define("IMAGE_DOWNLOAD_PATH_THUMB", "//");

//force https
/*
if (empty($_SERVER['HTTPS'])) { //HTTPS
     header("Location:". "https://".$_SERVER['HTTP_HOST'].SITE_URL."/");
}
 */
