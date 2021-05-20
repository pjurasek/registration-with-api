### Docker Symfony

This is a stack for run Symfony 5, PHP 8 using docker-compose tool

### Using Docker

You need  [Docker](https://github.com/docker/docker) and  [docker-compose](https://github.com/docker/compose).

### Installation

First, clone repository:

```bash
$ git clone https://github.com/pjurasek/registration-with-api.git
```

Enter into folder where is `docker-compose.yml` file.

```bash
$ cd registration-with-api/docker
```

Build Docker images:

```bash
$ docker-compose build
```

Run Docker containers in detached mode:

```bash
$ docker-compose up -d
```

### How it works?

The `docker-compose` built images:
- `postgres`: This is the Postgres database container.
- `php-fpm`: This is the PHP FPM container including the application volume mounted on.
- `nginx`: This is the Nginx web server container in which php volume are mounted on.

The result is the following running containers:
```bash
$ docker-compose ps
```

### Troubleshooting
Remove container
```bash
$ docker container rm -f <id-container>
```

### Registration form

Registration form is available on the URL

```
http://localhost/register
```

Show all registered users is available on the URL

```
http://localhost/show/all
```

API endpoints are available on the URL
```
http://localhost/api
```