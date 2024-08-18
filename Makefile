wipe:
	/home/fziv/scripts/util.sh d_wipe

rm-volumes-compose:
	docker compose down --volumes

connect-php:
	docker compose exec -it php bash

connect-node:
	docker compose exec -it node bash

root-connect-php:
	docker compose exec -it -u 0 php bash

artisan-migrate:
	docker compose exec php php artisan migrate

artisan-migrate-fresh:
	docker compose exec php php artisan migrate:fresh

artisan-migrate-seed:
	docker compose exec php php artisan migrate:fresh --seed

artisan-key-generate:
	docker compose run --rm php php artisan key:generate

artisan-storage:
	docker-compose run --rm php php artisan storage:link

build:
	docker compose build

composer:
	docker compose run --rm php composer $(arg)

composer-install-dev: composer-update
	docker compose run --rm php composer install

composer-install-prod:
	docker compose run --rm php composer install --optimize-autoloader --no-suggest --no-dev

composer-update:
	docker compose run --rm php composer update

copy-env:
	cp .env.example .env

copy-docker-compose-dev:
	cp docker-compose.dev.yml docker-compose.yml

down:
	docker compose down --remove-orphans

eslint:
	docker compose run --rm node npm run eslint

install: copy-docker-compose-dev upgrade laravel-install copy-env up npm-install artisan-key-generate artisan-storage ## Install Project


install-without-generating: copy-docker-compose-dev upgrade up npm-install artisan-key-generate artisan-storage ## Install Project

sleepy:
	sleep 15s

install-pkgs: upgrade up npm-install composer-install-dev artisan-key-generate down upy sleepy artisan-migrate-fresh artisan-storage
	@echo "go to localhost and enjoy"

rm-this:
	rm -rf vendor
	rm  -rf  node-modules

sql:
	export PGPASSWORD='postgres';psql -h localhost -p 5432 -U postgres -d laravel


delete-db: down
	./util.sh delete-db

git-pull:
	git reset --hard
	git pull origin --no-rebase

laravel-install:
	docker-compose run --rm php composer create-project laravel/laravel laravel --prefer-dist
	mv README.md README-docker.md
	-mv -f ./laravel/* ./laravel/.* ./
	-rm -rf ./laravel

npm:
	docker compose run --rm node npm $(arg)

npm-install:
	docker compose run --rm node npm install

npm-update:
	docker compose run --rm node npm update

up:
	docker compose up -d

upy:
	docker compose up -d


up-a:
	docker compose up

migrate-new:
	./util.sh migrate-new


upgrade: pull build

upgrade-dev: down copy-docker-compose-dev upgrade up composer-install-dev npm-install

pull:
	docker compose pull

setup-dev: copy-docker-compose-dev copy-env upgrade composer-install-dev npm-install artisan-key-generate artisan-migrate

dev:
	./util.sh dev
