<?php

namespace App\Auth;

use App\Exception\UserAccountException;
use App\Model\System\ApiAuth;
use App\Support\Security;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\JWTAuth;
use Phalcon\Di;

class PhoneAccountType implements AccountTypeInterface
{
    public const NAME = 'phone';

    /**
     * Use phone login.
     *
     * @param array $data
     *
     * @return string
     *
     * @throws \App\Exception\UserAccountException
     */
    public function login(array $data): string
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get('security');
        $phone = $data[JWTAuth::LOGIN_USERNAME];
        $password = $data[JWTAuth::LOGIN_PASSWORD];
        $phone = Security::encrypt($phone);
        $bindParams = ['phone' => $phone, 'isDelete' => '2'];

        /** @var \App\Model\System\ApiAuth $auth */
        $auth = ApiAuth::findFirst([
            'conditions' => 'phone=:phone: AND isDelete=:isDelete:',
            'limit'      => 1,
            'bind'       => $bindParams,
        ]);

        if (! $auth) {
            throw new UserAccountException('The user account not exist', 400);
        }

        if (! $security->checkHash($password, $auth->getPassword())) {
            throw new UserAccountException('The user password error', 400);
        }

        if (! $auth->isUsable()) {
            throw new UserAccountException('The user is locked', 400);
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
