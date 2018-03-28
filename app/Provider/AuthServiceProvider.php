<?php

namespace App\Provider;

use App\Auth\EmailAccountType;
use Nilnice\Phalcon\Auth\JWTAuth;
use Nilnice\Phalcon\Provider\AbstractServiceProvider;

/**
 * @method JWTAuth loginWithUsernamePassword(string $type, string $username, string $password): array
 * @method JWTAuth getToken(): ?Token
 * @method JWTAuth authenticateToken(string $token): bool
 */
class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    protected $name = 'auth';

    /**
     * @param mixed|null $parameter
     *
     * @return void
     */
    public function register($parameter = null): void
    {
        $di = $this->getDI();
        $di->setShared($this->getName(), function () {
            $auth = new JWTAuth(3600);
            $auth->registerAccountType(
                EmailAccountType::NAME,
                new EmailAccountType()
            );

            return $auth;
        });
    }
}
