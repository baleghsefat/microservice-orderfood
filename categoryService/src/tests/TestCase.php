<?php

namespace Tests;

use App\Jobs\PublishGlobalJob;
use Illuminate\Support\Facades\Bus;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake([PublishGlobalJob::class]);

        $this->artisan('migrate:fresh');
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    /**
     * @return string[]
     */
    public function authHeader(): array
    {
        return [
            'Authorization' => 'Bearer ' . generateJwt(['role' => 'admin']),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
