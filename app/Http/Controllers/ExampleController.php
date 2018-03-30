<?php

namespace App\Http\Controllers;

use Nilnice\Phalcon\Http\Response;

class ExampleController extends AbstractController
{
    /**
     * Default action.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function indexAction(): Response
    {
        $array = [1, 2, 3, 4, 5];

        return $this->successResponse('This is a sample', $array);
    }
}
