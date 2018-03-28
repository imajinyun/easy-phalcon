<?php

namespace App\Model\System;

use Phalcon\Mvc\Model;

class ApiRole extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $apiIds;

    /**
     * @var bool
     */
    protected $isUsable;

    /**
     * @var bool
     */
    protected $isDelete;

    /**
     * @var string
     */
    protected $created;

    /**
     * @var int
     */
    protected $creatorId;

    /**
     * @var string
     */
    protected $modified;

    /**
     * @var int
     */
    protected $modifierId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getApiIds(): string
    {
        return $this->apiIds;
    }

    /**
     * @param string $apiIds
     */
    public function setApiIds(string $apiIds): void
    {
        $this->apiIds = $apiIds;
    }

    /**
     * @return bool
     */
    public function isUsable(): ? bool
    {
        return $this->isUsable;
    }

    /**
     * @param bool $isUsable
     *
     * @return \App\Model\System\ApiRole
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
        return $this->isDelete;
    }

    /**
     * @param bool $isDelete
     *
     * @return \App\Model\System\ApiRole
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
     * @return \App\Model\System\ApiRole
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
     * @return \App\Model\System\ApiRole
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
     * @return \App\Model\System\ApiRole
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
     * @return \App\Model\System\ApiRole
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
        $this->setSource('sc_api_roles');
        $this->setReadConnectionService('system_master');
        $this->setWriteConnectionService('system_slave');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource(): string
    {
        return 'sc_api_roles';
    }

    /**
     * @param mixed $parameters
     *
     * @return \App\Model\System\ApiRole[]|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     *
     * @return \App\Model\System\ApiRole[]|\Phalcon\Mvc\Model
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
            'id'          => 'id',
            'name'        => 'name',
            'description' => 'description',
            'identify'    => 'identify',
            'api_ids'     => 'apiIds',
            'is_usable'   => 'isUsable',
            'is_delete'   => 'isDelete',
            'created'     => 'created',
            'creator_id'  => 'creatorId',
            'modified'    => 'modified',
            'modifier_id' => 'modifierId',
        ];
    }
}
