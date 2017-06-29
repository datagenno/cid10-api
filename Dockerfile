# Ubuntu 14.04 LTS
FROM phusion/baseimage:0.9.18

ENV DEBIAN_FRONTEND noninteractive

RUN locale-gen pt_BR.UTF-8 en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8

RUN apt-get update && apt-get install -y software-properties-common
RUN LC_ALL=en_US.UTF-8 apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
RUN LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/php

################################################################################
## INSTALL DEPENDENCIES ########################################################
################################################################################

RUN apt-get update
RUN apt-key update
RUN apt-get install -y curl
RUN apt-get install -y git-core
RUN apt-get install -y apache2
RUN apt-get install -y php5.6
RUN apt-get install -y php5.6-curl
RUN apt-get install -y php5.6-xmlrpc
RUN apt-get install -y php5.6-xml
RUN apt-get install -y php5.6-json
RUN apt-get install -y php5.6-mbstring

RUN apt-get clean
RUN phpenmod dom
RUN phpenmod mbstring

################################################################################
# CONFIGURATIONS ###############################################################
################################################################################

RUN rm -fr /var/www/html
ADD . /var/www/html
WORKDIR /var/www/html

RUN  sed -i.bak 's/upload_max_filesize = 2M/upload_max_filesize = 15M/g' /etc/php/5.6/apache2/php.ini && \
     sed -i.bak 's/post_max_size = 8M/post_max_size = 15M/g' /etc/php/5.6/apache2/php.ini && \
     sed -i.bak 's/short_open_tag = Off/short_open_tag = On/g' /etc/php/5.6/apache2/php.ini && \
     sed -i.bak 's/;date.timezone =/date.timezone = America\/Sao_Paulo/g' /etc/php/5.6/apache2/php.ini

RUN a2enmod headers \
            actions \
            rewrite \
            expires \
            deflate

# create the configuration file in the "available" section
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
# enable it by creating a symlink to it from the "enabled" section
RUN sudo a2enconf servername

RUN mkdir -p /etc/service/apache
ADD apache-init.sh /etc/service/apache/run
RUN chmod +x /etc/service/apache/run

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

################################################################################
# Add altered apache vhost #####################################################
################################################################################

RUN rm -rf /etc/apache2/sites-available/* /etc/apache2/sites-enabled/*
ADD apache-vhost.conf /etc/apache2/sites-available/apache-vhost.conf
RUN ln /etc/apache2/sites-available/apache-vhost.conf /etc/apache2/sites-enabled/apache-vhost.conf

################################################################################
# Add normal user to get rid of pesky file ownership problems ##################
################################################################################

RUN PYTHON=$PYTHON:/usr/bin/python
RUN export PYTHON

RUN groupadd deployer && useradd -g deployer deployer && \
    sed -i.back 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=deployer/g' /etc/apache2/envvars && \
    sed -i.back 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=deployer/g' /etc/apache2/envvars
