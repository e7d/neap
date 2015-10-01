<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    class RTMP
    {
        public static function checkStreams($forceCheck = true)
        {
            if ( !isset($_SESSION["rtmp"]) )
            {
                $_SESSION["rtmp"] = array
                (
                    "lastUpdate" => 0,
                    "channels" => array()
                );
            }

            if ( $forceCheck || time() - $_SESSION["rtmp"]["lastUpdate"] > 5 )
            {
                RTMP::fetchChannels();
            }
        }

        private static function fetchChannels()
        {
            $_SESSION["rtmp"]["lastUpdate"] = time();
            $_SESSION["rtmp"]["channels"] = array();

            $rtmp = json_decode(json_encode((array) simplexml_load_file("http://localhost/stat.xml")), TRUE);

            if (array_key_exists("name", $rtmp["server"]["application"][1]["live"]["stream"]))
            {
                $channel = $rtmp["server"]["application"][1]["live"]["stream"];

                if (empty($channel["name"])) { $channel["name"] = "default"; }
                $_SESSION["rtmp"]["channels"][$channel["name"]] = $channel;
                $_SESSION["rtmp"]["channels"][$channel["name"]]["recording"] = RTMP::isRecordingChannel($channel["name"]);
            }
            else
            {
                foreach ($rtmp["server"]["application"][1]["live"]["stream"] as $key => $channel)
                {
                    if (empty($channel["name"])) { $channel["name"] = "default"; }
                    $_SESSION["rtmp"]["channels"][$channel["name"]] = $channel;
                    $_SESSION["rtmp"]["channels"][$channel["name"]]["recording"] = RTMP::isRecordingChannel($channel["name"]);
                }
            }
        }

        private static function isRecordingChannel($channelName)
        {
            return (count(glob("/var/tmp/rec/" .$channelName. "*.flv")) > 0);
        }
    }
