<?php

namespace App\Provider;

use App\Auth\EmailAccountType;
use Nilnice\Phalcon\Provider\AbstractServiceProvider;

/**
 * @property
 */
class JWTServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    protected $name = 'jwt';

    /**
     * @param null $parameter
     *
     * @throws \Nilnice\Phalcon\Exception\InvalidTokenException
     */
    public function register($parameter = null): void
    {
        /** @var \Nilnice\Phalcon\Application $app */
        $app = $this->getDI()->getShared('application');

        /** @var \Nilnice\Phalcon\Http\Request $request */
        $request = $app->getApp()->request;
        $token = $request->getToken();

        if ($token) {
            /** @var \Nilnice\Phalcon\Auth\JWTAuth $auth */
            $auth = $this->getDI()->getShared('auth');
            $auth->authenticateToken($token);
        }
    }
}
