.PHONY: run-db migrate
run-db: 
	@echo "Starting mySql container..."
#	sudo service mysql stop
	docker run --name mysql-container -e MYSQL_ROOT_PASSWORD=Password! -e MYSQL_USER=admin -e MYSQL_PASSWORD=Password! -e MYSQL_DATABASE=ecommerce -p 3306:3306 -d mysql:8.2
	
migrate: 
	@echo "Running migrations..."
	cd server && php vendor/bin/doctrine-migrations diff
	cd server && php vendor/bin/doctrine-migrations migrate