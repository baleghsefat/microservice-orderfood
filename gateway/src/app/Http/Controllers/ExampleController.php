<?php

namespace App\Http\Controllers;

use App\Events\ExampleEvent;
use App\Jobs\ExampleJob;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ExampleController extends Controller
{
    public function index()
    {
        $connection = new AMQPStreamConnection('172.28.0.1', 5672, 'guest', 'guest');
//dd('asd');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        $msg = new AMQPMessage('Hello asdsWorld!');
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";

        $channel->close();
        $connection->close();
        dd('as');
        $this->dispatch(new ExampleJob());
        event(ExampleEvent::class);
    }
}
