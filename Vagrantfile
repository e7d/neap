Vagrant.configure(2) do |config|
    config.vm.define "neap" do |box|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        box.vm.hostname = "neap"
        box.vm.box = "debian/jessie64"

        # Network configuration
        box.vm.network "public_network"
        box.vm.network "forwarded_port", guest: 5432, host: 5432

        # VirtualBox provider
        box.vm.provider "virtualbox" do |vb|
            vb.name = "neap"
            vb.cpus = "1"
            vb.memory = "512"
        end
        box.vbguest.auto_update = false
        box.vbguest.no_remote = true

        # Provisioning script
        box.vm.provision "shell", inline: "/bin/sh /vagrant/setup.sh"
    end
end
