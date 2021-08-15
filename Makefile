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

api-init: api-composer-install api-migration-migrate api-oauth-schema api-fixtures-load api-oauth-client

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-migration-migrate:
	docker-compose run --rm api-php-cli bin/console doctrine:migrations:migrate --no-interaction

api-fixtures-load:
	docker-compose run --rm api-php-cli bin/console doctrine:fixtures:load --no-interaction

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

### Prod

build: build-gateway build-api-nginx build-api-php-fpm build-api-php-cli build-frontend

build-gateway:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/gateway:${IMAGE_TAG} \
	--file=gateway/docker/prod/nginx/Dockerfile ./gateway

build-api-nginx:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/api-nginx:${IMAGE_TAG} \
	--file=api/docker/prod/nginx/Dockerfile ./api

build-api-php-fpm:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/api-php-fpm:${IMAGE_TAG} \
	--file=api/docker/prod/php-fpm/Dockerfile ./api

build-api-php-cli:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/api-php-cli:${IMAGE_TAG} \
	--file=api/docker/prod/php-cli/Dockerfile ./api

build-frontend:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/frontend:${IMAGE_TAG} \
	--file=frontend/docker/prod/node/Dockerfile ./frontend

push: push-gateway push-api-nginx push-api-php-fpm push-api-php-cli push-frontend

push-gateway:
	docker push ${REGISTRY}/gateway:${IMAGE_TAG}

push-api-nginx:
	docker push ${REGISTRY}/api-nginx:${IMAGE_TAG}

push-api-php-fpm:
	docker push ${REGISTRY}/api-php-fpm:${IMAGE_TAG}

push-api-php-cli:
	docker push ${REGISTRY}/api-php-cli:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/frontend:${IMAGE_TAG}
