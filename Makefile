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

api-init: api-composer-install api-migration-migrate api-oauth-schema api-oauth-client

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-migration-migrate:
	docker-compose run --rm api-php-cli bin/console doctrine:migrations:migrate --no-interaction

api-oauth-schema:
	docker-compose run --rm api-php-cli bin/console doctrine:schema:update --force

api-oauth-client:
	docker-compose run --rm api-php-cli bin/console trikoder:oauth2:create-client --public --grant-type password --grant-type refresh_token frontend

api-oauth-keys:
	docker-compose run --rm api-php-cli mkdir -p var/oauth
	docker-compose run --rm api-php-cli openssl genrsa -out var/oauth/private.key 2048
	docker-compose run --rm api-php-cli openssl rsa -in var/oauth/private.key -pubout -out var/oauth/public.key
	docker-compose run --rm api-php-cli chmod 644 var/oauth/private.key var/oauth/public.key

### Frontend

frontend-init: frontend-install frontend-ready

frontend-clear:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'rm -rf .ready .nuxt'

frontend-install:
	docker-compose run --rm frontend-cli yarn install

frontend-ready:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'touch .ready'
