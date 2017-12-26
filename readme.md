# 9Laravel

9Laravel is a web application that mimics the functionality and design of the famous 9GAG website.

This application was created for learning purposes.

Even though the website looks and acts similar to the original website, no code was copied from it.

## Dependencies

### Frontend

* jQuery
* Bootstrap 3
* Font Awesome
* Mustache.js
* FileDrop.js

### Backend

* Intervention
* Socialite
* ResizeGif

## Installation

* Run in terminal `git clone https://github.com/FlorianStancioiu/9Laravel.git`
* Run in terminal `cd 9Laravel`
* Run in terminal `npm update && npm install`
* Run in terminal `composer update`
* Copy the `.env.example` file to `.env`
* Update the `.env` file with the database configurations
* Run in terminal `find . -type d -exec chmod 755 {} \;`
* Run in terminal `find . -type f -exec chmod 644 {} \;`
* Run in terminal `chmod -R 777 storage bootstrap/cache`
* Run in terminal `php artisan key:generate`
* Run in terminal `php artisan storage:link`
* Run in terminal `php artisan migrate:refresh --seed`

## Authors

[Florian Stancioiu](https://github.com/FlorianStancioiu)

## License

The 9Laravel application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
