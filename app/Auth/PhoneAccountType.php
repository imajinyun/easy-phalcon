<?php

namespace App\Auth;

use App\Traits\FieldTrait;
use App\Model\System\ApiAuth;
use App\Service;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\Manager;
use Phalcon\Di;

class PhoneAccountType implements AccountTypeInterface
{
    use FieldTrait;

    public const NAME = 'phone';

    /**
     * Use phone login.
     *
     * @param array $data
     *
     * @return string
     */
    public function login(array $data) : string
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Service::SECURITY);
        $phone = $data[Manager::LOGIN_USERNAME];
        $password = $data[Manager::LOGIN_PASSWORD];
        $phone = self::encrypt($phone);
        $bindParams = ['phone' => $phone, 'isDelete' => '2'];
        $user = ApiAuth::findFirst([
            'columns'    => (new ApiAuth())->columnMap(),
            'conditions' => 'phone=:phone: AND isDelete=:isDelete:',
            'limit'      => 1,
            'bind'       => $bindParams,
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
