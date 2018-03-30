<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new \Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (\Dotenv\Exception\InvalidPathException $exception) {
    exit($exception->getMessage());
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
|
*/

$app = new \Nilnice\Phalcon\Application(__DIR__ . '/../');

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
