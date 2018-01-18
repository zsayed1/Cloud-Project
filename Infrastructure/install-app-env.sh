#!/bin/bash
runuser -l ubuntu -c 'git clone git@github.com:illinoistech-itm/zsayed1.git'
runuser -l ubuntu -c 'sudo mv zsayed1/ITMO-544/MP3/Front-end/*.php /var/www/html/'
runuser -l ubuntu -c 'sudo mv zsayed1/ITMO-544/MP3/Front-end/*.js /var/www/html/'
runuser -l ubuntu -c 'sudo mv zsayed1/ITMO-544/MP3/Front-end/*.css /var/www/html/'

