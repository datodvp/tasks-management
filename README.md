# Instrutcions for running development mode

## Laravel / VueJs / InertiaJs

Copy .env.example file to .env <br/>
For ubuntu use
```
cp .env.example .env
```
next
```
composer install
```
next
```
npm install
```
next
```
php artisan key:generate
```
**Configure MYSQL:**

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***


next
```
npm run dev
php artisan serve
```


## You are ready 😲
