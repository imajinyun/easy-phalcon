<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->addGet('/', 'Default::index');
$router->addGet('/info', 'Default::info');

$router->mount(new \App\Http\Routes\ApiAuthRouter());

return $router;
