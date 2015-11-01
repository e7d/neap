Vagrant.configure(2) do |config|
    config.vm.define "neap" do |box|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        box.vm.box = "debian/jessie64"

        # Network configuration
        # box.vm.network "public_network"
        box.vm.hostname = "neap"
        box.vm.network "private_network", ip: "192.168.42.11"
        box.vm.network "forwarded_port", guest: 80, host: 8080
        box.vm.network "forwarded_port", guest: 5432, host: 5432
        box.hostmanager.enabled = false
        # box.hostsupdater.aliases = ["neap.local"]

        # VirtualBox provider
        box.vm.provider "virtualbox" do |vb|
            vb.name = "neap"
            vb.cpus = "2"
            vb.memory = "512"
        end
        box.vbguest.auto_update = false
        box.vbguest.no_remote = true

        # Provisioning script
        box.vm.provision :hostmanager
        box.vm.provision "shell", inline: "/bin/sh /vagrant/setup.sh"
    end
end
