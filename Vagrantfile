Vagrant.configure(2) do |config|
    config.vm.define "Neap" do |node|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        node.vm.hostname = "neap.dev"
        node.hostsupdater.aliases = ["api.neap.dev", "db.neap.dev", "doc.neap.dev", "irc.neap.dev", "rtmp.neap.dev", "static.neap.dev"]
        node.vm.box = "debian/jessie64"

        # Network configuration
        node.vm.network "private_network", ip: "192.168.10.2"
        node.vm.network "forwarded_port", guest: 80, host: 8080
        node.vm.network "forwarded_port", guest: 443, host: 8443
        node.vm.network "forwarded_port", guest: 5432, host: 5432

        # Synced folder configuration
        node.vm.synced_folder ".", "/vagrant", type: "nfs"

        # VirtualBox provider
        node.vm.provider "virtualbox" do |vb|
            # System configuration
            vb.name = "Neap"
            vb.cpus = "4"
            vb.memory = "1024"

            # Additional storage configuration
            data_disk = "./.vagrant/machines/neap/virtualbox/data.vdi"
            unless File.exist?(data_disk)
               vb.customize ["createhd", "--filename", data_disk, "--size", 512 * 1024]
               vb.customize ["storageattach", :id, "--storagectl", "SATA Controller", "--port", 1, "--device", 0, "--type", "hdd", "--medium", data_disk]
            end
        end
        node.vbguest.auto_update = true
        node.vbguest.no_remote = true

        # Provisioning script
        node.vm.provision "shell", inline: "/bin/sh /vagrant/bootstrap.sh"
    end
end
