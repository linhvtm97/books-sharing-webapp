### Building development environment
## Introduction

A PHP development environment for Docker.

- Php 8.1
- Nginx
- Mysql 5.7

## Getting Started
### Requirements

- [Git](https://git-scm.com/downloads)
- [Docker](https://store.docker.com/editions/community/docker-ce-desktop-mac) >= 17.12
- PHP >=8.1
### Installation

#### Build development environment

After clone the project, you may to setup alias of your project name in COMPOSE_PROJECT_NAME of .env file. Something like this:
```
cp .env.example .env
```
```
COMPOSE_PROJECT_NAME=yourappname
```

After that, let's following below command:

```
docker-compose build
```

Waiting for a while to finish building containers. Then start run containers.
```
docker-compose up -d
```

You should be seen all of containers state is `up`

#### Setup laravel
Open workspace container then install composer for project
```
docker exec -it yourappname_app bash
```

```
composer install
```

Directory permissions to `bootstrap/cache` and `storage` folder.
```
chmod -R 755 bootstrap/cache/ storage/
```

Make sure root folder has `.env` file and `APP_KEY` has been set. If not please using this command to add them.
```
php artisan key:generate
```

Run command for migrate table

```shell
php artisan migrate
```

Open browser and type `localhost` then laravel should be load successful.

#### Change your hosts
Open your hosts in `/etc/hosts` the add a host:
```
127.0.0.1   ￼api.local
```

### Coding conventions

You may follow this practice to apply code convention into this project
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)

#### Required
While push your commit, the application will check your code conventions automatically. You can see the result in your terminal:

- Coding conventions
- Possible bugs
- Suboptimal code
- Overcomplicated expressions
- Unused parameters, methods, properties

**[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)**

This follow PHP Standards Recommendations: PSR1, PSR2
```
./vendor/bin/phpcs -n --standard=phpcs.xml
```

**[PHPMD](https://github.com/phpmd/phpmd)**
```
./vendor/bin/phpmd app text phpmd.xml
```
