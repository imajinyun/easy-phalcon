<?php

namespace App\Auth;

use App\Exception\UserAccountException;
use App\Model\System\ApiAuth;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\JWTAuth;
use Phalcon\Di;
use Phalcon\Mvc\Model;

class EmailAccountType implements AccountTypeInterface
{
    public const NAME = 'email';

    /**
     * Use email login.
     *
     * @param array $data
     *
     * @return \Phalcon\Mvc\Model
     *
     * @throws \App\Exception\UserAccountException
     */
    public function login(array $data): Model
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get('security');
        $email = $data[JWTAuth::LOGIN_USERNAME];
        $password = $data[JWTAuth::LOGIN_PASSWORD];
        $bindParams = ['email' => $email];

        /** @var \App\Model\System\ApiAuth $auth */
        $auth = config('auth.user.class');
        $auth = $auth::findFirst([
            'conditions' => 'email=:email:',
            'limit'      => 1,
            'bind'       => $bindParams,
        ]);

        if (! $auth) {
            throw new UserAccountException('The user account not exist', 404);
        }

        if (! $security->checkHash($password, $auth->getPassword())) {
            throw new UserAccountException('The user password error', 400);
        }

        if (! $auth->isUsable()) {
            throw new UserAccountException('The user is locked', 400);
        }

        return $auth;
    }

    /**
     * Auth authenticate.
     *
     * @param string $identity
     *
     * @return bool
     */
    public function authenticate(string $identity): bool
    {
        $count = ApiAuth::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
