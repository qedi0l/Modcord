# ОПИСАНИЕ ПРОЕКТА

Это мой пет-проект, который я использую для хранения истории сезонов приватного игрового сервера. Онлайн версия тут -> `#`.


Как поднять:

Для работы требуются postgres и redis. 
`docker-compose` можно найти в директории docker\postgres

Дальше миграции `php artisan migrate`
Подключаем паблик хранилище файлов `php artisan storage:link`
Запускаем `php artisan serve`
Запускаем Ноду `npm run dev`

Стандартный url `http://127.0.0.1:8000`


@Since 2024 for Now.

## Админпанель
По умолчанию регистрация отключена.

Для создания админ аккаунта `php artisan db:seed`

email `admin@admin.com`
password `12345678`

