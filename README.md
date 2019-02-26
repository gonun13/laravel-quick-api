# laravel-quick-api
Quick API with Laravel and Docker (Ubuntu 18)

git clone git@github.com:gonun13/laravel-quick-api.git

cd laravel-quick-api.git

./start

-----------
git clone https://github.com/laravel/laravel.git laravel-quick-api

cd laravel-quick-api

rm -rf .git/

sudo docker run --rm -v $(pwd):/app composer install

sudo chown -R $USER:$USER ../laravel-quick-api

nano docker-compose.yml

sudo docker-compose up -d

cp .env.example .env

sudo docker-compose exec app php artisan key:generate

sudo chmod -R 777 storage && chmod -R 777 bootstrap/cache
