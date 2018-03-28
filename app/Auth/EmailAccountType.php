<?php

namespace App\Auth;

use App\Exception\UserAccountException;
use App\Exception\UserNotFoundException;
use App\Model\System\ApiAuth;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\JWTAuth;
use Nilnice\Phalcon\Auth\Manager;
use Phalcon\Di;

class EmailAccountType implements AccountTypeInterface
{
    public const NAME = 'email';

    /**
     * Use email login.
     *
     * @param array $data
     *
     * @return string
     *
     * @throws \App\Exception\ErrorHandler
     */
    public function login(array $data): string
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get('security');
        $email = $data[JWTAuth::LOGIN_USERNAME];
        $password = $data[JWTAuth::LOGIN_PASSWORD];
        $bindParams = ['email' => $email];

        /** @var \App\Model\System\ApiAuth $auth */
        $auth = ApiAuth::findFirst([
            'conditions' => 'email=:email:',
            'limit'      => 1,
            'bind'       => $bindParams,
        ]);

        if (! $auth) {
            throw new UserAccountException('The user account not exist');
        }

        if (! $security->checkHash($password, $auth->getPassword())) {
            throw new UserAccountException('The user password man be wrong');
        }

        if (! $auth->isUsable()) {
            throw new UserAccountException('The user may be locked up');
        }

        return $auth->getId();
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
