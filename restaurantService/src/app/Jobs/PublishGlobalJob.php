<?php

namespace App\Jobs;

use App\Traits\RabbitMQ\PublishTrait;

class PublishGlobalJob extends Job
{
    use PublishTrait;

    public array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data Data.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->publishGlobalEvent($this->data);
    }
}
