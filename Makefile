init: docker-down-clear frontend-clear docker-pull docker-build docker-up api-init frontend-init
up: docker-up
down: docker-down
restart: down up
check: api-check

### Docker

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull --include-deps

docker-build:
	docker-compose build

docker-push-cache:
	docker-compose push

### API

api-check: api-lint api-phpcs api-psalm api-schema-validate

api-lint:
	docker-compose run --rm api-php-cli composer lint

api-phpcs:
	docker-compose run --rm api-php-cli composer phpcs

api-psalm:
	docker-compose run --rm api-php-cli composer psalm

api-schema-validate:
	docker-compose run --rm api-php-cli bin/console doctrine:schema:validate

api-init: api-composer-install api-migration-migrate

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-migration-migrate:
	docker-compose run --rm api-php-cli bin/console doctrine:migrations:migrate --no-interaction

### Frontend

frontend-init: frontend-install frontend-ready

frontend-clear:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'rm -rf .ready .nuxt'

frontend-install:
	docker-compose run --rm frontend-cli yarn install

frontend-ready:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'touch .ready'
