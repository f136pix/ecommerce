.PHONY: run-db
run-db: 
	@echo "Starting mySql container..."
#	sudo service mysql stop
	docker run --name mysql-container -e MYSQL_ROOT_PASSWORD=Password! -e MYSQL_USER=admin -e MYSQL_PASSWORD=Password! -e MYSQL_DATABASE=ecommerce -p 3306:3306 -d mysql:8.2
	
.run-migrations: 
	 ./vendor/bin/doctrine-migrations generate
	 

	