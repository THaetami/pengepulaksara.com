# project laravel9, vite, vuejs

website => https://pengepulaksara.com

## Project Setup

```sh
copy .env.example file to .env, edit database credentials and OAuth Apps (Github) credentials there
```

```sh
composer install
```

```sh
php artisan migrate
```

```sh
npm install
```

### if not using Laravel Valet

```sh
composer install
```

```sh
run composer dump-autoload if the autoload.php file is missing
```

```sh
php artisan key:generate
```

```sh
php artisan serve
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```
