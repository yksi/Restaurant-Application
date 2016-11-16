#!/usr/bin/env bash
#Update centos
sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
sudo rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
sudo yum -y update

#Install tools
sudo yum install -y tar bzip2 git zip unzip

#Install configs
sudo cp -Rf /vagrant/soft-group-test/data/deploy/development/etc/* /etc/
echo export APPLICATION_ENV="development" >> /etc/bashrc

#Install httpd
sudo yum install -y httpd
sudo service httpd start
sudo chkconfig httpd on

#Install mariaDB
sudo yum install -y MariaDB-server MariaDB-client
sudo service mysql start
sudo chkconfig mysql on

#Install PHP
sudo yum install -y php70w php70w-opcache
sudo yum install -y php70w-pear php70w-devel php70w-pdo php70w-pecl-redis php70w-bcmath \
                    php70w-dom php70w-eaccelerator php70w-gd php70w-imap php70w-intl php70w-mbstring \
                    php70w-mcrypt php70w-mysqlnd php70w-posix php70w-soap php70w-tidy php70w-xmlrpc \
                    php70w-pecl-xdebug php70w-zip

sudo chmod 777 -R /var/lib/php/session

#Install code analyser
sudo pear install PHP_CodeSniffer
wget http://static.phpmd.org/php/latest/phpmd.phar
sudo mv phpmd.phar /usr/bin/phpmd
sudo chmod +x /usr/bin/phpmd

#Restart services
sudo service httpd restart
sudo service mysql restart
sudo service redis restart

#Install composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer