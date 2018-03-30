<?php

namespace App\Http\Controllers;

use Nilnice\Phalcon\Http\Response;

class NotFoundController extends AbstractController
{
    /**
     * Not found action.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function notFoundAction(): Response
    {
        $content = [
            'code'    => 200404,
            'message' => '404 Not Found',
            'error'   => $this->dispatcher->getParams(),
        ];

        $this->response
            ->setStatusCode(400, 'Not Found')
            ->setJsonContent($content);

        return $this->response;
    }
}
