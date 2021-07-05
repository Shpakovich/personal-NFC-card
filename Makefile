init: docker-down-clear frontend-clear docker-pull docker-build docker-up frontend-init
up: docker-up
down: docker-down
restart: down up
check: api-lint api-phpcs api-psalm

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

api-lint:
	docker-compose run --rm api-php-cli composer lint

api-phpcs:
	docker-compose run --rm api-php-cli composer phpcs

api-psalm:
	docker-compose run --rm api-php-cli composer psalm

### Frontend

frontend-init: frontend-install frontend-ready

frontend-clear:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'rm -rf .ready .nuxt'

frontend-install:
	docker-compose run --rm frontend-cli yarn install

frontend-ready:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'touch .ready'
