<?php

//this outputs an HTML comment with the timestamp to measure responses
function echoTimestampTag($spotName = "log")
{
    echo "<!-- $spotName | " . date('Y-m-d H:i:s') . " -->";
}

function validateEmail($xmail)
{ //Todas las expresiones deben comenzar con / y terminar con /, en caso de querer encontrar / hay que escapearla \/
    $result = false;
    $regexpmail = "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/";
    if (strlen($xmail) > 0) {
        if (!preg_match_all($regexpmail, $xmail, $arrayResults)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}

function sendEmail($destination, $content, $subject, $from)
{
    $body = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<style type='text/css'>
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #0099CC;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width='100%'  border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center' valign='top'><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
      
      <tr>
        <td><p>&nbsp;</p>
          <p>&nbsp;</p>
			<p align='left'>$content</p>
            <p align='right'>&nbsp;</p>
          </blockquote></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</body>
</html>";

    $message[1]['content_type'] = 'text/html; charset=iso-8859-1';
    $message[1]['filename'] = '';
    $message[1]['no_base64'] = TRUE;
    $message[1]['data'] = stripslashes($body);
    $message[1]['headers'] = array('X-Sent-By' => 'contact@bryxe.com', 'X-mailer' => 'mailer');

    $out = mp_new_message($message);
    return mail($destination, stripslashes($subject), $out[0], $from . $out[1]);
}

function mp_read_file($filename)
{
    $buf = '';
    $fd = fopen($filename, 'r');
    if ($fd) {
        while (!feof($fd)) {
            $buf .= fread($fd, 256);
        }
        fclose($fd);
    }
    if (strlen($buf))
        return $buf;
}

function mp_new_message(&$message_array)
{
    $boundary = mp_new_boundary();
    $buf = "";
    while (list(, $chunk) = each($message_array)) {
        $mess = TRUE;
        unset($headers);
        unset($data);
        if (!$chunk['no_base64']) {
            $headers['Content-ID'] = mp_new_message_id();
            $headers['Content-Transfer-Encoding'] = 'BASE64';
            if (strlen($chunk['filename'])) {
                $headers['Content-Type'] = $chunk['content_type'] . '; name="' . $chunk['filename'] . '"';
                $headers['Content-Description'] = '';
                $headers['Content-Disposition'] = 'attachment; filename="' . $chunk['filename'] . '"';
            } else {
                $headers['Content-Type'] = $chunk['content_type'];
            }
            $data = chunk_split(base64_encode($chunk['data']), 60, "\n");
        } else {
            $headers['Content-Type'] = $chunk['content_type'];
            $data = $chunk['data'] . "\n";
        }

        if (is_array($chunk['headers']) && count($chunk['headers'])) {
            while (list($key, $val) = each($chunk['headers'])) {
                $headers[$key] = $val;
            }
        }

        $buf .= '--' . $boundary . "\n";
        while (list($key, $val) = each($headers)) {
            $buf .= $key . ': ' . $val . "\n";
        }
        $buf .= "\n";
        $buf .= $data;
    }

    if ($mess) {
        $buf .= '--' . $boundary . '--';

        return array
        (
            0 => $buf,
            1 => 'MIME-Version: 1.0' . "\n" .
                'Content-Type: MULTIPART/MIXED;' . "\n" .
                '  BOUNDARY="' . $boundary . '"' . "\n" .
                'X-Generated-By: Lib Multipart for PHP, Version 1.0.0;' . "\n",
            2 => array('MIME-Version: 1.0',
                'Content-Type: MULTIPART/MIXED;' . "\n"
                . '  BOUNDARY="' . $boundary . '"',
                'X-Generated-By: Lib Multipart for PHP, Version 1.0.0;' . "\n")
        );
    }
}

function mp_new_message_id()
{
    return '<' . 'lib_multipart-' . str_replace(' ', '.', microtime()) . '@' . HOSTNAME . '>';
}

function mp_new_boundary()
{
    return '-' . 'lib_multipart-' . str_replace(' ', '.', microtime());
}

function parseDataFields($data, $mainFields, $recurrentFields = null, $alternateRecurrentFieldsSplit = null)
{
    $data = substr($data, 0, -1);
    $data = str_replace($alternateRecurrentFieldsSplit, "\0", $data);
    if ($alternateRecurrentFieldsSplit != null) {
        $data = str_replace("\0\0", "\0", $data);
    }
    $parsedResponse = explode("\0", $data);
    // if(in_array('level',$recurrentFields)){
    //     print_r($parsedResponse);
    //     die();
    // }
    //$parsedResponse = explode("\0", $data);
    $dataArray = array();
    if (is_array($parsedResponse)) {

        $tempDataArray = array();
        $recurrentFieldKey = 0;
        foreach ($parsedResponse as $key => $value) {
            if (isset($mainFields[$key])) {
                $dataArray[$mainFields[$key]] = $value;
            } else {
                if (is_array($recurrentFields)) {
                    $tempDataArray[$recurrentFields[$recurrentFieldKey]] = $value;
                    $recurrentFieldKey++;
                    if (count($tempDataArray) >= count($recurrentFields)) {
                        $dataArray[] = $tempDataArray;
                        $tempDataArray = array();
                        $recurrentFieldKey = 0;
                    }
                } else {
                    $dataArray["undefined_field_" . $key] = $value;
                }
            }
        }
    }
    return $dataArray;
}

//updates the level count session vars
function updateLevelPostsCounts()
{
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['level'])) {
        $topic = $_SESSION["topic"] ? $_SESSION["topic"] : "";
        unset($_SESSION['level_post_count']);
        //$topic = "";
        //$_SESSION["topic"] = 0;
        //echo "AQUI! ".$_SESSION['level'];
        $startLev = 0;
        $levelCnt = 10;
        $result = get_level_count($_SESSION['username'], $_SESSION['password'], $topic, $startLev, $levelCnt);

        $resultant = [];
        for ($i = 0; $i < $result['count']; $i++) {
            $resultant[$result[$i]['currentLevelOwnerId']][$result[$i]['currentLevel']] = $result[$i];
        }

        
        $_SESSION['level_post_count'] = $resultant;
        //['total_unread'] = "0";
        // $unreadPosts = countUnreadPosts($_SESSION['level'], $_SESSION['level_post_count']);
        // if ($unreadPosts > 0) {
        //     if ($unreadPosts > 99) {
        //         $_SESSION['level_post_count']['total_unread'] = "+99";
        //     } else {
        //         $_SESSION['level_post_count']['total_unread'] = $unreadPosts;
        //     }
        // }
    }
}

