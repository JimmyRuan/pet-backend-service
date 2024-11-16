

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



# command to serve the frontend
yarn serve


# frontend url:
http://localhost:3000/

# backend url:
http://localhost:8000/health

```

