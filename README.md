Media Streaming
=====

A ready to go nginx RTMP streaming server.

**NOTE:** The legacy branch reflects the old version 1.0.0 of media-streaming and will **NOT** be actively upgraded.

How-To
-----

1. Install [VirtualBox](http://www.virtualbox.org/)

1. Install [Vagrant](http://www.vagrantup.com/)

1. From a console, launch the `vagrant up` command

1. The streaming box is now available at the IP displayed at the end of the setup

Compatible virtualization environments
-----

| Software                  | Website                             |
|---------------------------|-------------------------------------|
| VirtualBox                | https://www.virtualbox.org/         |

Compatible streaming softwares
-----

| Software                  | Website                             |
|---------------------------|-------------------------------------|
| FFSplit                   | http://www.ffsplit.com/             |
| Open Broadcaster Software | https://obsproject.com/             |
| Telestream Wirecast       | http://www.telestream.net/wirecast/ |
| XSplit Broadcaster        | https://www.xsplit.com/broadcaster  |
| XSplit Gamecaster         | https://www.xsplit.com/gamecaster   |

Advanced Customization
-----

All the sources provided in this project are eligible to free modifications. Please find below a list of the different elements you are able to modify following your needs.

Web & RTMP server
-----

The nginx web server is powering the whole project. Its setup is built around a combination of configuration files:
```
/etc/nginx/nginx.conf                   # nginx main configuration file
/etc/nginx/conf.d/http.conf             # Web server configuration file
/etc/nginx/sites-available/default      # Web interface configuration file
/etc/nginx/conf.d/rtmp.conf             # RTMP server configuration file
/etc/nginx/conf.d/rtmp_transcode.sh     # Executable file handling incoming streams
/etc/nginx/conf.d/rtmp_screenshot.sh    # Executable file triggering the regular screenshot capture of running streams
/etc/nginx/conf.d/rtmp_convert.sh       # Executable file converting a stopped record to MP4 format
```

Web interface
-----

The web interface is a made from scratch, built around common technologies like jQuery, Bootstrap and different media players (MediaElement, JW Player, Flowplayer, Video.js) in their free versions when applicable. Based on PHP5, you can find the different files in the following folder:

```
/var/www/html              # Web interface main folder
/var/www/html/css          # Stylesheets folder
/var/www/html/js           # Javascripts folder
/var/www/html/img          # Generated thumbnails folder
/var/www/html/lib          # PHP libraries folder
/var/www/html/index.php    # Web interface main file, generating the pages
/var/www/html/json.php     # Web interface secondary file, handling the JSON API
```
You may find other files non-referenced here. These are framework files you should not need to edit.
