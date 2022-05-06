<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Laravel\Lumen\Application;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->registerCommands();
    }

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    /**
     * @return void
     */
    private function registerCommands(): void
    {
        foreach (File::allFiles(__DIR__ . '/Commands') as $command) {
            $className = 'App\Console\Commands\\' . str_replace('.php', '', $command->getRelativePathname());
            $className = str_replace('/', '\\', $className);

            $this->commands[] = $className;
        }
    }
}
