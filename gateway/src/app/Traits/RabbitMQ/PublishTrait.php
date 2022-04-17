<?php

namespace App\Traits\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

trait PublishTrait
{
    public function publish($message)
    {
//        dd($message);
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        $channel->exchange_declare('logs', 'fanout', false, false, false);

        $data = implode(' ', array_slice([], 1));
        if (empty($data)) {
            $data = "info: Hello World!";
        }
//        dd(json_encode((array)$message));
        $msg = new AMQPMessage(json_encode((array)$message));

        $channel->basic_publish($msg, 'logs');

        echo ' [x] Sent ', $data, "\n";

        $channel->close();
        $connection->close();
    }
}
