/*!
 * Media Streaming v1.0
 * https://github.com/e7d/media-streaming
 *
 * Copyright 2015 Michael Ferrand
 * Released under the MIT license
 */

(function (window, document, settings, undefined) {
    var MediaStreaming = {
        availablePlayers: ["flowplayer", "html5", "jwplayer", "mediaelement", "videojs"],
        player: "videojs", // Default player is set here
        channels: [],
        channel: false,
        live: false,

        channelsInterval: false,
        inactivityTimeout: false,
        pingInterval: false
    }

    /* Load channel statistics */
    MediaStreaming.LoadChannels = function (enable) {
        function handler() {
            $.getJSON("api.json?action=channels", function (data) {
                MediaStreaming.channels = data.channels;
                /* Set recording buttons default status */
                for (key in MediaStreaming.channels) {
                    if (MediaStreaming.channels[key].recording) {
                        $(".btn-record[data-channel='" + MediaStreaming.channels[key].name + "']").addClass("recording");
                    }
                };
            });
        };

        if (enable) {
            channelsInterval = window.setInterval(handler, 60000);
            handler();
        } else {
            window.clearInterval(channelsInterval);
        }
    };

    /* Track mouse activity */
    MediaStreaming.TrackMouseActivity = function (enable) {
        var handler = function () {
            $("body").removeClass("mouse-inactive");
            window.clearTimeout(MediaStreaming.inactivityTimeout);
            MediaStreaming.inactivityTimeout = window.setTimeout(
                function () {
                    $("body").addClass("mouse-inactive");
                }, 5000
                );
        };

        if (enable) {
            $(window).on("mousemove", handler);
        } else {
            $("body").removeClass("mouse-inactive");
            window.clearTimeout(MediaStreaming.inactivityTimeout);
            $(window).on("mousemove", handler);
        }
    };

    /* Record channel */
    MediaStreaming.RecordChannel = function (enable, channel) {
        channel = channel || MediaStreaming.channel;

        if (enable === true || enable === "start") {
            $.getJSON("api.json?action=record&channel=" + channel + "&start", function (record) {
                console.log("Record start: " + record.file);
            });

            MediaStreaming.channels[channel].recording = true;
        }
        else if (enable === false || enable === "stop") {
            $.getJSON("api.json?action=record&channel=" + channel + "&stop", function (record) {
                console.log("Record stop: " + record.file);
            });

            MediaStreaming.channels[channel].recording = false;
        }
        else if (enable === "toggle") {
            if (!MediaStreaming.channels[channel].recording) {
                MediaStreaming.RecordChannel("start", channel);
            } else {
                MediaStreaming.RecordChannel("stop", channel);
            }
        }
    };

    /* Check channel availability */
    MediaStreaming.PingChannel = function (enable, channel) {
        channel = channel || MediaStreaming.channel;

        function handler() {
            $.getJSON("api.json?action=ping&channel=" + channel, function (ping) {
                if (ping.live) {
                    $("body").addClass("live");
                    if (!MediaStreaming.live) $(window).trigger("mousemove");
                } else {
                    $("body").removeClass("live");
                }
                MediaStreaming.live = ping.live;
            });
        };

        if (enable) {
            pingInterval = window.setInterval(handler, 5000);
            handler();
        } else {
            window.clearInterval(pingInterval);
        }
    };

    /* Build live channel player */
    MediaStreaming.BuildLivePlayer = function (player) {
        player = player || MediaStreaming.player;

        /* Set RTMP correct uri */
        $("source[type^=rtmp]").attr("src", ["rtmp://", document.location.hostname, "/", $("source[type^=rtmp]").attr("src")].join(''));

        /* Update window title */
        document.title = MediaStreaming.channel + " - " + document.title;

        /* Channel switcher */
        $("select.channel").on("change", function () {
            window.location.href = "/?channel=" + $(this).val();
        });

        /* Channel handlers */
        MediaStreaming.TrackMouseActivity(true);
        MediaStreaming.PingChannel(true);

        if ("videojs" === player) {
            // DOM preparation
            $("#player").addClass("video-js vjs-default-skin");
            $("head").append('<link rel="stylesheet" href="css/video-js.css">');
            $("body").append('<script src="js/video.js"></script>');

            // Video.js Player loading
            videojs.options.flash.swf = "js/video-js.swf"
            videojs("player", {}, function () {
                $(".vjs-duration-display").innerHTML = "Live broadcast";
            });
            $(".vjs-duration-display").html("Live broadcast");
        }
    }

    /* Build recorded video player */
    MediaStreaming.BuildVideoPlayer = function (player) {
        player = player || MediaStreaming.player;

        /* Update window title */
        document.title = MediaStreaming.video + " - " + document.title;

        if ("videojs" === player) {
            // DOM preparation
            $("#player").addClass("video-js vjs-default-skin");
            $("head").append('<link rel="stylesheet" href="css/video-js.css">');
            $("body").append('<script src="js/video.js"></script>');

            // Video.js Player loading
            videojs("player");
        }
    }

    MediaStreaming.init = function (settings) {
        /* Load channels */
        MediaStreaming.LoadChannels(true);

        /* Build popovers */
        $("[data-toggle=popover][data-seed]").popover({
            html: true,
            content: function () {
                return $("#popover-" + $(this).data("seed")).html()
            }
        });

        if (settings.player) {
            /* Prepare environment */
            $("body").addClass("player");

            /* Get Channel */
            MediaStreaming.channel = (typeof settings.channel === "undefined") ? false : settings.channel;
            MediaStreaming.video = (typeof settings.video === "undefined") ? false : settings.video;

            /* Player */
            // Check cookies
            if ("undefined" !== typeof $.cookie("player") && -1 !== $.inArray($.cookie("player"), MediaStreaming.availablePlayers)) {
                MediaStreaming.player = $.cookie("player");
            }
            // Check if player is mobile, Android or iOS, HTML5 fallback
            if (settings.html5) MediaStreaming.player = "html5";

            /* Build ! */
            if (MediaStreaming.channel) MediaStreaming.BuildLivePlayer();
            if (MediaStreaming.video) MediaStreaming.BuildVideoPlayer();
        } else {
            /* Settings handlers */
            $("select[name=form-settings-player] option").each(function (key, option) {
                if ($(option).val() === $.cookie("player")) {
                    $(option).prop("selected", true);
                }
            });
            $("form[name=form-settings]").on("submit", function () {
                $.cookie("player", $("select[name=form-settings-player]").val());

                return false;
            });
            $("#modal-settings-save").on("click", function () {
                $("form[name=form-settings]").trigger("submit");
            });

            /* Display Mode: List/Grid */
            $("a.display-grid").on("click", function () {
                $("a.display-list").removeClass("active");
                $("a.display-grid").addClass("active");

                $(".row.list").fadeOut(50, function () {
                    $(".row.grid").fadeIn();
                });

                $.cookie("display", "grid");
            });
            $("a.display-list").on("click", function () {
                $("a.display-grid").removeClass("active");
                $("a.display-list").addClass("active");

                $(".row.grid").fadeOut(50, function () {
                    $(".row.list").fadeIn();
                });

                $.cookie("display", "list");
            });
            $("a.display-grid, a.display-list").on("click", function () { return false; });
            if ($.cookie("display") == "list") {
                $("a.display-list").trigger("click");
            } else {
                $("a.display-grid").trigger("click");
            }

            /* Record channel handlers */
            $("a.btn-record").on("click", function () {
                MediaStreaming.RecordChannel("toggle", $(this).data("channel"));
                if (MediaStreaming.channels[$(this).data("channel")].recording) {
                    $(this).addClass("recording ");
                } else {
                    $(this).removeClass("recording ");
                }
            });

            /* Format specific fields */
            $("[data-duration]").each(function (key, durationElem) {
                var seconds = Math.round($(this).data("duration")),
                    minutes = 0,
                    hours = 0;

                if (seconds >= 60) { minutes = Math.round(seconds / 60); seconds %= 60; }
                if (minutes >= 60) { hours = Math.round(minutes / 60); minutes %= 60; }

                if (seconds < 10) { seconds = "0" + seconds; }
                if (minutes < 10) { minutes = "0" + minutes; }
                if (hours < 10) { hours = "0" + hours; }

                $(durationElem).html(hours + ":" + minutes + ":" + seconds);
            });
            $("[data-size]").each(function (key, sizeElem) {
                var size = $(this).data("size"),
                    power = 0;
                while (size > 1024) {
                    size /= 1024;
                    power += 1;
                }
                size = Math.round(size * 100) / 100;
                size += " ";
                switch (power) {
                    case 1: size += "K"; break;
                    case 2: size += "M"; break;
                    case 3: size += "G"; break;
                }
                $(sizeElem).html(size);
            });
            $("[data-timestamp]").each(function (key, timestampElem) {
                $(timestampElem).html(new Date($(this).data("timestamp")).toJSON().replace("T", " - ").replace(/Z|\.000/g, ""));
            });
        }
    }

    MediaStreaming.init(settings);

    window.MediaStreaming = MediaStreaming;
})(window, document, settings);
