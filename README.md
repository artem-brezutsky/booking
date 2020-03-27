# Бронирование переговорных комнат
## Laravel

### Установка composer

```bash
php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar install
```

**1.** Склонировать проект и зайти в папку с проектом;

**2.** Выполнить команду ```composer install --no-dev```;

**3.** Копируем файл `.env.example`, меняем имя файла на `.env`;

**4.** Установка настроек в файле `.env`:

```
APP_ENV = production
APP_DEBUG = false

DB_DATABASE = Название базы данных
DB_USERNAME = Имя пользователя базы данных
DB_PASSWORD = Пароль от базы данных

# LDAP (если ничего не менялось, то используйте приведенные здесь опции)
LDAP_ENABLED=true
LDAP_ONLY=false
LDAP_HOST=ldap
LDAP_PORT=389
LDAP_PROTOCOL_VERSION=3
LDAP_READER_DN=
LDAP_READER_PASSWORD=
LDAP_USERS_GROUP_DN=
LDAP_LOGIN_FIELD=uid
LDAP_FILTER=uid=:uid
LDAP_IMPORT_MAP=ldap_uid=dn,email=email.0,name=name.0

# Настроить mail-драйвер для рассылки писем
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

# Установить драйвер очереди
QUEUE_CONNECTION=database
```

**5.** Выполнить ```php artisan key:generate```;

**6.** Создать соответствующую конфигурации базу данных и выполнить ```php artisan migrate```;

**7.** Выполнить команду для создания админа указав в качестве параметров имя, email и пароль пользователя: ```php artisan superuser:add name your@email.com your_password```;

**8.** Для запуска очереди можно использовать команду ```php artisan queue:work``` в корне проекта // больше информации на https://laravel.com/docs/5.8/queues#running-the-queue-worker

**9.** Для работы с очередью необходимо для сервиса запустить и мониторить (и перезапускать в случае падения) скрипт-получатель новых задач.

Пример для Supervisor:

```
[program:pics-worker]
process_name=%(program_name)s_%(process_num)02d
command=php {path_to_project}/artisan queue:work --timeout=0 --tries=3
autostart=true
autorestart=true
user=forge
numprocs=1
redirect_stderr=true
stdout_logfile=/home/forge/pics.service/worker.log
```

**10.** Настроить cron:

```
* * * * * cd /path-to-booking-project && php artisan schedule:run >> /dev/null 2>&1
```