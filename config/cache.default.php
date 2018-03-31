<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */
    'default'     => env('CACHE_DRIVER', 'redis'),

    /*
    |--------------------------------------------------------------------------
    | Cache Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */
    'connections' => [

        /*
        |--------------------------------------------------------------------------
        | Redis Connection
        |--------------------------------------------------------------------------
        |
        |
        */
        'redis' => [
            'driver'  => 'cluster',
            'default' => [
                'backend'    => \Phalcon\Cache\Backend\Redis::class,
                'frontend'   => \Phalcon\Cache\Frontend\Data::class,
                'connection' => env('CACHE_REDIS_CONNECTION', 'default'),
                'lifetime'   => 172800,
                'options'    => [
                    'host'       => '127.0.0.1',
                    'port'       => 6379,
                    'auth'       => '',
                    'index'      => 0,
                    'prefix'     => '',
                    'persistent' => false,
                ],
            ],
            'cluster' => [
                'client'  => \Predis\Client::class,
                'servers' => [
                    'tcp://127.0.0.1:6381',
                    'tcp://127.0.0.2:6382',
                    'tcp://127.0.0.2:6383',
                ],
                'options' => [
                    'prefix'   => '',
                    'password' => '',
                ],
            ],
        ],
    ],

];
