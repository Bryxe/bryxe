<?php
echo "trying to add a test post... \r\n<b />";

//Convert String to Hexadecimal ----------------------------------------------------
function strToHex($string)
{
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

$addr = gethostbyname("www.acupic.com");
$client = stream_socket_client("tcp://$addr:53153", $errno, $errorMessage);
if ($client === false) {
    echo "Error: " . $errorMessage;
} else {
    $dataFields = array(
        "command" => '07000000',
        "username" => 'test10',
        "password" => 'test11',
        "title" => 'sample title',
        "post" => 'sample text post',
        "time" => date("H:i:s"),
        "picFl" => '01000000',
        "picName" => 'test.jpg',
        "fileName" => '',
        "fileSize" => '3f000000',
        "email" => '',
        "protect" => '00000000'


    );

    //Generate String
    $command = $dataFields["command"];

    $user = strToHex($dataFields["username"]);
    $uname = str_pad($user, 36, '0');

    $pass = strToHex($dataFields["password"]);
    $password = str_pad($pass, 36, '0');

    $fposted_text = strToHex($dataFields["post"]);
    $posted_text = str_pad($fposted_text, 404, '0');

    $ftitle = strToHex($dataFields["title"]);
    $title = str_pad($ftitle, 84, '0');

    $fpostTime = strToHex($dataFields["time"]);
    $postTime = str_pad($fpostTime, 20, '0');

    $fpicFl = strToHex($dataFields["picFl"]);
    $picFl = $dataFields["picFl"];

    $femail = strToHex($dataFields["email"]);
    $email = str_pad($femail, 84, '0');

    $fpicName = strToHex($dataFields["picName"]);    //mb_convert_encoding("test.jpg", 'UTF-16');
    $picName = str_pad($fpicName, 84, '0');


    $ffileName = strToHex($dataFields["fileName"]);
    $filename = str_pad($ffileName, 84, '0');

    $fileSize = $dataFields["fileSize"];

    $protect = $dataFields["protect"];

    $sendData = pack('H*', $command . $uname . $password . $posted_text . $title . $postTime . $picFl . $email . $picName . $filename . $fileSize . $protect);
    fwrite($client, $sendData);
    echo "result: " . stream_get_contents($client);
    fclose($client);
}
fclose($client);
?>
</body>
</HTML>