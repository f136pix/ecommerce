.PHONY: run-db migrate run-php
run-db: 
	@echo "Starting mySql container..."
#	sudo service mysql stop
	docker run --name mysql-container -e MYSQL_ROOT_PASSWORD=Password! -e MYSQL_USER=admin -e MYSQL_PASSWORD=Password! -e MYSQL_DATABASE=ecommerce -p 3306:3306 -d mysql:8.2
	
migrate: 
	@echo "Running migrations..."
	cd server && php vendor/bin/doctrine-migrations diff
	cd server && php vendor/bin/doctrine-migrations migrate
	cd server && php seeder/script.php
	
run-php: 
	#cd server && nohup php -S localhost:8000 -t public > server.log 2>&1 &
	cd server && composer update
	cd server && composer install
	cd server && nohup php -S 0.0.0.0:8000 -t public > server.log 2>&1 &
	#cd server && php -S localhost:8000 -t public
	
run-web:
	cd web && yarn build
	cd web && yarn global add serve
	cd web && nohup sudo serve -s dist -l 80 > serve.log 2>&1 &
	