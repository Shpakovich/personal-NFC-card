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

### Prod build

build: build-gateway build-api-nginx build-api-php-fpm build-api-php-cli build-frontend build-storage

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

build-storage:
	docker --log-level=debug build --pull \
	--tag=${REGISTRY}/storage:${IMAGE_TAG} \
	--file=storage/docker/prod/nginx/Dockerfile ./storage

### Prod push

push: push-gateway push-api-nginx push-api-php-fpm push-api-php-cli push-frontend push-storage

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

push-storage:
	docker push ${REGISTRY}/storage:${IMAGE_TAG}

### Prod deploy

deploy:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -rf myid_card_${BUILD_NUMBER}'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'mkdir myid_card_${BUILD_NUMBER}'

	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-prod.yml deploy@${HOST}:myid_card_${BUILD_NUMBER}/docker-compose-prod.yml

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=myid_card" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "STORAGE_BASE_URL=${STORAGE_BASE_URL}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "STORAGE_DIR=${STORAGE_DIR}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "MAILER_DSN=${MAILER_DSN}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && echo "BASE_URL=${BASE_URL}" >> .env'

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && docker-compose -f docker-compose-prod.yml pull'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && docker-compose -f docker-compose-prod.yml up --build -d db'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && docker-compose -f docker-compose-prod.yml run api-php-cli bin/console doctrine:migrations:migrate --no-interaction'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd myid_card_${BUILD_NUMBER} && docker-compose -f docker-compose-prod.yml up --build --remove-orphans -d'

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -f myid_card'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'ln -sr myid_card_${BUILD_NUMBER} myid_card'
