<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    |
    */
    'connections' => [

        /*
        |--------------------------------------------------------------------------
        | Test Database Configuration
        |--------------------------------------------------------------------------
        |
        |
        */
        'test_database' => [
            'test_master' => [
                'host'     => 'localhost',
                'port'     => 3306,
                'dbname'   => '',
                'charset'  => 'utf8',
                'username' => '',
                'password' => '',
            ],
            'test_slave'  => [
                'host'     => 'localhost',
                'port'     => 3307,
                'dbname'   => '',
                'charset'  => 'utf8',
                'username' => '',
                'password' => '',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Demo Database Configuration
        |--------------------------------------------------------------------------
        |
        |
        */
        'demo_database' => [
            'demo_master' => [
                'host'     => 'localhost',
                'port'     => 3306,
                'dbname'   => '',
                'charset'  => 'utf8',
                'username' => '',
                'password' => '',
            ],
            'demo_slave'  => [
                'host'     => 'localhost',
                'port'     => 3307,
                'dbname'   => '',
                'charset'  => 'utf8',
                'username' => '',
                'password' => '',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Other Database Configuration
        |--------------------------------------------------------------------------
        |
        |
        */
    ],

];
