start:
	sudo service docker start
	sudo docker start mamidi-postgres
	php app/console server:start

features:
	./bin/behat

test: features

.PHONY: features
