# Project setup - Docker

First step is to setup docker environment for local development. This solution also works for development on server or production.
You must have [Docker](https://docs.docker.com/get-started/) and [Docker Compose](https://docs.docker.com/compose/install/)
installed on your system. This guide has been tested on Ubuntu 20.04 with Docker version `20.10.12` and Docker Compose version `1.29.2`. Users of operating systems other than Linux will
most likely have to deal with various compatibility issues. This tutorial assumes you are working in `/var` directory.

Now clone API repository containing docker. Also clone all the other repos now before building docker.
```bash
$ git clone https://github.com/matuslipa/api-base.git 
```

Go to docker directory and run script to setup all services necessary to run docker.
```bash
$ cd /api-base/docker
$ ./scripts/setup-services.sh ./
```

Copy `.env.example` into `.env` and set all parameters.

```bash
$ cp .env.example .env
```

These are the parameters you will be most likely to change:

- API_SUBPATH_HOST path. In our case it`s api-base.),


Now you can build containers and run docker in detached environment.

```bash
$ docker-compose build
$ docker-compose up -d
```


# Project setup - API

We\`ve already set directory in section docker
To run api you must go to `workspace` container first.

```bash
$ cd api-base/docker
$ docker-compose exec -u matus workspace bash
```

Inside docker container install laravel project.

```bash
$ cd cd api-base
$ composer i
$ cp .env.example .env
$ php artisan key:generate
```

Now go to `pma.localhost` (assuming you left default configuration of docker) in your browser and create database.
You can choose whatever name, you just need to make sure that you set configuration parameters properly in your `.env` files.
Defaut is mariadb/root/root.

Next you can either import database or run migrations and seeders.
```bash
$ php artisan migrate

```
Assuming you didn\`t change default nginx configuration API should now be accessible on `http://api.localhost`.
