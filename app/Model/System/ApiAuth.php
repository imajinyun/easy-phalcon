<?php

namespace App\Model\System;

use App\Model\ModelTrait;
use Phalcon\Mvc\Model;

class ApiAuth extends Model
{
    use ModelTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $roleId;

    /**
     * @var bool
     */
    protected $isUsable;

    /**
     * @var bool
     */
    protected $isDelete;

    /**
     * @var bool
     */
    protected $isVerifiedEmail;

    /**
     * @var string
     */
    protected $creatorId;

    /**
     * @var string
     */
    protected $created;

    /**
     * @var string
     */
    protected $modifierId;

    /**
     * @var string
     */
    protected $modified;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * @param string $appId
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setAppId(string $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->appSecret;
    }

    /**
     * @param string $appSecret
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setAppSecret(string $appSecret): self
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->roleId;
    }

    /**
     * @param string $roleId
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setRoleId(string $roleId = '1'): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerifiedEmail(): bool
    {
        return $this->isVerifiedEmail;
    }

    /**
     * @param bool $isVerifiedEmail
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setIsVerifiedEmail(bool $isVerifiedEmail = false): self
    {
        $this->isVerifiedEmail = $isVerifiedEmail;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUsable(): ? bool
    {
        return $this->isUsable === '1';
    }

    /**
     * @param bool $isUsable
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setIsUsable(bool $isUsable = true): self
    {
        $this->isUsable = $isUsable ? '1' : '2';

        return $this;
    }

    /**
     * @return bool
     */
    public function isDelete(): ? bool
    {
        return $this->isDelete === '2';
    }

    /**
     * @param bool $isDelete
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setIsDelete(bool $isDelete = false): self
    {
        $this->isDelete = $isDelete ? '1' : '2';

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    /**
     * @param string $creatorId
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setCreatorId(string $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @param string $created
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setCreated(string $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getModifierId(): string
    {
        return $this->modifierId;
    }

    /**
     * @param string $modifierId
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setModifierId(string $modifierId): self
    {
        $this->modifierId = $modifierId;

        return $this;
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return $this->modified;
    }

    /**
     * @param string $modified
     *
     * @return \App\Model\System\ApiAuth
     */
    public function setModified(string $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Initialize method for model.
     */
    public function initialize(): void
    {
        $this->setSource('sc_api_auths');
        $this->setReadConnectionService('systemMaster');
        $this->setWriteConnectionService('systemSlave');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource(): string
    {
        return 'sc_api_auths';
    }

    /**
     * Allows to query a set of records that match the specified conditions.
     *
     * @param mixed $parameters
     *
     * @return \App\Model\System\ApiAuth[]|ApiAuth|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions.
     *
     * @param mixed $parameters
     *
     * @return \App\Model\System\ApiAuth[]|\Phalcon\Mvc\Model
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     *
     * Keys are the real names in the table and the values their names in the
     * application.
     *
     * @return array
     */
    public function columnMap(): array
    {
        return [
            'id'                => 'id',
            'username'          => 'username',
            'password'          => 'password',
            'email'             => 'email',
            'app_id'            => 'appId',
            'app_secret'        => 'appSecret',
            'role_id'           => 'roleId',
            'is_usable'         => 'isUsable',
            'is_delete'         => 'isDelete',
            'is_verified_email' => 'isVerifiedEmail',
            'created'           => 'created',
            'creator_id'        => 'creatorId',
            'modified'          => 'modified',
            'modifier_id'       => 'modifierId',
        ];
    }
}
