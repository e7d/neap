Vagrant.configure(2) do |config|
    config.vm.define "media-streaming" do |box|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        box.vm.hostname = "media-streaming"
        box.vm.box = "debian/jessie64"
        box.vm.network "public_network"
        box.vm.network "forwarded_port", guest: 5432, host: 5432
        box.vm.provider "virtualbox" do |vb|
            vb.name = "media-streaming"
            vb.cpus = "1"
            vb.memory = "512"
        end
        box.vm.provision "shell", inline: <<-SHELL
            sudo /vagrant/setup.sh
        SHELL
    end
end
