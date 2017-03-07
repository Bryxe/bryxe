<?php

include_once SITE_PATH . '/securimage/securimage.php';
$securimage = new Securimage();
$contactResults = false;
$validationErrors = false;

if (isset($_REQUEST['captcha_code'])) {

    if ($securimage->check(trim(stripslashes($_REQUEST['captcha_code']))) == false) {
        // the code was incorrect
        // you should handle the error so that the form processor doesn't continue
        // or you can use the following code if there is no validation or you do not know how
        $contactResults = "The security code entered was incorrect.<br /><br />";
        $validationErrors = true;
    }

    $email = trim(stripslashes(strip_tags($_REQUEST["email"])));
    $emailConf = trim(stripslashes(strip_tags($_REQUEST["emailconfirm"])));
    $name = trim(stripslashes(strip_tags($_REQUEST["name"])));
    $reason = trim(stripslashes(strip_tags($_REQUEST["reason"])));
    $message = trim(stripslashes(strip_tags($_REQUEST["message"])));

    if ($email != $emailConf) {
        $contactResults .= "The email address you entered must match<br />";
        $validationErrors = true;
    }

    if (!validateEmail($email)) {
        $contactResults .= "The email address you entered is not valid<br />";
        $validationErrors = true;
    }

    if (strlen($name) < 3) {
        $contactResults .= "You must enter your full name<br />";
        $validationErrors = true;
    }

    if (strlen($reason) < 3) {
        $reason = "Contact";
    }

    if (strlen($message) < 3) {
        $validationErrors = true;
        $contactResults .= "You must enter a message<br />";
    }

    if (!$contactResults) {
        //no errors send email...
        $sender = "From: Byrxe <" . FROM_ADDRESS . ">\n";
        $payload = "There is a new message from $name ($email), the message is:<br><br>"
            . "$message"
            . "<br><br>"
            . "--------------------------------"
            . "<br>From Bryxe's online form";

        if (sendEmail(CONTACT_TO_ADDRESS, $payload, $reason, $sender)) {
            $contactResults = "Your message was sent. We will contact you shortly.<br /> Thank you!";
            $email = $emailConf = $name = $reason = $message = "";
        } else {
            $validationErrors = true;
            $contactResults = "We couldn't deliver your message right now, please try again later.<br /> Thank you!";
        }
    }
}
