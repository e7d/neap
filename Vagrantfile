Vagrant.configure(2) do |config|
    config.vm.define "neap" do |node|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        node.vm.box = "debian/jessie64"

        # Network configuration
        # node.vm.network "public_network"
        # node.vm.network "private_network", type: "dhcp"
        node.vm.network "private_network", ip: "192.168.10.2"
        node.vm.network "forwarded_port", guest: 80, host: 8080
        node.vm.network "forwarded_port", guest: 443, host: 8443
        node.vm.network "forwarded_port", guest: 5432, host: 5432
        node.vm.hostname = "neap"

        # Synced folder configuration
        node.vm.synced_folder '.', '/vagrant', nfs: true

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
