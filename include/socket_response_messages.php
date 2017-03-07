<?php

/*
  this array relates for each command all possible responses and error messages to display to the user
  if no command/error text is set, we display the default verbiage set at the end of the array.
 */

$sockErrorMsgs = array(
    "7"//Add new post
    => array(
        "4" => array(
            "dialog" => false,
            "redirect" => "space",
            "title" => "No space left",
        ),
        "5" => array(
            "dialog" => false,
            "redirect" => "subscription",
            "title" => "Extended period expired",
        ),
        "6" => array(
            "dialog" => false,
            "redirect" => "subscription",
            "title" => "Trial period expired",
        ),
        "7" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "File already exists",
        ),
    ),
    "1"//registration
    => array(
        "2" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "The user name you chose is not available but %1% is, or you can select another name",
        ),
        "3" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "A full name with the given email exists",
        ),
        "4" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "The given email exists on the system",
        ),

    ),
    "3"//Login
    => array(
        "7" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "Wrong username or password"
        ),
        "6" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "Please verify your email before you login"
        )
    ),
    "4"//Set user data
    => array(
        "2" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "Password is not updated",
        ),
        "3" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "User is blocked.",
        ),
    ),
    "5"//Set user data
    => array(
        "2" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "No users found, try a different search",
        ),
    ),
    "10"//fetch posts
    => array(
        "8" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "No posts found",
        ),
    ),
    "14"//delete posts
    => array(
        "0" => array(
            "dialog" => false,
            "redirect" => false,
            "title" => "Could not delete the post, try again later",
        ),
    ),
    "default"
    => "System error. Please report the following text to us so we can fix it. Thank you. Error code: ",
);

//returns the  message or the default message if none set for a given command and response code
function getSocketErrorMsg($sentCommand, $responseCodeString)
{
    global $sockErrorMsgs;
    $firstResponseChar = mb_substr($responseCodeString, 0, 1);

    $return = null;
    if (!isset($sockErrorMsgs[$sentCommand][$firstResponseChar])) {
        $return = $sockErrorMsgs["default"] . $responseCodeString;
    } else {
        if (!$sockErrorMsgs[$sentCommand][$firstResponseChar]["dialog"] && !$sockErrorMsgs[$sentCommand][$firstResponseChar]["redirect"]) {
            $return = $sockErrorMsgs[$sentCommand][$firstResponseChar]["title"];
        } else {
            $return = $sockErrorMsgs[$sentCommand][$firstResponseChar];
        }
    }
    return $return;
}