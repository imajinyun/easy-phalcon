<?php

namespace App\Auth;

use App\Model\System\ApiAuth;
use App\Service;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\Manager;
use Phalcon\Di;

class UsernameAccountType implements AccountTypeInterface
{
    public const NAME = 'username';

    /**
     * Use username login.
     *
     * @param array $data
     *
     * @return null|string
     */
    public function login(array $data) : ? string
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Service::SECURITY);
        $username = $data[Manager::LOGIN_USERNAME];
        $password = $data[Manager::LOGIN_PASSWORD];

        $user = ApiAuth::findFirst([
            'conditions' => 'username = :username:',
            'bind'       => ['username' => $username],
        ]);

        if (! $user) {
            return '-1';
        }

        if (! $security->checkHash($password, $user->getPassword())) {
            return '-2';
        }

        if (! $user->getIsUsable()) {
            return '-3';
        }

        return (string)$user->getId();
    }

    /**
     * Auth authenticate.
     *
     * @param string $identity
     *
     * @return bool
     */
    public function authenticate(string $identity) : bool
    {
        $count = ApiAuth::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
