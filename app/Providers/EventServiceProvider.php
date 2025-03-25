<?php

namespace App\Providers;

use App\Events\SalaryUpdated;
use App\Listeners\LogSalaryUpdate;
use App\Events\EmployeeImportStarted;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SalaryUpdated::class => [
            LogSalaryUpdate::class,
        ],
        EmployeeImportStarted::class => [
            \App\Listeners\HandleEmployeeImport::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
