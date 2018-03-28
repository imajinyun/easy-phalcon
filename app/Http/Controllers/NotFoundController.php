<?php

namespace App\Http\Controllers;

class NotFoundController extends AbstractController
{
    public function notFoundAction()
    {
        $content = [
            'code'    => 200404,
            'message' => '404 Not Found',
            'error'   => $this->dispatcher->getParams(),
        ];

        return $this
            ->response
            ->setStatusCode(404, 'Not Found')
            ->setJsonContent($content);
    }
}
