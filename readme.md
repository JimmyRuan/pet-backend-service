

```bash
# important  commands
# command to serve the backend
symfony server:start --allow-http --port=8000 --listen-ip=0.0.0.0 --document-root=/var/www/api-app/public

# create database
php bin/console doctrine:database:create

# check mysql connection
php bin/console doctrine:query:sql "SELECT 1"

# create pet entity
php bin/console make:entity Pet

# run migrations
php bin/console make:migration

# show available endpoints
php bin/console debug:router

# generate migrations
php bin/console doctrine:migrations:diff

# run migrations
php bin/console doctrine:migrations:migrate

# set up for phpunit tests
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate --env=test


# run unit tests:
vendor/bin/phpunit






# command to serve the frontend
yarn serve


# frontend url:
http://localhost:3000/

# backend url:
http://localhost:8000/health

```

