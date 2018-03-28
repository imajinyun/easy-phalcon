<?php

namespace App\Validation\Validator;

use App\Model\System\ApiAuth;
use App\Traits\FieldTrait;
use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MainlandPhoneValidator extends Validator
{
    use FieldTrait;

    /**
     * Mainland phone validator.
     *
     * @param \Phalcon\Validation $validation
     * @param string              $attribute
     *
     * @return bool
     */
    public function validate(Validation $validation, $attribute): bool
    {
        $value = $validation->getValue($attribute);
        $data = [
            'id'    => $this->getOption('id'),
            'phone' => $value,
        ];

        if (self::isMainlandPhoneExist($data)) {
            $message = $this->getOption('message');

            if (! $message) {
                $message = '邮箱已经存在';
            }
            $validation->appendMessage(
                new Message($message, $attribute, 'email')
            );

            return false;
        }

        return true;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public static function isMainlandPhoneExist(array $data): bool
    {
        $conditions = ' 1 ';
        $bind = [];
        ['id' => $id, 'phone' => $phone] = $data;

        if ($id) {
            $conditions .= 'AND id <> :id:';
            $bind['id'] = $id;
        }

        if ($phone) {
            $phone = self::decrypt($phone);
            $conditions .= 'AND phone = :phone:';
            $bind['phone'] = $phone;
        }
        $count = ApiAuth::count(['conditions' => $conditions, 'bind' => $bind]);

        return $count > 0;
    }
}
