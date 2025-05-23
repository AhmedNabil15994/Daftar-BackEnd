<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('stock:outstock')->timezone('Asia/Kuwait')->at('12:00');
            $schedule->command('stock:underlimit')->timezone('Asia/Kuwait')->at('12:00');
            $schedule->command('telescope:prune')->daily();
            $schedule->command('telescope:clear')->daily();
            $schedule->command('order:update')->everyMinute();
        });
    }

    public function register()
    {

    }
}
