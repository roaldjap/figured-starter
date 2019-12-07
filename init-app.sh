#!/usr/bin/env bash
# Note: run this only once after you setup your machine environment

cp .env.example .env
docker-compose exec app composer install
docker-compose exec app yarn
docker exec -it mongodb mongo admin --eval "db.createUser({ user: 'user', pwd: 'pass', roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"

# Seed data
docker-compose exec app php artisan migrate:fresh --seed
