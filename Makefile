start:
	sudo service docker start
	sudo docker start mamidi-postgres
	php app/console server:start

features:
	./bin/behat

specs:
	./bin/phpspec run

test: specs features 

.PHONY: features
