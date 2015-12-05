# Neap

[![Build Status](https://travis-ci.org/e7d/neap.svg)](https://travis-ci.org/e7d/neap)

A ready to go nginx RTMP streaming server.

## About

**Version:** 0.0.0

**Web:** Coming later, [neap.io](http://neap.io)

**Project Owner:** Michaël "[e7d](https://github.com/e7d)" Ferrand

## Prerequisites

In order to run the code of Neap effectively, you'll need to have a few tools installed:
1. Install [Git](https://git-scm.com)
1. Install [VirtualBox](http://virtualbox.org)
1. Install [Vagrant](http://vagrantup.com)

### Windows-specific ###

1. Add the Git executables to your path
1. Install [Vagrant::WinNFSd](https://github.com/winnfsd/vagrant-winnfsd), to use NFS on a Windows host  
`vagrant plugin install vagrant-winnfsd`

### Recommended

1. Use a development workstation with at least 2 cores and 8GB of RAM, as Vagrant should be allocated 1GB of RAM
1. Install [Vagrant::Hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater), to keep your hosts file in line with the built VM  
`vagrant plugin install vagrant-hostsupdater`
1. Install [Vagrant::VBGuest](https://github.com/dotless-de/vagrant-vbguest), to manage the host's VirtualBox Guest Additions on the guest system  
`vagrant plugin install vagrant-vbguest`

## Installation ##

1. `git clone https://github.com/e7d/neap.git` to clone the latest version
1. Change into the directory `neap`
1. Run `vagrant up`

## Update ##

For an "*In-Place*" upgrade of a working environment:

1. `git pull` to get the latest version of the code
1. Change into the directory `neap`
1. Run `vagrant reload`
1. Run `vagrant provision`

For a complete update from scratch, destroying and rebuilding everything:

1. `git pull` to get the latest version of the code
1. Change into the directory `neap`
1. Run `vagrant destroy`
1. Run `vagrant up`

## What you get ##

### Software stack ###

Neap uses a mixture of Vagrant's [shell provisioner](https://docs.vagrantup.com/v2/provisioning/shell.html) to kick things off and sill soon then use a tool called [Ansible](http://docs.ansible.com) to complete the configuration of the system.

Once Vagrant is done provisioning the VM, you will have a box running Debian 8 (aka Jessie) containing:

* [Nginx](http://nginx.com/), as web server, with:
  * [Nginx RTMP module](https://github.com/arut/nginx-rtmp-module), as streaming server (RTMP, HLS and DASH protocols)
  * [PHP 7.0](http://php.net/), as web scripting language, with:
    * [PHP-FPM](http://php-fpm.org/), as PHP process manager
* [PostgreSQL](http://www.postgresql.org/), as database
* [UnrealIRCd](https://www.unrealircd.org/), as IRC server daemon, with:
  * [Anope](https://www.anope.org/), as IRC services
* Soon: [Let's Encrypt](https://letsencrypt.org/), as SSL certificate generator
* Soon: [Varnish](http://varnish-cache.org/), as static files cache
* Soon: [Memcached](http://memcached.org/), as memory object cache

### Next Steps ###

Once the VM is done provisioning, direct your browser to http://neap.dev You will receive fuller instructions on the use of this Vagrant environment there.

These URLs also provide you some control over the project:
* [neap.dev](http://neap.dev) -- General documentation and links for all of the tools
* [api.neap.dev](http//api.neap.dev) -- API interface
* [doc.neap.dev](http//doc.neap.dev) -- API documentation interface
* [swagger.neap.dev](http://swagger.neap.dev) -- Swagger documentation interface
* [db.neap.dev](http://db.neap.dev) -- Database administration interface
* [irc.neap.dev](http://irc.neap.dev) -- IRC server
* Soon: [static.neap.dev](http://static.neap.dev) -- Cache content access
* Soon: [cache.neap.dev](http://cache.neap.dev) -- Cache performance test

## Development and debugging ##

### On-disk sources ###

Neap utilizes Vagrant's [synced folders](http://docs.vagrantup.com/v2/synced-folders/index.html) to create a shared folder, that is accessible from both the Neap virtual machine and your operating system.  
This directory will be available for use after the first time the virtual machine is started using the `vagrant up` command. You can access it directly by going to the neap sources directory in the Finder or Explorer of your operating system.

### SSH ###

To connect to the Vagrant instance, type `vagrant ssh` from a console located in the Neap directory.

### Database ###

A database representation made with [pgModeler (PostgreSQL Database Modeler)](http://www.pgmodeler.com.br/) may be found under the `resources\database\neap.dbm` location, alongside a PNG view of this same model.  
The PostgreSQL instance may be administrated through [pgAdmin](http://www.pgadmin.org/), with this connection information:
- **Host:** localhost
- **Port:** 5432
- **Username:** neap
- **Password:** neap

## Documentation ##

[README.md](https://github.com/e7d/neap/blob/master/README.md) - This markdown file, the technical steps to get Neap up and running.  
[Wiki](https://github.com/e7d/neap/wiki) - Coming later: Frequently asked questions, per OS install guides, debugging information
