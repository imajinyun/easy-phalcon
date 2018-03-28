<?php

/**
 * Use the DS to separate the directories in other defines.
 */
if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * The full path to the directory which holds "src", without a trailing DS.
 */
define('ROOT_DIR', dirname(__DIR__) . DS);

/**
 * Path to the application's directory.
 */
define('APP_DIR', ROOT_DIR . 'app' . DS);

/**
 * Path to the config directory.
 */
define('CONFIG_DIR', ROOT_DIR . 'config' . DS);

/**
 * Path to the routes directory.
 */
define('ROUTE_DIR', ROOT_DIR . 'routes' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_DIR', ROOT_DIR . 'public' . DS);

/**
 * Path to the temporary files directory.
 */
define('STORAGE_DIR', ROOT_DIR . 'storage' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS_DIR', STORAGE_DIR . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a
 * multi-server setup.
 */
define('CACHE_DIR', STORAGE_DIR . 'cache' . DS);
