<?php

namespace App\Model;

trait ModelTrait
{
    public function beforeCreate()
    {
        $datetime = datetime();

        if (property_exists($this, 'created')) {
            $this->setCreated($datetime);
        }

        if (property_exists($this, 'modified')) {
            $this->setModified($datetime);
        }

        if (property_exists($this, 'isUsable') && ! $this->isUsable()) {
            $this->setIsUsable();
        }

        if (property_exists($this, 'isDelete') && ! $this->isDelete()) {
            $this->setIsDelete();
        }
    }

    public function beforeUpdate()
    {
        $this->setModified(datetime());
    }
}
