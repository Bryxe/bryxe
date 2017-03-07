<?php

//$queryString has variables in URL
//$_SESSION holds user and password data...
if (!isset($queryString[0])) {
    echo json_encode(array(
        "response" => array(
            "result" => "error",
            "data" => array(),
            "errors" => array(
                "endpoint" => "not selected"
            )
        )));
    die();
}
if (!isset($_SESSION["username"]) || !isset($_SESSION["password"])) {
    echo json_encode(array(
        "response" => array(
            "result" => "error",
            "data" => array(),
            "errors" => array(
                "session" => "no session active"
            )
        )));
    die();
}
$apiEndpoint = $queryString[0];

/* GET TOPICS */
if ($apiEndpoint == "getTopics") {
    $topics = get_topics($_SESSION["username"], $_SESSION["password"]);
    if ($topics["result_code"] != 1) {
        echo json_encode(array(
            "response" => array(
                "result" => "error",
                "data" => array(),
                "errors" => array()
            )
        ));
        die();
    }
    unset($topics["result_code"]);
    unset($topics["count"]);
    echo json_encode(array(
        "response" => array(
            "result" => "ok",
            "data" => array("topics" => $topics),
            "errors" => array()
        )
    ));
    die();
}

/* SEARCH TOPICS */
if ($apiEndpoint == "topicsSearch") {
    $search = strip_tags(trim($_REQUEST["search"]));
    $topics = null;
    if (!empty($search)) {
        $topics = sch_member_topics($_SESSION["username"], $_SESSION["password"], $search);
    } else {
        $topics = get_member_topics($_SESSION["username"], $_SESSION["password"]);
    }
    if ($topics["result_code"] != 1) {
        echo json_encode(array(
            "response" => array(
                "result" => "error",
                "data" => array(),
                "errors" => array()
            )
        ));
        die();
    }
    unset($topics["result_code"]);
    unset($topics["count"]);
    $topicsArray = array();
    foreach ($topics as $topic) {
        $topicsArray[$topic["topic"]]["username"][] = trim($topic["username"]);
    }
    $topics = array();
    foreach ($topicsArray as $topic => $usernames) {
        $topics[] = array("topic" => $topic, "usernames" => $usernames["username"]);
    }
    echo json_encode(array(
        "response" => array(
            "result" => "ok",
            "data" => array("topics" => $topics),
            "errors" => array()
        )
    ));
    die();
}


/* ADD TOPIC */
if ($apiEndpoint == "addTopic") {
    $newTopic = $_REQUEST["newtopic"];
    if (strlen($newTopic) < 5) {
        echo json_encode(array(
            "response" => array(
                "result" => "error",
                "data" => array(),
                "errors" => array("newtopic" => "topic must be at least 5 character long")
            )
        ));
        die();
    }
    $result = add_topic($_SESSION["username"], $_SESSION["password"], $newTopic);

    if (!$result) {
        echo json_encode(array(
            "response" => array(
                "result" => "error",
                "data" => array(),
                "errors" => array()
            )
        ));
        die();
    }
    echo json_encode(array(
        "response" => array(
            "result" => "ok",
            "data" => array(),
            "errors" => array()
        )
    ));
    die();
}

/* SET TOPIC */
if ($apiEndpoint == "setTopic") {
    $topic = (int)$_REQUEST["topic"];
    $topics = get_topics($_SESSION["username"], $_SESSION["password"]);
    if ($topics["result_code"] != 1) {
        echo json_encode(array(
            "response" => array(
                "result" => "error",
                "data" => array(),
                "errors" => array()
            )
        ));
        die();
    }
    unset($topics["result_code"]);
    unset($topics["count"]);

    foreach ($topics as $tp) {
        if ((int)$tp["topic_id"] == $topic) {
            $_SESSION["topic"] = $tp["topic_id"];
            $_SESSION["topicName"] = $tp["topic"];
        }
    }
    echo json_encode(array(
        "response" => array(
            "result" => "ok",
            "data" => array(),
            "errors" => array()
        )
    ));
    die();
}