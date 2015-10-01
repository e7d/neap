<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function __autoload($class)
    {
        include 'lib/' . $class . '.class.php';
    }

    if (isset($_GET["download"])) {
        $file = "/var/tmp/rec/".$_GET["download"];
        if (file_exists($file)) {
            $size = filesize("./" . basename($file));
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " .$size);
            header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
            header("Expires: 0");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            readfile($file);
            exit();
        }
    }

    // Load RTMP channels informations
    RTMP::checkStreams();

    // Store if playback device is mobile: HTML5 mode
    $html5 = (preg_match('/android|ip(hone|od|ad)/i', $_SERVER['HTTP_USER_AGENT'])) ? "true" : "false";

    // Check if there is a channel to display
    $channel = false;
    if (isset($_GET["channel"]))
    {
        $channel = $_GET["channel"];
    }

    // Check if there is a video to display
    $video = false;
    if (isset($_GET["video"]))
    {
        $video = $_GET["video"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Streaming</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body>
<?php
    if ($channel !== false) {
        if (count(array_keys($_SESSION["rtmp"]["channels"])) > 1 )
        {
?>
    <select class="channel">
<?php
        foreach(array_keys($_SESSION["rtmp"]["channels"]) as $channelName)
        {
            echo "\t\t";
            echo '<option value="' .$channelName. '"';
            if ($channelName === $_GET["channel"])
            {
                echo ' selected';
            }
            echo '>' .$channelName. '</option>';
        }
?>
    </select>
<?php
        }
?>
    <div class="cover offline"></div>
    <label class="status live"><i class="circle"></i> LIVE</label>
    <label class="status offline">OFFLINE</label>

    <video id="player" autoplay="true" controls="controls" preload="auto" poster="img/channel_<?php echo $channel; ?>.jpg" width="100%" height="100%">
        <source type="application/x-mpegurl" src="hls/<?php echo $channel; ?>.m3u8" />
        <source type="rtmp/flv" src="live/<?php echo $channel; ?>">
    </video>

    <script>var settings = {player: true, channel: "<?php echo $channel; ?>", html5: <?php echo $html5; ?>};</script>
<?php
    } elseif ($video !== false) {
?>
    <video id="player" autoplay="true" controls="controls" preload="auto" poster="img/video_<?php echo str_replace(".mp4", ".jpg", $video); ?>" width="100%" height="100%">
        <source type="video/mp4" src="rec/<?php echo $video; ?>">
    </video>

    <script>var settings = {player: true, video: "<?php echo $video; ?>", html5: <?php echo $html5; ?>};</script>
<?php
    } else {
?>
    <div id="wrap">
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><i class="fa fa-youtube-play"></i> Media Streaming</a>
                </div>

                <div id="navbar-collapse-menu" class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li<?php if(!isset($_GET["videos"])) { echo ' class="active"'; } ?>><a href="/?channels">Channels</a></li>
                        <li<?php if(isset($_GET["videos"])) { echo ' class="active"'; } ?>><a href="/?videos">Videos</a></li>
                        <li><a href="#settings" data-toggle="modal" data-target="#modal-settings"><i class="fa fa-cog"></i> Settings</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
<?php
        if (isset($_GET["videos"])) {
?>
        <div class="jumbotron">
            <div class="container">
                <h1><i class="fa fa-film"></i> Recorded Videos</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="btn-group">
                        <a href="#" class="display-grid btn btn-default"><span class="fa fa-th-large"></span> Grid</a>
                        <a href="#" class="display-list btn btn-default"><span class="fa fa-th-list"></span> List</a>
                    </div>
                </div>
            </div>
            <br>
<?php
            $videos = glob("/var/tmp/rec/*.mp4");
            if (count($videos) > 0) {
                foreach ($videos as $key => $video) {
                    $file = substr($video, strrpos($video, "/") + 1);
                    $channel = substr($file, 0, strrpos($file, "-"));
                    $timestamp = substr($file, strrpos($file, "-") + 1, -4);
                    $datetime = date("Y-m-d H:i:s", $timestamp);
                    $screenshot = 'img/video_' .str_replace('mp4', 'jpg', $file);
                    if (!file_exists($screenshot)) {
                        $screenshot = 'img/no-preview.jpg';
                    }

                    $mediainfo = array();
                    try {
                        $mediainfo = MediaInfo::fetchVideo($video);
                        // eval FPS to get rid of fractions:
                        // - 30/1 becomes 30
                        // - 2997/100 becomes 29.97
                        eval('$mediainfo["streams"][0]["r_frame_rate"] = ' .$mediainfo["streams"][0]["r_frame_rate"]. ';');
                    } catch (Exception $e) {
                        print 'Cauth Exception with message '.$e->getMessage();
                    }

                    $videos[$key] = array(
                        "file" => $file,
                        "screenshot" => $screenshot,
                        "channel" => $channel,
                        "timestamp" => $timestamp,
                        "datetime" => $datetime,
                        "mediainfo" => $mediainfo
                    );
                }
?>
            <div class="row grid">
<?php

                foreach ($videos as $key => $video) {
                    $col = 'col-md-6';
                    if (count($videos) === 1) {
                        $col .= ' col-md-offset-3';
                    }

                    echo '<div class="' .$col. '">' . "\r\n";
                    echo '    <div class="thumbnail">' . "\r\n";
                    echo '        <a href="?video=' .$video["file"]. '">' . "\r\n";
                    echo '            <label class="status live"><i class="fa fa-clock-o"></i> <span data-duration="' .$video["mediainfo"]["format"]["duration"]. '"></span></label>' . "\r\n";
                    echo '            <img class="img-responsive" src="' .$video["screenshot"]. '" alt="' .$video["file"]. '">' . "\r\n";
                    echo '        </a>' . "\r\n";
                    echo '        <div class="caption">' . "\r\n";
                    echo '            <h3><a href="?video=' .$video["file"]. '">' .$video["file"]. '</a></h3>' . "\r\n";
                    echo '        </div>' . "\r\n";
                    echo '    </div>' . "\r\n";
                    echo '</div>' . "\r\n";
                }
?>
            </div>
            <div class="row list">
                <table class="table videos">
                    <thead>
                        <tr>
                            <th>Channel</th>
                            <th>Date</th>
                            <th class="hidden-xs">Duration</th>
                            <th class="hidden-xs">Definition</th>
                            <th class="hidden-xs">Size</th>
                            <th class="text-center" style="width:100px">Download</i></th>
                            <th class="text-center" style="width:100px">Play</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                foreach ($videos as $video) {
                    $seed = uniqid();

                    echo '<tr>' . "\r\n";
                    echo '    <td>' .$video["channel"]. '</td>' . "\r\n";
                    echo '    <td><span data-timestamp="' .$video["timestamp"]. '000"></span></td>' . "\r\n";
                    echo '    <td class="hidden-xs"><span data-duration="' .$video["mediainfo"]["format"]["duration"]. '"></span></td>' . "\r\n";
                    echo '    <td class="hidden-xs">' . "\r\n";
                    echo '        <em data-toggle="popover" data-seed="' .$seed. '" data-trigger="hover" data-placement="top" data-title="Meta Data">' .$video["mediainfo"]["streams"][0]["height"]. 'p@' .$video["mediainfo"]["streams"][0]["r_frame_rate"]. 'fps</em>' . "\r\n";
                    echo '    </td>' . "\r\n";
                    echo '    <td class="hidden-xs"><span data-size="' .$video["mediainfo"]["format"]["size"]. '"></span>B</td>' . "\r\n";
                    echo '    <td class="text-center"><a href="?download=' .$video["file"]. '" class="btn btn-success"><i class="fa fa-download"></i></a></td>' . "\r\n";
                    echo '    <td class="text-center"><a href="?video=' .$video["file"]. '" class="btn btn-primary"><i class="fa fa-play"></i></a></td>' . "\r\n";
                    echo '</tr>';

                    echo '<div id="popover-' .$seed. '" class="hidden">';
                    echo '    <h4>Video</h4>' . "\r\n";
                    echo '    <ul>' . "\r\n";
                    echo '        <li>Codec: ' .$video["mediainfo"]["streams"][0]["codec_name"]. ' ' .$video["mediainfo"]["streams"][0]["profile"]. '</li>' . "\r\n";
                    echo '        <li>Bitrate: <span data-size="' .$video["mediainfo"]["streams"][0]["bit_rate"]. '"></span>b/s</li>' . "\r\n";
                    echo '        <li>Definition: ' .$video["mediainfo"]["streams"][0]["width"]. '*' .$video["mediainfo"]["streams"][0]["height"]. '</li>' . "\r\n";
                    echo '        <li>Framerate: ' .$video["mediainfo"]["streams"][0]["r_frame_rate"]. ' fps</li>' . "\r\n";
                    echo '    </ul>' . "\r\n";
                    echo '    <h4>Audio</h4>' . "\r\n";
                    echo '    <ul>' . "\r\n";
                    echo '        <li>Codec: ' .$video["mediainfo"]["streams"][1]["codec_name"]. '</li>' . "\r\n";
                    echo '        <li>Bitrate: <span data-size="' .$video["mediainfo"]["streams"][1]["bit_rate"]. '"></span>b/s</li>' . "\r\n";
                    echo '        <li>Sample Rate: ' .$video["mediainfo"]["streams"][1]["sample_rate"]. ' Hz</li>' . "\r\n";
                    echo '        <li>Channels: ' .$video["mediainfo"]["streams"][1]["channels"]. '</li>' . "\r\n";
                    echo '    </ul>' . "\r\n";
                    echo '</div>' . "\r\n";
                }
?>
                    </tbody>
                </table>
            </div>
<?php
            } else {
?>
                <div class="col-md-12">
                    <p class="text-center">No video available.</p>
                    <br>
                    <p class="text-center"><a class="btn btn-lg btn-primary" href="/?videos"><i class="fa fa-refresh"></i> Refresh</a></p>
                </div>
<?php
            }
?>
        </div>
<?php
        } else {
?>
        <div class="jumbotron">
            <div class="container">
                <h1><i class="fa fa-video-camera"></i> Live Channels</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="btn-group">
                        <a href="#" class="display-grid btn btn-default"><span class="fa fa-th-large"></span> Grid</a>
                        <a href="#" class="display-list btn btn-default"><span class="fa fa-th-list"></span> List</a>
                    </div>
                </div>
            </div>
            <br>
<?php
            if (count($_SESSION["rtmp"]["channels"]) > 0) {
                $channels = array();
                foreach ($_SESSION["rtmp"]["channels"] as $channelName => $channel) {
                    $channels[$channelName] = $channel;
                    $channels[$channelName]["screenshot"] = 'img/channel_' .$channelName. '.jpg';
                    if (!file_exists($channels[$channelName]["screenshot"])) {
                        $channels[$channelName]["screenshot"] = 'img/no-preview.jpg';
                    }

                    $mediainfo = array();
                    try {
                        // Deactivated for now: too slow to fetch RTMP channel...
                        // $mediainfo = MediaInfo::fetchChannel($channelName);
                    } catch (Exception $e) {
                        print 'Cauth Exception with message '.$e->getMessage();
                    }
                    $channels[$channelName]["mediainfo"] = $mediainfo;
                }
?>
            <div class="row grid">
<?php

                foreach ($channels as $channelName => $channel) {
                    $col = 'col-md-6';
                    if (count($_SESSION["rtmp"]["channels"]) === 1) {
                        $col .= ' col-md-offset-3';
                    }

                    echo '<div class="' .$col. '">' . "\r\n";
                    echo '    <div class="thumbnail">' . "\r\n";
                    echo '        <a href="?channel=' .$channelName. '">' . "\r\n";
                    echo '            <label class="status live"><i class="circle"></i> LIVE</label>' . "\r\n";
                    echo '            <img class="img-responsive" src="' .$channel["screenshot"]. '" alt="' .$channelName. '">' . "\r\n";
                    echo '        </a>' . "\r\n";
                    echo '        <div class="caption">' . "\r\n";
                    echo '            <h3><a href="?channel=' .$channelName. '">' .$channelName. '</a></h3>' . "\r\n";
                    echo '        </div>' . "\r\n";
                    echo '    </div>' . "\r\n";
                    echo '</div>' . "\r\n";
                }
?>
            </div>
            <div class="row list">
                <table class="table channels">
                    <thead>
                        <tr>
                            <th>Channel</th>
                            <th>Duration</th>
                            <th class="hidden-xs">Definition</th>
                            <th class="text-center" style="width:100px">Record</i></th>
                            <th class="text-center" style="width:100px">Watch</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                foreach ($channels as $channelName => $channel) {
                    $seed = uniqid();

                    echo '<tr>' . "\r\n";
                    echo '    <td><a href="?channel=' .$channelName. '">' .$channelName. '</a></td>' . "\r\n";
                    echo '    <td>' .gmdate("H:i:s", ($channel["time"]/1000)). '</td>' . "\r\n";
                    echo '    <td class="hidden-xs">' . "\r\n";
                    echo '        <em data-toggle="popover" data-seed="' .$seed. '" data-trigger="hover" data-placement="top" data-title="Meta Data">' .$channel["meta"]["video"]["height"]. 'p@' .$channel["meta"]["video"]["frame_rate"]. 'fps</em>' . "\r\n";
                    echo '    </td>' . "\r\n";
                    echo '    <td class="text-center"><a class="btn btn-record btn-danger" data-channel="' .$channelName. '"><i class="fa fa-circle"></i><i class="fa fa-stop"></i></a></td>' . "\r\n";
                    echo '    <td class="text-center"><a class="btn btn-play btn-primary" href="?channel=' .$channelName. '"><i class="fa fa-play"></i></a></td>' . "\r\n";
                    echo '</tr>' . "\r\n";

                    echo '<div id="popover-' .$seed. '" class="hidden">';
                    echo '    <h4>Video</h4>';
                    echo '    <ul>';
                    echo '        <li>Codec: ' .$channel["meta"]["video"]["codec"]. ' ' .$channel["meta"]["video"]["profile"]. '</li>';
                    echo '        <li>Bitrate: <span data-size="' .$channel["bw_video"]. '"></span>b/s</li>';
                    echo '        <li>Definition: ' .$channel["meta"]["video"]["width"]. '*' .$channel["meta"]["video"]["height"]. '</li>';
                    echo '        <li>Framerate: ' .$channel["meta"]["video"]["frame_rate"]. ' fps</li>';
                    echo '    </ul>';
                    echo '    <h4>Audio</h4>';
                    echo '    <ul>';
                    echo '        <li>Codec: ' .$channel["meta"]["audio"]["codec"]. ' ' .$channel["meta"]["audio"]["profile"]. '</li>';
                    echo '        <li>Bitrate: <span data-size="' .$channel["bw_audio"]. '"></span>b/s</li>';
                    echo '        <li>Sample Rate: ' .$channel["meta"]["audio"]["sample_rate"]. ' Hz</li>';
                    echo '        <li>Channels: ' .$channel["meta"]["audio"]["channels"]. '</li>';
                    echo '    </ul>';
                    echo '</div>' . "\r\n";
                }
?>
                    </tbody>
                </table>
            </div>
<?php
            } else {
?>
            <div class="col-md-12">
                <p class="text-center">No channel available.</p>
                <br>
                <p class="text-center"><a class="btn btn-lg btn-primary" href="/?channels"><i class="fa fa-refresh"></i> Refresh</a></p>
            </div>
<?php
            }
?>
        </div>
<?php
        }
?>

        <div class="modal fade" id="modal-settings" role="dialog" aria-labelledby="modal-settings-label">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal-settings-label"><i class="fa fa-cog"></i> Settings</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="form-settings" role="form">
                            <div class="form-group">
                                <label for="modal-settings-player" class="col-sm-2 control-label">Player</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="form-settings-player" id="modal-settings-player">
                                        <option value="videojs">Video.js</option>
                                        <option value="html5">HTML5</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-settings-cancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="modal-settings-save" data-dismiss="modal"><i class="fa fa-floppy-disk"></i> Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /.wrap -->

    <footer>
        &copy; 2015 - <a href="https://media-streaming.e7d.io" target="_blank">e7d</a>
    </footer>

    <script>var settings = {player: false}</script>
<?php
    }
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
