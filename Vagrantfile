# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  
  config.vm.box = "NoUseFreak/clastic-dev"

  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "private_network", ip: "33.33.33.100"
    
  config.vm.synced_folder ".", "/vagrant", type: "nfs"
end
