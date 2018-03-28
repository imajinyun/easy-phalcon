<?php

require __DIR__ . '/../config/paths.php';
require_once ROOT_DIR . 'vendor/autoload.php';

try {
    (new \Dotenv\Dotenv(ROOT_DIR))->load();
} catch (\Dotenv\Exception\InvalidPathException $exception) {
    echo $exception->getMessage();
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
|
*/

$app = new \Nilnice\Phalcon\Application(ROOT_DIR);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
|
*/

// $app->register(new \App\Provider\AppServiceProvider($app->getDi()));
$app->register(new \App\Provider\AuthServiceProvider($app->getDi()));
$app->register(new \App\Provider\JWTServiceProvider($app->getDi()));

return $app;
