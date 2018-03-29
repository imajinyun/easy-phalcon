<?php

namespace App\Http\Routes;

class ApiAuthRouter extends AbstractRouter
{
    public function initialize()
    {
        $this->setPaths(['controller' => 'ApiAuth']);
        $this->setPrefix('/api/v1/auth');

        // Default page.
        $this->addGet('/', ['action' => 'index'])
            ->setName('index');

        // Create user.
        $this->addPost('/register', ['action' => 'create'])
            ->setName('create');

        // Update user.
        $this->addPut('/update', ['action' => 'update'])
            ->setName('update');

        // User list.
        $this->addGet('/list', ['action' => 'list'])
            ->setName('list');

        // Remove list.
        $this->addDelete('/{id}', ['action' => 'delete'])
            ->setName('delete');

        // User authorize.
        $this->addPost('/authorize', ['action' => 'authorize'])
            ->setName('authorize');

        // User authorize information.
        $this->addGet('/detail', ['action' => 'detail'])
            ->setName('detail');
    }
}
