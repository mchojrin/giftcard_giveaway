build:
	docker-compose build --no-cache --pull

up: 
	docker-compose up -d

down: 
	docker-compose down --remove-orphans
