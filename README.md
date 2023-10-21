# Laravel-test

## Get Started

1. 啟動 docker `docker-compose up -d`
2. 執行 `docker exec laravel-test-php-fpm-1 composer install`
3. 複製 .env `cp .env.example .env`
4. 生成 laravel key `docker exec laravel-test-php-fpm-1 php artisan key:generate`

## Run test

`docker exec laravel-test-php-fpm-1 composer test-in-docker`

## Call API

`http://localhost:8088/api/currency_exchange?source=TWD&target=TWD&aount=100`
