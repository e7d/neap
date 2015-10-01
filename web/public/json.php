<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function __autoload($class)
    {
        include 'lib/' . $class . '.class.php';
    }

    // Whatever, check stream information
    RTMP::checkStreams();

    // Prepare response Data
    $json = array(
        "data" => array(),
        "options" => 0
    );

    // Compute input params
    $_OPTIONS = array_merge($_GET, $_POST);

    // Execute correct action
    switch($_GET["action"])
    {
        case "ping":
            $json["data"]["live"] = array_key_exists($_GET["channel"], $_SESSION["rtmp"]["channels"]) && array_key_exists("publishing", $_SESSION["rtmp"]["channels"][$_GET["channel"]]);
            break;
        case "record":
            if (isset($_GET["start"])) {
                $json["data"]["file"] = exec('curl "http://localhost/control/record/start?app=live&name=' .$_GET["channel"]. '&rec=rec"');
            } else if (isset($_GET["stop"])) {
                $json["data"]["file"] = exec('curl "http://localhost/control/record/stop?app=live&name=' .$_GET["channel"]. '&rec=rec"');
            }
            break;
        default:
            $json["data"]["channels"] = $_SESSION["rtmp"]["channels"];
            break;
    }

    // Prettify on demand, and force object mode
    if (isset($_GET["pretty"]))
    {
        $json["options"] = $json["options"] | JSON_PRETTY_PRINT;
    }
    $json["options"] = $json["options"] | JSON_FORCE_OBJECT;

    // Output response as JSON, without any kind of cache allowed
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    header('Content-type: text/json');
    print json_encode($json["data"], $json["options"]);
