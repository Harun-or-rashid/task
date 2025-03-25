<?php

namespace App\Listeners;

use App\Events\SalaryUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSalaryUpdate implements ShouldQueue {
    public function handle(SalaryUpdated $event)
    {
        // Log the salary update asynchronously
        Log::info('Salary updated for Employee ID ' . $event->employeeId . ': '
            . 'Old Salary: ' . $event->oldSalary . ', New Salary: ' . $event->newSalary);
    }
}
