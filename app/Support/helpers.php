<?php

if (! function_exists('json')) {
    /**
     * Returns an JSON string of information about a single variable.
     *
     * @param mixed $args
     */
    function json($args)
    {
        echo (new \Phalcon\Debug\Dump())->toJson($args);
        exit(1);
    }
}

if (! function_exists('uuid')) {
    /**
     * Generate UUID.
     *
     * @return mixed
     *
     * @throws \Phalcon\Security\Exception
     */
    function uuid()
    {
        $security = new \Phalcon\Security();
        $random = $security->getRandom();

        return str_replace('-', '', $random->uuid());
    }
}

if (! function_exists('datetime')) {
    /**
     * Format datetime.
     *
     * @param string $format
     * @param int    $timestamp
     *
     * @return string
     */
    function datetime(
        string $format = 'Y-m-d H:i:s',
        int $timestamp = 0
    ): string {
        if ($timestamp > 0) {
            return date($format, $timestamp);
        }

        return date($format);
    }
}

if (! function_exists('logger')) {
    /**
     * Record application running log.
     *
     * @param            $msg
     * @param int        $type
     * @param string     $name
     * @param array|null $context
     *
     * @throws \RuntimeException
     */
    function logger(
        $msg,
        $type = \Phalcon\Logger::INFO,
        $name = '',
        array $context = null
    ) {
        $logger = function ($func = 'info', $name = '') use ($msg, $context) {
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $formatter = LOGS_DIR . '%s/%s/%s/%s.log';
            $path = sprintf($formatter, $y, $m, $d, $name ?: $func);

            if (! file_exists($path)) {
                $class = \Symfony\Component\Filesystem\Filesystem::class;
                if (class_exists($class)) {
                    $Filesystem
                        = new \Symfony\Component\Filesystem\Filesystem();
                    $Filesystem->mkdir(dirname($path));
                } else {
                    throw new \RuntimeException("$class cannot be loaded.");
                }
            }
            $Logger = new \Phalcon\Logger\Adapter\File($path);
            $Logger->{$func}($msg, $context);
        };

        switch ($type) {
            case 0:
                $logger('emergence', $name);
                break;
            case 1:
                $logger('critical', $name);
                break;
            case 2:
                $logger('alert', $name);
                break;
            case 3:
                $logger('error', $name);
                break;
            case 4:
                $logger('warning', $name);
                break;
            case 5:
                $logger('notice', $name);
                break;
            case 7:
                $logger('debug', $name);
                break;
            default:
                $logger('info', $name);
                break;
        }
    }
}
