<?php

namespace App\Traits\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

trait PublishTrait
{
    public function publishGlobalEvent(array $message)
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        $channel->exchange_declare('user', 'fanout', false, false, false);

        $msg = new AMQPMessage(json_encode($message));

        $channel->basic_publish($msg, 'user');

        $channel->close();
        $connection->close();
    }
}
