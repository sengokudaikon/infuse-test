# Specify the name of your services here
PHP_SERVICE := web
DB_SERVICE := db

# The command to run docker-compose
DC := docker compose

start:
	$(DC) up -d --build
## Launch the whole environment
up:
	$(DC) up -d

stop:
	$(DC) down
## Run a shell in the app container
sh:
	$(DC) exec $(PHP_SERVICE) /bin/sh

## Connect to the database
db:
	$(DC) exec $(DB_SERVICE) mysql -u root -p

## Install project dependencies
deps:
	$(DC) exec $(PHP_SERVICE) composer install

## Run PHPCS Fixer
phpcs:
	$(DC) exec $(PHP_SERVICE) ./vendor/bin/php-cs-fixer fix src --diff --verbose --allow-risky=yes

## Run Psalm
psalm:
	$(DC) exec $(PHP_SERVICE) ./vendor/bin/psalm --alter --issues=all

restart:
	$(DC) down && $(DC) up -d

## Reset and rebuild the whole environment
reset:
	$(DC) down --rmi all && $(DC) up -d --build
restart-nginx-exporter:
	$(DC) restart nginx-exporter
.PHONY: start up stop sh db deps phpcs psalm restart reset restart-nginx-exporter
