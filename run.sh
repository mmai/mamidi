#!/bin/sh

sudo service docker start
sudo docker start mamidi-postgres
php app/console server:start
