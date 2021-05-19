### Docker Symfony
This is a stack for run Symfony 5, PHP 8 using docker-compose tool

### Installation
First, clone repository:

```bash
$ git clone https://github.com/docker-symfony.git
```

Run:
```bash
$ docker-compose up -d --build
```

### How it works?
The `docker-compose` built images:
- `mysql`: This is the MySQL database container.
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
