<?php

namespace App\Validation;

use App\Validation\Validator\MainlandPhoneValidator;
use App\Validation\Validator\AuthEmailValidator;
use Illuminate\Support\Arr;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class AuthValidation extends Validation
{
    public function initialize()
    {
        $this->add('email', new PresenceOf([
            'message' => '邮箱地址必须填写',
        ]));

        $this->add('username', new PresenceOf([
            'message' => '用户名称必须填写',
        ]));
    }

    /**
     * @param array|null $array
     */
    public function createValidate(array $array = null): void
    {
        $email = Arr::get($array, 'email');

        $this->add('password', new PresenceOf([
            'message' => '用户密码必须填写',
        ]));

        $this->add('email', new Email([
            'message' => '邮箱地址格式有误',
        ]));

        $this->add('email', new AuthEmailValidator([
            'email'   => $email,
            'message' => '邮箱地址已经存在',
        ]));
    }

    /**
     * @param array|null $array
     */
    public function updateValidate(array $array = null): void
    {
        $id = Arr::get($array, 'id');
        $email = Arr::get($array, 'email');

        $this->add('email', new AuthEmailValidator([
            'id'      => $id,
            'email'   => $email,
            'message' => '邮箱已经存在',
        ]));
    }
}
