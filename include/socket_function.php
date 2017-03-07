<?php

include_once(INCLUDE_PATH . "/socket_response_messages.php");

$socket_buffer = ''; //Global Variable
//
//Convert String to Hexadecimal ----------------------------------------------------

function strToHex($string)
{
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

//Socket Initialization ----------------------------------------------------
function socket_init()
{
    $sock = socket_create(AF_INET, SOCK_STREAM, 0);
    if (!$sock) {
        return false;
    }

    //$connect = socket_connect($sock, "bryxe.com", 53153);
    $connect = socket_connect($sock, "acutest.dyndns-work.com", 53153);
    //$connect = socket_connect($sock, "192.169.2.1", 53153);
    //$connect = socket_connect($sock, " 216.55.138.212", 53153);
    //$connect = socket_connect($sock, "192.168.250.10", 53153);

    if (!$connect) {
        return false;
    } else {
        return array($sock);
    }
}

//Receive Socket Data
function receive_socket_data($sock, $byte = 256)
{
    global $socket_buffer;
    $result = '';
    $received_bytes = socket_recv($sock, $result, $byte, 0);

    if ($received_bytes > 0) {    // both this and below must be changed to this!
        $socket_buffer .= $result;
    }

    if ($received_bytes > 0) {
        receive_socket_data($sock, $byte);
    } else {
        /* $filename = time().'_'.$_SERVER['REMOTE_ADDR'].'_'.'output';
          $fp = fopen('Socketfiles/'.$filename.'.dat', 'w+');
          fwrite($fp, $socket_buffer, strlen($socket_buffer));
          fclose($fp);
          $socket_buffer = '';
          return $filename; */
        return $socket_buffer;
    }
}

function validate_user($code)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $command = '32';
    $logon_string = $command . "\0" . $code . "\4";

    // echo($logon_string)."<br>";
    // die();
    $logon_message = pack('A*', $logon_string);

    //Send Data
    $send = socket_send($sock, $logon_message, strlen($logon_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($command, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';


    $fieldsArray = array("result_code");

    $dataArray = parseDataFields($data, $fieldsArray);


    if (isset($dataArray["result_code"]) && ((int)$dataArray["result_code"]) == 1) {
        socket_close($sock);
        return "Email has been verified, you may login.<br><small>You will be redirected shortly</small>.";
    } elseif (isset($dataArray["result_code"]) && ((int)$dataArray["result_code"]) != 1) {
        socket_close($sock);
        return "Wrong or expired verification link. Please contact our support.";
    }
}

//Fetch User  Information ----------------------------------------------------
function fetch_user_information($uname, $password)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $command = '3';
    $logon_string = $command . "\0" . $uname . "\0" . $password . "\4";

    $logon_message = pack('A*', $logon_string);

    //Send Data
    $send = socket_send($sock, $logon_message, strlen($logon_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($command, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);


    $data = $socket_buffer;
    $socket_buffer = '';


    $fieldsArray = array("result_code",
        "fullName",
        "city",
        "state",
        "country",
        "email",
        "webPg",
        "bioDesc",
        "userPgLnk",
        "timeZoneHr",
        "timeZoneMin",
        "ublocked",
        "notify",
        "pic",
        "picPath",
        "stampPath",
        "protect",
        "countPosts",
        "viewingCount",
        "viewerCount");

    $dataArray = parseDataFields($data, $fieldsArray);


    if (isset($dataArray["result_code"]) && ((int)$dataArray["result_code"]) == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($command, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//fetch info of other user
//Fetch Posts ------------------------------------------------------------
function fetch_posts($uname, $password, $ownerId, $protect, &$start, $count, $visitunm, $topic = 0)
{

    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    $command = 10;
    $plainMessage = $command . "\0" . $uname . "\0" . $password . "\0" . $ownerId . "\0" . $start . "\0" . $count . "\0" . $topic . "\0" . $visitunm . "\0" . $protect . "\4";
    //die($plainMessage);
    $show_post_message = pack("A*", $plainMessage);
    $send = socket_send($sock, $show_post_message, strlen($show_post_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
        "nextSch",
        "totalCnt",
        "topCnt", // this is the equivalent to currPosts in the documentation
        "newTopCnt", // this is the equivalent to newPosts in the documentation
        "topFlg", // this is the equivalent to newFlag in the documentation
        "levCnt",
        "newLevCnt",
        "levFlg"
    );

    $postsFields = array(
        "stampPicID",
        "fullPicID",
        "uname",
        "ufullname",
        "ublocked",
        "title",
        "postTime",
        "viewStampLnk",
        "postedPic",
        "fileLnk",
        "postedTxt",
        "postRef"
    );

    $dataArray = parseDataFields($data, $mainFields, $postsFields);

    // print_r($dataArray);
    // die();

    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {

        $start = $dataArray["nextSch"];
        // echo "count:".$dataArray["count"]. " nextSch:".$dataArray["nextSch"]." totalCnt:".$dataArray["totalCnt"]." topCnt:".$dataArray["topCnt"];
        // echo " newTopCnt:".$dataArray["newTopCnt"]." levCnt:".$dataArray["levCnt"]." newLevCnt:".$dataArray["newLevCnt"];
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($command, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Create New Post ----------------------------------------------------
function create_new_post($uname, $password, $fields, $overwrite = 2)
{

    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $command = "7";
    $body = $fields['postedTxt'];
    $title = $fields['title'];
    $time = $fields['postTime'];
    $picFl = $fields['picFl'];
    $email = $fields['email'];
    $picName = $fields['picName'];
    $filename = $fields['filename'];
    $fileSize = $fields['file_flsz'];
    $protect = $fields['protect'];
    $topic = $fields['topic'] ? $fields['topic'] : 0;

    if (filesize($fields['pic_file']) < IMAGES_SIZE) {
        $postMessage = $command . "\0" . $uname . "\0" . $password . "\0" . $body . "\0" . $title . "\0" . $time . "\0";
        $postMessage .= $picFl . "\0" . $email . "\0" . $picName . "\0" . $filename . "\0" . $fileSize . "\0" . $topic . "\0" . $protect . "\4";

        //echo $postMessage . " ";
        $file_text = pack('A*', $postMessage);
        $newpost_file = $file_text;

        $send = socket_send($sock, $newpost_file, strlen($newpost_file), 0);

        if (!$send) {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, '10054');
            $_SESSION['mes'] = $mes;

            return false;
        }
    } else {
        socket_close($sock);
        $mes = "Image Size must be less than 700kb.";
        $_SESSION['mes'] = $mes;

        return false;
    }
    $receive = socket_recv($sock, $after_post_receive, 3, MSG_WAITALL);

    $responseCode = (int)substr($after_post_receive, 0, 1);

    if ($responseCode == 1 || $responseCode == 7) {//ALL OK
        if ($responseCode == 7) {//FILE ALREADY EXISTS
            $_SESSION['mes'] = getSocketErrorMsg($command, $after_post_receive);
            $sendText = pack('A*', $overwrite . "\4");
            $send = socket_send($sock, $sendText, strlen($sendText), 0);

            if (!$send) {
                socket_close($sock);
                $mes = getSocketErrorMsg($cmd, '10054');
                $_SESSION['mes'] = $mes;
                return false;
            }
            //do not overwrite, stop and return with the "error"
            if ($overwrite == 2) {
                return false;
            }
            unset($_SESSION['mes']);
            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);
            $responseCode = (int)substr($finalpost_file_receive, 0, 1);
        }

        // Send a picture file if one was included
        if ($picFl == '1' && $fields['pic_file'] != '') {

            $pic_file = $fields['pic_file'];
            $sendPicSz = filesize($pic_file);
            $sendFileSz = $sendPicSz . "\4";
            $file_sz_text = pack('A*', $sendFileSz);
            $newpost_file_sz = $file_sz_text;

            $send = socket_send($sock, $newpost_file_sz, strlen($newpost_file_sz), 0);

            if (!$send) {
                socket_close($sock);
                $mes = getSocketErrorMsg($cmd, '10054');
                $_SESSION['mes'] = $mes;
                return false;
            }

            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

            $responseCode = (int)substr($finalpost_file_receive, 0, 1);

            if ($responseCode == 1) {//ALL OK
                $sz = 256;
                $fp = fopen($fields['pic_file'], 'rb', FILE_USE_INCLUDE_PATH);
                while (!feof($fp)) {
                    $pic_file = fread($fp, $sz);
                    $actualBytes = mb_strlen($pic_file, '8bit');
                    $send = socket_send($sock, $pic_file, $actualBytes, 0);

                    if (!$send) {
                        $errorcode = socket_last_error();
                        $errormsg = socket_strerror($errorcode);
                        socket_clear_error();
                        socket_close($sock);
                        fclose($fp);
                        $mes = getSocketErrorMsg($command, '10054');
                        $_SESSION['mes'] = $mes;
                        return false;
                    }
                }
                fclose($fp);

                $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                $responseCode = (int)substr($finalpost_file_receive, 0, 1);

                if ($responseCode == 1) {//ALL OK
                    if ($fields['file_file'] == '') {
                        socket_close($sock);
                        $_SESSION['mes'] = "";
                        return true;
                    } else {
                        $picFl = '0';
                    }
                } else {
                    if ($finalpost_file_receive) {
                        socket_close($sock);
                        $_SESSION['mes'] = getSocketErrorMsg($command, $finalpost_file_receive);
                        return false;
                    } else {
                        socket_close($sock);
                        $_SESSION['mes'] = getSocketErrorMsg($command, 'AttachmentError');
                        return false;
                    }
                }
            }
        }

        if ($picFl == '0' && $fields['file_file'] != '') {

            $sz = 256;
            $file_file = $fields['file_file'];
            $fp = fopen($fields['file_file'], 'rb', FILE_USE_INCLUDE_PATH);

            while (!feof($fp)) {
                $file_file = fread($fp, $sz);
                $actualBytes = mb_strlen($file_file, '8bit');
                $send = socket_send($sock, $file_file, $actualBytes, 0);
                if (!$send) {
                    $errorcode = socket_last_error();
                    $errormsg = socket_strerror($errorcode);
                    socket_clear_error();
                    socket_close($sock);
                    fclose($fp);
                    $mes = getSocketErrorMsg($command, '10054');
                    $_SESSION['mes'] = $mes;
                    return false;
                }
            }
            fclose($fp);

            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

            $responseCode = (int)substr($finalpost_file_receive, 0, 1);
            if ($responseCode == 1) {//ALL OK
                socket_close($sock);
                $_SESSION['mes'] = "";
                return true;
            } else {
                if ($finalpost_file_receive) {
                    socket_close($sock);
                    $_SESSION['mes'] = getSocketErrorMsg($command, $finalpost_file_receive);
                    return false;
                } else {
                    socket_close($sock);
                    $_SESSION['mes'] = getSocketErrorMsg($command, 'AttachmentError');
                    return false;
                }
            }
            //}
        } else {
            socket_close($sock);
            $_SESSION['mes'] = "";
            return true;
        }
    } else {
        socket_close($sock);

        $_SESSION['mes'] = getSocketErrorMsg($command, $after_post_receive);
        return false;
    }
}

//edit Post ----------------------------------------------------
function edit_post($uname, $password, $fields, $overwrite = 2)
{

    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $command = "28";
    $body = $fields['postedTxt'];
    $title = $fields['title'];
    $time = $fields['postTime'];
    $postRef = $fields['postRef'];
    $picFl = $fields['picFl'];
    $email = $fields['email'];
    $picName = $fields['picName'];
    $filename = $fields['filename'];
    $fileSize = $fields['file_flsz'];
    $protect = $fields['protect'];
    $topic = $fields['topic'] ? $fields['topic'] : 0;

    if (filesize($fields['pic_file']) < IMAGES_SIZE) {
        $postMessage = $command . "\0" . $uname . "\0" . $password . "\0" . $body . "\0" . $title . "\0" . $time . "\0" . $postRef . "\0";
        $postMessage .= $picFl . "\0" . $email . "\0" . $picName . "\0" . $filename . "\0" . $fileSize . "\0" . $topic . "\0" . $protect . "\4";

        //echo str_replace("\0", " | ", $postMessage);
        //die();
        $file_text = pack('A*', $postMessage);
        $newpost_file = $file_text;

        $send = socket_send($sock, $newpost_file, strlen($newpost_file), 0);

        if (!$send) {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, '10054');
            $_SESSION['mes'] = $mes;

            return false;
        }
    } else {
        socket_close($sock);
        $mes = "Image Size must be less than 700kb.";
        $_SESSION['mes'] = $mes;

        return false;
    }
    $receive = socket_recv($sock, $after_post_receive, 3, MSG_WAITALL);

    $responseCode = (int)substr($after_post_receive, 0, 1);

    if ($responseCode == 1 || $responseCode == 7) {//ALL OK
        if ($responseCode == 7) {//FILE ALREADY EXISTS
            $_SESSION['mes'] = getSocketErrorMsg($command, $after_post_receive);
            $sendText = pack('A*', $overwrite . "\4");
            $send = socket_send($sock, $sendText, strlen($sendText), 0);

            if (!$send) {
                socket_close($sock);
                $mes = getSocketErrorMsg($cmd, '10054');
                $_SESSION['mes'] = $mes;
                return false;
            }
            //do not overwrite, stop and return with the "error"
            if ($overwrite == 2) {
                return false;
            }
            unset($_SESSION['mes']);
            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);
            $responseCode = (int)substr($finalpost_file_receive, 0, 1);
        }

        // Send a picture file if one was included
        if ($picFl == '1' && $fields['pic_file'] != '') {

            $pic_file = $fields['pic_file'];
            $sendPicSz = filesize($pic_file);
            $sendFileSz = $sendPicSz . "\4";
            $file_sz_text = pack('A*', $sendFileSz);
            $newpost_file_sz = $file_sz_text;

            $send = socket_send($sock, $newpost_file_sz, strlen($newpost_file_sz), 0);

            if (!$send) {
                socket_close($sock);
                $mes = getSocketErrorMsg($cmd, '10054');
                $_SESSION['mes'] = $mes;
                return false;
            }

            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

            $responseCode = (int)substr($finalpost_file_receive, 0, 1);

            if ($responseCode == 1) {//ALL OK
                $sz = 256;
                $fp = fopen($fields['pic_file'], 'rb', FILE_USE_INCLUDE_PATH);
                while (!feof($fp)) {
                    $pic_file = fread($fp, $sz);
                    $actualBytes = mb_strlen($pic_file, '8bit');
                    $send = socket_send($sock, $pic_file, $actualBytes, 0);

                    if (!$send) {
                        $errorcode = socket_last_error();
                        $errormsg = socket_strerror($errorcode);
                        socket_clear_error();
                        socket_close($sock);
                        fclose($fp);
                        $mes = getSocketErrorMsg($command, '10054');
                        $_SESSION['mes'] = $mes;
                        return false;
                    }
                }
                fclose($fp);

                $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                $responseCode = (int)substr($finalpost_file_receive, 0, 1);

                if ($responseCode == 1) {//ALL OK
                    if ($fields['file_file'] == '') {
                        socket_close($sock);
                        $_SESSION['mes'] = "";
                        return true;
                    } else {
                        $picFl = '0';
                    }
                } else {
                    if ($finalpost_file_receive) {
                        socket_close($sock);
                        $_SESSION['mes'] = getSocketErrorMsg($command, $finalpost_file_receive);
                        return false;
                    } else {
                        socket_close($sock);
                        $_SESSION['mes'] = getSocketErrorMsg($command, 'AttachmentError');
                        return false;
                    }
                }
            }
        }

        if ($picFl == '0' && $fields['file_file'] != '') {

            $sz = 256;
            $file_file = $fields['file_file'];
            $fp = fopen($fields['file_file'], 'rb', FILE_USE_INCLUDE_PATH);

            while (!feof($fp)) {
                $file_file = fread($fp, $sz);
                $actualBytes = mb_strlen($file_file, '8bit');
                $send = socket_send($sock, $file_file, $actualBytes, 0);
                if (!$send) {
                    $errorcode = socket_last_error();
                    $errormsg = socket_strerror($errorcode);
                    socket_clear_error();
                    socket_close($sock);
                    fclose($fp);
                    $mes = getSocketErrorMsg($command, '10054');
                    $_SESSION['mes'] = $mes;
                    return false;
                }
            }
            fclose($fp);

            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

            $responseCode = (int)substr($finalpost_file_receive, 0, 1);
            if ($responseCode == 1) {//ALL OK
                socket_close($sock);
                $_SESSION['mes'] = "";
                return true;
            } else {
                if ($finalpost_file_receive) {
                    socket_close($sock);
                    $_SESSION['mes'] = getSocketErrorMsg($command, $finalpost_file_receive);
                    return false;
                } else {
                    socket_close($sock);
                    $_SESSION['mes'] = getSocketErrorMsg($command, 'AttachmentError');
                    return false;
                }
            }
            //}
        } else {
            socket_close($sock);
            $_SESSION['mes'] = "";
            return true;
        }
    } else {
        socket_close($sock);

        $_SESSION['mes'] = getSocketErrorMsg($command, $after_post_receive);
        return false;
    }
}

//Repost ----------------------------------------------------
function re_post($uname, $password, $fields)
{

    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '9';
    $logon_string = $cmd . "\0" . $uname . "\0" . $password;

    $repostTxt = $fields['repostTxt'];
    $title = $fields['title'];
    $repostTime = $fields['repostTime'];

    $picFl = $fields['picFl'];

    if ($picFl == null) {
        $picFl = '0';
    }

    $viewStampLnk = $fields['viewStampLnk'];
    $postedPic = (!$fields['postedPic']) ? "" : $fields['postedPic'];
    $email = $fields['email'];
    $protect = $fields['protect'];
    $topic = $fields["topic"] ? $fields["topic"] : 0;

    $postMessage = $logon_string . "\0" . $repostTxt . "\0" . $title . "\0" . $repostTime . "\0";
    $postMessage .= $picFl . "\0" . $viewStampLnk . "\0" . $postedPic . "\0" . $email . "\0" . $topic . "\0" . $protect . "\4";
    $file_text = pack('A*', $postMessage);
    $repost_file = $file_text;

    $send = socket_send($sock, $repost_file, strlen($repost_file), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return true;
    }

    $receive = socket_recv($sock, $after_post_receive, 100, MSG_WAITALL);

    $responseCode = substr($after_post_receive, 0, 1);

    if ($responseCode == '1' || strpos($after_post_receive, "OK") > 0) {//ALL OK
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $after_post_receive);
        $_SESSION['mes'] = $mes;
        return true;
    }
}

//Reply Post ----------------------------------------------------
function reply_post($uname, $password, $fields)
{

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '8';
    $rep_logon_string = $cmd . "\0" . $uname . "\0" . $password;

    $replyTxt = $fields['replyTxt'];
    $title = $fields['title'];
    $replyTime = $fields['replyTime'];

    $picFl = $fields['picFl'];

    if ($picFl == null) {
        $picFl = '0';
    }
    $email = $fields['email'];
    $picName = $fields['picName'];
    $filename = $fields['filename'];
    $protect = $fields['protect'];
    $topic = $fields['topic'];
    $oldusername = $fields['oldusername'];

    if (filesize($fields['pic_file']) < IMAGES_SIZE) {
        $postMessage = $rep_logon_string . "\0" . $replyTxt . "\0" . $title . "\0" . $oldusername . "\0" . $replyTime . "\0";
        $postMessage .= $picFl . "\0" . $email . "\0" . $picName . "\0" . $filename . "\0" . $topic . "\0" . $protect . "\4";
        $file_text = pack('A*', $postMessage);
        $reply_file = $file_text;

        $send = socket_send($sock, $reply_file, strlen($reply_file), 0);
        if (!$send) {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, '10054');
            $_SESSION['mes'] = $mes;
            return false;
        }

        $receive = socket_recv($sock, $after_reply_receive, 3, MSG_WAITALL);

        $responseCode = substr($after_reply_receive, 0, 1);
        if ($responseCode == '1') {//ALL OK
            if ($picFl == '1' && $fields['pic_file'] != '') {

                $pic_file = $fields['pic_file'];
                $sendPicSz = filesize($pic_file);
                $sendFileSz = $sendPicSz . "\0";
                $file_sz_text = pack('A*', $sendFileSz);
                $newpost_file_sz = $file_sz_text;

                $send = socket_send($sock, $newpost_file_sz, strlen($newpost_file_sz), 0);

                if (!$send) {
                    socket_close($sock);
                    $mes = getSocketErrorMsg($cmd, '10054');
                    $_SESSION['mes'] = $mes;

                    return false;
                }

                $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                $responseCode = substr($finalpost_file_receive, 0, 1);
                if ($responseCode == '1') {//ALL OK
                    $sz = 256;
                    $pic_file = $fields['pic_file'];
                    $fp = fopen($fields['pic_file'], 'rb', FILE_USE_INCLUDE_PATH);
                    while (!feof($fp)) {
                        $pic_file = fread($fp, $sz);
                        $actualBytes = mb_strlen($pic_file, '8bit');
                        $send = socket_send($sock, $pic_file, $actualBytes, 0);

                        if (!$send) {
                            $errorcode = socket_last_error();
                            $errormsg = socket_strerror($errorcode);
                            socket_clear_error();
                            socket_close($sock);
                            fclose($fp);
                            $mes = getSocketErrorMsg($cmd, '10054');
                            $_SESSION['mes'] = $mes;
                            return false;
                        }
                    }
                    fclose($fp);

                    $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                    $responseCode = substr($finalpost_file_receive, 0, 1);
                    if ($responseCode == '1') {//ALL OK
                        socket_close($sock);
                        return true;
                    } else {
                        socket_close($sock);
                        $mes = getSocketErrorMsg($cmd, $finalpost_file_receive);
                        $_SESSION['mes'] = $mes;
                        return true;
                    }
                }
            } else {
                socket_close($sock);
                return true;
            }
        } else {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, $after_reply_receive);
            $_SESSION['mes'] = $mes;
            return true;
        }
    } else {
        socket_close($sock);
        $mes = "Picture size must be less then 700kb.";
        $_SESSION['mes'] = $mes;

        return false;
    }
}

//Show Viewing ----------------------------------------------------
function fetch_viewing_information($uname, $password, $protect, $start, $count)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '11';

    $protect = 0;
    $show_viewing_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $start . "\0" . $count . "\0" . $protect . "\4";
    $show_viewing_message = pack('A*', $show_viewing_string);

    $send = socket_send($sock, $show_viewing_message, strlen($show_viewing_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);
    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
        "cntLeft"
    );

    $recurrentFields = array(
        "stampPicID",
        "picID",
        "userPgLnk",
        "fullNm",
        "uname",
        "uviewerBlk",
        "ublocked",
        "bioDesc"
    );


    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);
    // print_r($dataArray);
    // die();
    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Show Viewers ----------------------------------------------------
function fetch_viewer_information($uname, $password, $protect, $start, $count)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '12';
    $show_viewer_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $start . "\0" . $count . "\0" . $protect . "\4";


    $show_viewer_message = pack('A*', $show_viewer_string);


    $send = socket_send($sock, $show_viewer_message, strlen($show_viewer_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
        "cntLeft"
    );

    $recurrentFields = array(
        "stampPicID",
        "picID",
        "userPgLnk",
        "fullNm",
        "uname",
        "ublocked",
        "bioDesc",
        "viewerID",
        "protect"
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);


    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Get Viewer  Information ----------------------------------------------------
function get_user_information($uname, $password, $vwrUname)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '20';
    $logon_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $vwrUname . "\4";

    $logon_message = pack('A*', $logon_string);

    //Send Data
    $send = socket_send($sock, $logon_message, strlen($logon_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';

    $fieldsArray = array(
        "result_code",
        "fullName",
        "city",
        "state",
        "country",
        "email",
        "webPg",
        "bioDesc",
        "userPgLnk",
        "timeZoneHr",
        "timeZoneMin",
        "ublocked",
        "pic",
        "picPath",
        "stampPath",
        "protect"
    );

    $dataArray = parseDataFields($data, $fieldsArray);


    if (isset($dataArray["result_code"]) && ((int)$dataArray["result_code"]) == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $received_data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Get Level-----------------------------------------------
function get_level_count($uname, $password, $topic, $startLev, $levelCnt)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '21';
    $get_level_stri = $cmd . "\0" . $uname . "\0" . $password . "\0" . $topic . "\0" . $startLev . "\0" . $levelCnt . "\4";

    $get_level_message = pack('A*', $get_level_stri);

    $send = socket_send($sock, $get_level_message, strlen($get_level_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';


    $mainFields = array(
        "result_code",
        "count"
    );

    $recurrentFields = array(
        "currentLevel",
        "currentLevelOwnerId",
        "levelGral",
        "levelNw",
        "levelCurrentTopic"
    );

    //die($data);
    $dataArray = parseDataFields($data, $mainFields, $recurrentFields, ",");
    //  die(print_r($dataArray));
    // print_r($dataArray);
    // die();
    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Get Level-----------------------------------------------
function get_level($uname, $password)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '19';
    $get_level_stri = $cmd . "\0" . $uname . "\0" . $password . "\4";

    //echo $get_level_stri . "<br/>";

    $get_level_message = pack('A*', $get_level_stri);

    $send = socket_send($sock, $get_level_message, strlen($get_level_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
        "current_user_id",
    );
    $recurrentFields = array(
        "level",
        "owner_id",
        "owner_name",
        "level_name"
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields, ',');
    // print_r($dataArray);
    // die();
    if (isset($dataArray['result_code']) && $dataArray['result_code'] == 1) {

        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//set Level

function set_level($uname, $upswd, $protect, $viewerid)
{
    $conn = socket_init();
    $sock = $conn[0];
    //echo $uname.','.$upswd.','.$protect.','.$viewerid;exit;
    //Generate String
    $cmd = '15';

    $add_level_string = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $viewerid . "\0" . $protect . "\4";


    $add_level_message = pack('A*', $add_level_string);
    $send = socket_send($sock, $add_level_message, strlen($add_level_message), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = strToHex($result);
    if ($resultCode == '1000') {
//    $resultCode = substr($result, 0, 1);
//    if ($resultCode == '1') {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//set level name
function set_level_name($uname, $upswd, $name, $protect)
{
    $conn = socket_init();
    $sock = $conn[0];
    //Generate String
    $cmd = '31';

    $addString = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $name . "\0" . $protect . "\4";
    $commandString = pack('A*', $addString);
    $send = socket_send($sock, $commandString, strlen($commandString), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    if ((int)$result == 1) {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//add level
function add_level($uname, $upswd, $name)
{
    $conn = socket_init();
    $sock = $conn[0];
    //Generate String
    $cmd = '29';

    $addString = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $name . "\4";

    $commandString = pack('A*', $addString);
    $send = socket_send($sock, $commandString, strlen($commandString), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);

    if ((int)$result == 1) {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//delete level
function del_level($uname, $upswd, $protect)
{
    $conn = socket_init();
    $sock = $conn[0];
    //Generate String
    $cmd = '30';

    $add_level_string = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $protect . "\4";

    $add_level_message = pack('A*', $add_level_string);
    $send = socket_send($sock, $add_level_message, strlen($add_level_message), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = (int)($result);
    if ($resultCode == 1) {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//add topic
function add_topic($uname, $upswd, $topicnm)
{
    $conn = socket_init();
    $sock = $conn[0];
    //echo $uname.','.$upswd.','.$topicnm;exit;
    //Generate String
    $cmd = '23';

    $addString = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $topicnm . "\4";

    $commandString = pack('A*', $addString);
    $send = socket_send($sock, $commandString, strlen($commandString), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);

    if ((int)$result == 1) {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//delete topic
function del_topic($uname, $upswd, $topicnm)
{
    $conn = socket_init();
    $sock = $conn[0];
    //echo $uname.','.$upswd.','.$topicnm;exit;
    //Generate String
    $cmd = '24';

    $add_level_string = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $topicnm . "\4";

    $add_level_message = pack('A*', $add_level_string);
    $send = socket_send($sock, $add_level_message, strlen($add_level_message), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = (int)($result);
    if ($resultCode == 1) {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Get Topics
function get_topics($uname, $password, $userId, $level)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    $cmd = 25;
    $plainMessage = $cmd . "\0" . $uname . "\0" . $password . "\0" . $userId . "\0" . $level . "\4";

    //echo str_replace("\0","NULL", $plainMessage)." ";
    //die();
    $commandString = pack("A*", $plainMessage);

    $send = socket_send($sock, $commandString, strlen($commandString), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);
    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
    );

    $recurrentFields = array(
        "topic_id",
        "topic",
        "oldposts",
        "newposts"
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);

    // print_r($dataArray);
    // die();
    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Get Member Topics
function get_member_topics($uname, $password)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    $cmd = 26;
    $plainMessage = $cmd . "\0" . $uname . "\0" . $password . "\4";
    $commandString = pack("A*", $plainMessage);

    $send = socket_send($sock, $commandString, strlen($commandString), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);
    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
    );

    $recurrentFields = array(
        "username",
        "topic"
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);
    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//SEARCH Member Topics
function sch_member_topics($uname, $password, $search)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //$search = str_pad($search, 30);
    $cmd = 27;
    $plainMessage = $cmd . "\0" . $uname . "\0" . $password . "\0" . $search . "\4";

    $commandString = pack("A*", $plainMessage);

    $send = socket_send($sock, $commandString, strlen($commandString), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);
    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
    );

    $recurrentFields = array(
        "username",
        "topic"
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);

    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Send password
function send_pass($uname, $password)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '18';

    $send_password_string = $cmd . "\0" . $uname . "\0" . $password . "\4";

    $send_password_message = pack('A*', $send_password_string);
    $send = socket_send($sock, $send_password_message, strlen($send_password_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $result = strToHex($result);
    socket_close($sock);
    return true;
}

//Delete Level ----------------------------------------------------
function delete_level($uname, $upswd, $pro, $viewerid)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String

    $cmd = '16';
    $add_level_string = $cmd . "\0" . $uname . "\0" . $upswd . "\0" . $protect . "\0" . $viewerid . "\4";

    $add_level_message = pack('A*', $add_level_string);
    $send = socket_send($sock, $add_level_message, strlen($add_level_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = strToHex($result);

    if ($resultCode == '1000') {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Add Viewing ----------------------------------------------------
function add_viewing($uname, $password, $protect, $userNm)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '13';
    $add_viewing_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $protect . "\0" . $userNm . "\4";

    $add_viewing_message = pack('A*', $add_viewing_string);

    $send = socket_send($sock, $add_viewing_message, strlen($add_viewing_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = strToHex($result);

    if ($resultCode == '1000') {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Delete Viewing ----------------------------------------------------
function delete_viewing($uname, $password, $protect, $userNm)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '14';
    $del_viewing_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $protect . "\0" . $userNm . "\4";

    $add_viewing_message = pack('A*', $del_viewing_string);

    $send = socket_send($sock, $add_viewing_message, strlen($add_viewing_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    socket_recv($sock, $result, 4, 0);
    $resultCode = strToHex($result);
    if ($resultCode == '1000') {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $result);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Delete Viewing ----------------------------------------------------
function delete_post($uname, $password, $postRef)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '22';
    $del_post_string = $cmd . "\0" . $uname . "\0" . $password . "\0" . $postRef . "\4";

    $del_post_message = pack('A*', $del_post_string);

    $send = socket_send($sock, $del_post_message, strlen($del_post_message), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $receive = socket_recv($sock, $after_post_receive, 100, MSG_WAITALL);

    $responseCode = substr($after_post_receive, 0, 1);

    if ($responseCode == '1') {
        socket_close($sock);
        return true;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $after_post_receive);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Registration ----------------------------------------------------
function registration($fields)
{
    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '1';

    $uname = $fields['uname'];
    $userPwd = $fields['userPwd'];
    $fullName = $fields['fullName'];
    $city = $fields['city'];
    $state = $fields['state'];
    $country = $fields['country'];
    $email = $fields['email'];
    $webPg = $fields['webPg'];
    $bioDesc = $fields['bioDesc'];
    $timeZone = $fields['timeZone'] + 12;
    $pic = $fields['pic'];
    $picFile = $fields['picFile'];
    $protect = $fields['protect'];

    $file_text = $cmd . "\0" . $uname . "\0" . $userPwd . "\0" . $fullName . "\0" . $city . "\0" . $state . "\0" . $country . "\0" . $email . "\0";
    $file_text .= $webPg . "\0" . $bioDesc . "\0" . $timeZone . "\0" . $pic . "\0" . $picFile . "\0" . $protect . "\4";
    $file_text = pack('A*', $file_text);

    $send = socket_send($sock, $file_text, strlen($file_text), 0);

    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return true;
    }

    $receive = socket_recv($sock, $after_post_receive, 3, MSG_WAITALL);

    $after_post_receive_code = substr($after_post_receive, 0, 1);
    //print_r($after_post_receive);exit;
    if ($after_post_receive_code == '1') {
        //echo 'hiccccc';
        if ($pic == '1' && $fields['picFile'] != '') {

            $pic_file = $fields['pic_file'];
            $sendPicSz = filesize($pic_file);
            $sendFileSz = $sendPicSz . "\0";
            $file_sz_text = pack('A*', $sendFileSz);
            $newpost_file_sz = $file_sz_text;

            $send = socket_send($sock, $newpost_file_sz, strlen($newpost_file_sz), 0);

            if (!$send) {
                socket_close($sock);
                $mes = getSocketErrorMsg($cmd, '10054');
                $_SESSION['mes'] = $mes;

                return false;
            }

            $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

            $responseCode = substr($finalpost_file_receive, 0, 1);
            if ($responseCode == '1') {//ALL OK
                $sz = 256;
                $pic_file = $fields['pic_file'];
                $fp = fopen($fields['pic_file'], 'rb', FILE_USE_INCLUDE_PATH);
                while (!feof($fp)) {
                    $pic_file = fread($fp, $sz);
                    $actualBytes = mb_strlen($pic_file, '8bit');
                    $send = socket_send($sock, $pic_file, $actualBytes, 0);

                    if (!$send) {
                        $errorcode = socket_last_error();
                        $errormsg = socket_strerror($errorcode);
                        socket_clear_error();
                        socket_close($sock);
                        fclose($fp);
                        $mes = getSocketErrorMsg($cmd, '10054');
                        $_SESSION['mes'] = $mes;
                        return false;
                    }
                }
                fclose($fp);

                $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                $responseCode = substr($finalpost_file_receive, 0, 1);
                if ($responseCode == '1' || strpos($finalpost_file_receive, "OK") > 0) {//ALL OK
                    socket_close($sock);
                    return true;
                } else {
                    socket_close($sock);
                    return false;
                }
            }
        } else {
            socket_close($sock);
            return true;
        }
    } else if ($after_post_receive_code == '2') {
        $suggUname = substr($after_post_receive, 2, 18);
        $mes = getSocketErrorMsg($cmd, $after_post_receive);
        $_SESSION['mes'] = str_replace("%1%", "'$suggUname'", $mes);
        socket_close($sock);
        return false;
    } else {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $after_post_receive);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Search Users----------------------------------------------------
function search_users($uname, $password, $searchText, $start, $count)
{
    global $socket_buffer;

    $conn = socket_init();
    $sock = $conn[0];

    //Generate String
    $cmd = '5';
    $file_text = $cmd . "\0" . $uname . "\0" . $password . "\0" . $searchText . "\0" . $start . "\0" . $count . "\4";
    $file_text = pack('A*', $file_text);
    $send = socket_send($sock, $file_text, strlen($file_text), 0);
    if (!$send) {
        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, '10054');
        $_SESSION['mes'] = $mes;
        return false;
    }

    $received_data = receive_socket_data($sock, 256);

    $data = $socket_buffer;
    $socket_buffer = '';

    $mainFields = array(
        "result_code",
        "count",
        "cntLeft"
    );

    $recurrentFields = array(
        "picPath",
        "picID",
        "userPgLnk",
        "fullName",
        "uname",
        "ucity",
        "ucountry",
        "bioDesc",
    );

    $dataArray = parseDataFields($data, $mainFields, $recurrentFields);

    if (isset($dataArray["result_code"]) && $dataArray["result_code"] == 1) {
        socket_close($sock);
        return $dataArray;
    } else {
        if ($dataArray["result_code"] == 2000) {
            socket_close($sock);
            $_SESSION['mes'] = "Search string not found";
            return false;
        }

        socket_close($sock);
        $mes = getSocketErrorMsg($cmd, $data);
        $_SESSION['mes'] = $mes;
        return false;
    }
}

//Set User Data ----------------------------------------------------
function set_user_data($fields)
{
    $conn = socket_init();
    $sock = $conn[0];
    //print_r($fields);exit;
    //Generate String
    $cmd = '4';

    $uname = $fields['uname'];
    $userPwd = $fields['userPwd'];
    $fullName = $fields['fullName'];
    $city = $fields['city'];
    $state = $fields['state'];
    $country = $fields['country'];
    $email = $fields['email'];
    $webPg = $fields['webPg'];
    $bioDesc = $fields['bioDesc'];
    $nwUpswd = $fields['nwUpswd'];
    $timeZone = $fields['timeZone'] + 12;
    $minZone = 0;
    $pic = $fields['pic'];
    $picFile = $fields['picFile'];
    $protect = $fields['protect'];
    //print_r($fields);exit;

    if (filesize($fields['pic_file']) < IMAGES_SIZE) {
        $file_text = $cmd . "\0" . $uname . "\0" . $userPwd . "\0" . $fullName . "\0" . $city . "\0" . $state . "\0" . $country . "\0" . $email . "\0";
        $file_text .= $webPg . "\0" . $bioDesc . "\0" . $nwUpswd . "\0" . $timeZone . "\0" . $minZone . "\0" . $pic . "\0" . $picFile . "\0" . $protect . "\4";

        $file_text = pack('A*', $file_text);

        $send = socket_send($sock, $file_text, strlen($file_text), 0);
        //print_r($send);exit;

        if (!$send) {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, '10054');
            $_SESSION['mes'] = $mes;
        }

        $receive = socket_recv($sock, $after_post_receive, 3, MSG_WAITALL);
        $after_post_receive_code = substr($after_post_receive, 0, 1);

        if ($after_post_receive_code == '1') {

            if ($pic == '1' && $fields['pic_file'] != '') {

                $pic_file = $fields['pic_file'];
                $sendPicSz = filesize($pic_file);
                $sendFileSz = $sendPicSz . "\4";
                $file_sz_text = pack('A*', $sendFileSz);
                $newpost_file_sz = $file_sz_text;

                $send = socket_send($sock, $newpost_file_sz, strlen($newpost_file_sz), 0);

                if (!$send) {
                    socket_close($sock);
                    $mes = getSocketErrorMsg($cmd, '10054');
                    $_SESSION['mes'] = $mes;

                    return false;
                }

                $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                $responseCode = substr($finalpost_file_receive, 0, 1);
                if ($responseCode == '1') {//ALL OK
                    $sz = 256;
                    $pic_file = $fields['pic_file'];
                    $fp = fopen($fields['pic_file'], 'rb', FILE_USE_INCLUDE_PATH);

                    $sentBytes = 0;
                    while (!feof($fp)) {
                        $pic_file = fread($fp, $sz);
                        $actualBytes = mb_strlen($pic_file, '8bit');
                        $send = socket_send($sock, $pic_file, $actualBytes, 0);

                        if (!$send) {
                            $errorcode = socket_last_error();
                            $errormsg = socket_strerror($errorcode);
                            socket_clear_error();
                            socket_close($sock);
                            fclose($fp);
                            $mes = getSocketErrorMsg($cmd, '10054');
                            $_SESSION['mes'] = $mes;
                            return false;
                        }
                        $sentBytes += $actualBytes;
                    }
                    fclose($fp);

                    $receive = socket_recv($sock, $finalpost_file_receive, 3, MSG_WAITALL);

                    $responseCode = substr($finalpost_file_receive, 0, 1);
                    if ($responseCode == '1' || strpos($finalpost_file_receive, "OK") > 0) {//ALL OK
                        socket_close($sock);
                        return true;
                    } else {
                        socket_close($sock);
                        $mes = getSocketErrorMsg($cmd, $finalpost_file_receive);
                        $_SESSION['mes'] = $mes;
                        return false;
                    }
                } else {
                    socket_close($sock);
                    return true;
                }
            } else {
                socket_close($sock);
                return true;
            }
        } else if ($after_post_receive_code == '2') {
            socket_recv($sock, $passwordNotUpdated, 1024, 0);
            $mes = getSocketErrorMsg($cmd, $after_post_receive);
            $_SESSION['mes'] = $mes;
            socket_close($sock);
            return false;
        } else if ($after_post_receive_code == '3') {
            socket_recv($sock, $userBlocked, 1024, 0);
            $mes = getSocketErrorMsg($cmd, $after_post_receive);
            $_SESSION['mes'] = $mes;
            socket_close($sock);
            return false;
        } else {
            socket_close($sock);
            $mes = getSocketErrorMsg($cmd, $after_post_receive);
            $_SESSION['mes'] = $mes;
            return false;
        }
    } else {
        socket_close($sock);
        $mes = "Image size must be less then 700kb.";
        $_SESSION['mes'] = $mes;
        return false;
    }
}
