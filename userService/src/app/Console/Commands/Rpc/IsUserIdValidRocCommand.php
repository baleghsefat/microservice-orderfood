<?php

namespace App\Console\Commands\Rpc;

use App\Models\User;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class IsUserIdValidRocCommand extends Command
{
    const QUEUE_NAME = 'user_id_validation';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpc:isUserIdValid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the user is valid.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TODO refactor
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        $channel->queue_declare(self::QUEUE_NAME, false, false, false, false);

        $this->info("\n" . '********** Awaiting RPC requests **********' . "\n");

        $callback = function ($req) {
            $msg = new AMQPMessage(
                $this->response(intval($req->body)),
                ['correlation_id' => $req->get('correlation_id')]
            );

            $req->delivery_info['channel']->basic_publish(
                $msg,
                '',
                $req->get('reply_to')
            );
            $req->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume(self::QUEUE_NAME, '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    private function response(int $userId): string
    {
        return json_encode(User::query()->where(User::ID, $userId)->exists());
    }
}
