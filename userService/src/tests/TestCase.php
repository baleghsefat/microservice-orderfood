<?php

namespace Tests;

use App\Events\LoginEvent;
use Illuminate\Support\Facades\Event;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([
            LoginEvent::class,
        ]);

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
}
