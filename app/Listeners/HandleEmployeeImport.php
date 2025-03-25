<?php

namespace App\Listeners;

use App\Jobs\ImportEmployeeData;
use App\Events\EmployeeImportStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleEmployeeImport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmployeeImportStarted $event): void
    {
        ImportEmployeeData::dispatch($event->file);
    }
}
