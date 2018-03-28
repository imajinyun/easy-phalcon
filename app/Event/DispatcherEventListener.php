<?php

namespace App\Event;

use Phalcon\Events\Event;

class DispatcherEventListener
{
    public function beforeException(Event $event, $dispatcher, $e)
    {
    }
}