//returns an array of results
function parseRouting(&$queryString)
{
    $uri = $_SERVER['REQUEST_URI'];

    $uriArray = explode('/', trim($uri, '/'));

    //cleanup route array to avoid subfolder
    $elemPos = array_search(SITE_NAME, $uriArray);
    if ($elemPos !== false) {
        unset($uriArray[$elemPos]);
        $uriArray = array_values($uriArray);
    }

    $pageName = (isset($uriArray[0]) && $uriArray[0] != '') ? $uriArray[0] : 'index';

    //if uri contains get params, remove before proceed
    if (strpos($pageName, "?") > 0) {
        $pageName = substr($pageName, 0, strpos($pageName, "?"));
    }

    array_shift($uriArray);
    if (!is_array($queryString)) {
        $queryString = array();
    }
    $queryString = $uriArray;
    return $pageName;
}

function redirect($url)
{
    if ($url != '') {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}

function frontDecode($str, $hash = 'efbfbd')
{
    $newStr = pack('H*', str_replace($hash, '', bin2hex(trim($str))));
    return $newStr;
}

function deleteOldImages()
{
    foreach (glob('./downloads/*.*') as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }

    foreach (glob('./downloads/thumb/*.*') as $filet) {
        if (is_file($filet)) {
            @unlink($filet);
        }
    }
}

function countUnreadPosts($currentLevel, $arrayLevelCount)
{
    $unread = 0;
    $levelNum = 0;
    if (is_array($arrayLevelCount)) {
        foreach ($arrayLevelCount as $levelCount) {
            if (isset($levelCount["levelNw"])) {
                if ($levelNum != ((int)$currentLevel)) {
                    $unread += ((int)$levelCount["levelNw"]);
                }
                $levelNum++;
            }
        }
    }
    return $unread;
}
