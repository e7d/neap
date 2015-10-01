<?php
    class MediaInfo
    {
        public static function fetchChannel($channel, $type = "all")
        {
            return json_decode(MediaInfo::syscall('ffprobe -v quiet -print_format json -show_format -show_streams rtmp://localhost/live/' .$channel), TRUE);
        }

        public static function fetchVideo($video, $type = "all")
        {
            return json_decode(MediaInfo::syscall('ffprobe -v quiet -print_format json -show_format -show_streams ' .$video), TRUE);
        }

        private static function syscall($cmd)
        {
            if ($proc = popen("($cmd)2>&1", "r")){
                while (!feof($proc)) $result .= fgets($proc, 1000);
                pclose($proc);
                return $result;
            }
        }
    }
