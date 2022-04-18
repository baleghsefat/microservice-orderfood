<?php

namespace App\Listeners;

use App\Events\Event;
use App\Traits\RabbitMQ\PublishTrait;

class PublishGlobalListener
{
    use PublishTrait;

    /**
     * @param Event $event Event.
     * @return void
     */
    public function handle(Event $event): void
    {
        $this->publishGlobalEvent($event->model->toArray());
    }
}
