Vagrant.configure(2) do |config|
    config.vm.define "neap" do |node|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        node.vm.hostname = "neap.dev"
        node.hostsupdater.aliases = ["api.neap.dev", "db.neap.dev", "doc.neap.dev", "static.neap.dev", "rtmp.neap.dev"]
        node.vm.box = "debian/jessie64"

        # Network configuration
        # node.vm.network "public_network"
        node.vm.network "private_network", ip: "192.168.10.2"
        node.vm.network "private_network", type: "dhcp" # required for NFS on Windows to work, using "Vagrant WinNFSd" plugin
        node.vm.network "forwarded_port", guest: 80, host: 8080
        node.vm.network "forwarded_port", guest: 443, host: 8443
        node.vm.network "forwarded_port", guest: 5432, host: 5432

        # Synced folder configuration
        node.vm.synced_folder '.', '/vagrant', type: 'nfs'
        # node.vm.synced_folder '.', '/vagrant', type: 'rsync'
        # node.vm.synced_folder '.', '/vagrant', type: 'smb' # Windows host only

        # VirtualBox provider
        node.vm.provider "virtualbox" do |vb|
            vb.name = "neap"
            vb.cpus = "4"
            vb.memory = "1024"
        end
        node.vbguest.auto_update = true
        node.vbguest.no_remote = true

        # Provisioning script
        node.vm.provision "shell", inline: "/bin/sh /vagrant/setup.sh"
    end
end
