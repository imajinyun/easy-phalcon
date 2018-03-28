<?php

namespace App\Provider;

use Nilnice\Phalcon\Provider\AbstractServiceProvider;
use Phalcon\Loader;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    protected $name = 'app';

    /**
     * @param mixed|null $parameter
     */
    public function register($parameter = null): void
    {
        // TODO: do something...
    }
}
