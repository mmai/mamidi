#!/bin/sh

DATADIR="/var/www/mamidi/data"
PGPASSWORD=mamidipwd
NAME=mamidi-postgres

#docker pull postgres:9.4

#Psql server local container (for easy local access, creation comprehension...)
docker create --name $NAME -v $DATADIR/postgresql/:/var/lib/postgresql/data/ -e POSTGRES_PASSWORD=$PGPASSWORD -p 5432:5432 postgres:9.4

echo "Create ekyut database and tables"
docker start $NAME
#sleep 5
#PGPASSWORD=$PGPASSWORD psql -h localhost -U postgres < create.sql

#To connect in a bash session:
#sudo docker exec -i -t $NAME bash

#To connect from local machine
#psql -Upostgres -hlocalhost -p5432
