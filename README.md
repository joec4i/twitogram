# Twitogram - A twitter histogram demo  

## System requirements
* Vagrant 1.8 (with ansible_local support). 
* Oracle Virtualbox ( tested on v5.0.26)

## Setup
```
# If you don't have vagrant vbguest plugin installed
# install it to just in case there's problem with shared folder mounting
vagrant plugin install vagrant-vbguest

# clone the project 
# cd /where/the/project/should/be
git clone https://github.com/joec4i/twitogram.git
cd twitogram
vagrant up
# wait for vagrant to 
# - pull the ubuntu 16.04 box if it's not on your local hard drive
# - install / upgrade virtualbox guest additions if required
# - install ansible in the guest box
# - run ansible_local to provision the box:
# --- install nginx and php related packages
# --- configure nginx, php-fpm and xdebug
# --- run composer to install required packages

# after everything is done
open http://192.168.66.6/hello/World
```

## To run the tests
```
cd /path/to/twitogram
# ssh into the vagrant box
vagrant ssh
# run the tests with phpunit
cd /vagrant && ./vendor/bin/phpunit tests
```



