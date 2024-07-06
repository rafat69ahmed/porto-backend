# Portonics Limited Project Test


## Tools
- PHP 8.2
- pgsql 16.0

## Installation
Run these commands one by one from root directory to up and running this PHP project with  with dummy data:

- `composer install`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan serve`

## Usage
This application will be up and running to this address: http://localhost:8000. You may visit that local address to test the PHP application and it can be test in postman. the 2 mandatory api
```
http://localhost:8000/api/v1/orders(post request)
http://localhost:8000/api/v1/invoice(post request)
```
