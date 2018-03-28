<?php

namespace App\Http\Controllers;

use App\Model\System\ApiAuth;

class ExampleController extends AbstractController
{
    public function indexAction()
    {
        $object = ApiAuth::find();
        $array = $object->toArray();

        return $this->successResponse('au', $array);
    }
}
