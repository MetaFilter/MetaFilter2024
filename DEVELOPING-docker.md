# Docker Compose Development Environment

## Install Docker Desktop

To use Docker Compose to run the services required for development, follow the [Getting Started instructions](https://docs.docker.com/get-started/get-docker/).

## Environment settings

Once you have Docker installed, `cp .env.example .env` to make a local copy of the environment settings file, and then edit to supply values for the database:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=metafilter
DB_USERNAME=metafilter
DB_PASSWORD=<come up with something>
```

At this point, you should be able to run `docker compose up` and see logs from the different services (e.g. MySQL, Redis, Mailhog). Or, you can run `docker compose up -d` and the services will start in the background, and you can run `docker compose logs -f <service>` to follow the logs from a specific service.

## Run tool containers

To help work around any differences in the tool versions available on your machine, or even just the lack of installed tools on your machine, there are tool containers that can be run ad-hoc.

 * `composer` - use `docker compose run --rm composer` followed by the arguments for `composer`.
 * `php artisan` - use `docker compose run --rm artisan` followed by the arguments for `php artisan` (see additional notes below for running `php artisan serve`).
 * `npm` - use `docker compose run --rm npm` follow by the arguments for `npm`
 * `mysql` - use `docker compose run --rm mysql mysql -h mysql -u metafilter -p` to access a `mysql` client

## Initial setup

Using the tool containers, run the usual Laravel setup steps:

```
# composer install
docker compose run --rm composer install

# npm install
docker compose run --rm npm install

# npm build
docker compose run --rm npm build

# php artisan key:generate
docker compose run --rm artisan key:generate

# php artisan migrate
docker compose run --rm artisan migrate

# php artisan db:seed
docker compose run --rm artisan db:seed
```

## Run development server

Additional options are required to get the right behavior for `php artisan serve`:

```
docker compose run --rm --service-ports artisan serve --host=0.0.0.0
```

## Configure test host names

The Laravel app uses hostname routes - i.e. just browsing to `http://localhost:8000` will not show the site. Add the following to `/etc/hosts` so you can browse instead to `http://www.metafilter.test:8000/` and see the right routes:

```
127.0.0.1   www.metafilter.test
127.0.0.1   ask.metafilter.test
127.0.0.1   fanfare.metafilter.test
127.0.0.1   bestof.metafilter.test
127.0.0.1   irl.metafilter.test
127.0.0.1   jobs.metafilter.test
127.0.0.1   metatalk.metafilter.test
127.0.0.1   music.metafilter.test
127.0.0.1   podcast.metafilter.test
127.0.0.1   projects.metafilter.test
```
