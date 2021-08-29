# Personal NFC card

Front: http://localhost:8080  
API: http://localhost:8081  
Mailer: http://localhost:8082

## Основные команды

```bash
$ make init             # Инициализация окружения
$ make up               # Запуск окружения
$ make down             # Остановка окружения
$ make restart          # Перезагрузка окружения
$ make check            # Проверка (линтеры, стат. анализ кода)
$ make api-oauth-keys   # Генерация ключей для OAuth
```

## Порядок запуска окружения

При первом запуске нужно выполнить команду:
```bash
$ make init
$ make api-oauth-keys
```

Команда `make init` удаляет старое окружение и собирает новое заново, в том числе удаляется база.

Когда окружение инициализирована, достаточно запуска команды `make up`.

Чтобы остановить окружение выполняем `make down`. 

## Работа с пакетным менеджером Yarn

```bash
$ docker-compose run --rm frontend-cli yarn add <package>
$ docker-compose run --rm frontend-cli yarn remove <package>
$ docker-compose run --rm frontend-cli yarn update
```

Если ставить зависимости фронта через Yarn, который стоит на локальной машине, то могут возникнуть ошибки при деплое приложения на сервере, т.к. версии Yarn и Node JS на сервере могу отличаться от локальных. Поэтому важно работать с зависимости используя контейнер `frontend-cli`, как показано выше.

## Почтовый клиент

Для локальной разработки, чтобы было куда слать письма, например, токены, поднят почтовый клиент.

Веб интерфейс: http://localhost:8082  
SMTP работает на порту 1025.  

## Авторизация

Сначала получаем `access_token` и `refresh_token`:
```
Request

POST /auth/token HTTP/1.1
Host: localhost:8081
Accept: application/json
Content-Type: application/x-www-form-urlencoded

grant_type=password
&username=aaa%40ccc.ru
&password=11111
&client_id=frontend

Response

{
    "token_type": "Bearer",
    "expires_in": 3600,
    "access_token": "xxx",
    "refresh_token": "yyy"
}
```

Все поля обязательны, поле `client_id` всегда должно быть равно `frontend`, иначе сервер не примет запрос.

Токен `access_token` выдается на час, `refresh_token` на месяц.

Далее используем Bearer авторизацию и `access_token` для получения доступа к зарытому API.

```
POST /card/create HTTP/1.1
Host: localhost:8081
Accept: application/json
Authorization: Bearer xxx
Content-Type: application/json

{
    "id": "1111"
}
```

Когда `access_token` истечет, используем `refresh_token` чтобы получить новый токен. Вместе с новым `access_token` придет новый `refresh_token`.

```
Request

POST /auth/token HTTP/1.1
Host: localhost:8081
Accept: application/json
Content-Type: application/x-www-form-urlencoded

grant_type=refresh_token
&refresh_token=yyy
&client_id=frontend

Response

{
    "token_type": "Bearer",
    "expires_in": 3600,
    "access_token": "xxx_2",
    "refresh_token": "yyy_2"
}
```

## Консольные команды

Создание администратора
```bash
$ bin/console app:create:admin <email> <password>
```

## Media store

На сервере медиа файлы (фото профиля, иконки) грузятся в папку:
```
/media/storage/myid-card
```

Она пробрасывается внутрь контейнеров.

## Ручной деплой

> Команды выполняем из корня проекта.

Собрать Docker контейнеры:
```bash
$ REGISTRY=registry.gitlab.com/shpakovich/personal-nfc-card IMAGE_TAG=master make build
```

Запушить готовые контейнеры в наш реестр:
```bash
$ REGISTRY=registry.gitlab.com/shpakovich/personal-nfc-card IMAGE_TAG=master make push
```

Развернуть новый код на сервере:
```bash
$ HOST=<SERVER_IP> PORT=22 REGISTRY=registry.gitlab.com/shpakovich/personal-nfc-card BUILD_NUMBER=master IMAGE_TAG=master BASE_URL=https://myid-card.ru STORAGE_BASE_URL=https://media.myid-card.ru STORAGE_DIR=/var/storage MAILER_DSN=<MAILER_DSN> make deploy
```

В случае, если на сервере надо перезапустить контейнеры:
```bash
$ ssh root@<SERVER_IP>
$ cd /home/deploy/myid_card
$ docker-compose -f docker-compose-prod.yml restart
```
