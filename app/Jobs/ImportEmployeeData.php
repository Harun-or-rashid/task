<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use App\Events\ImportProgressUpdated;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmployeeImportStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ImportEmployeeData implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        try {
            $employees = json_decode(Storage::get($this->file), true);
            $totalEmployees = count($employees);
            $currentEmployee = 0;

            $employeeData = [];

            foreach ($employees as $employee) {
                $existingEmployee = User::where('email', $employee['email'])->first();

                if (!$existingEmployee) {
                    $employeeData[] = [
                        'organization_id' => $employee['organization_id'],
                        'team_id' => $employee['team_id'],
                        'name' => $employee['name'],
                        'email' => $employee['email'],
                        'salary' => $employee['salary'],
                        'start_date' => $employee['start_date'],
                        'description' => $employee['description'],
                        'password' => Hash::make('default_password'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    Log::info('Duplicate email found: ' . $employee['email']);
                }

                $currentEmployee++;

                if ($currentEmployee % 50 == 0) {
                    event(new ImportProgressUpdated($currentEmployee, $totalEmployees));
                }
            }

            if (!empty($employeeData)) {
                User::insert($employeeData);
            }

            $this->sendNotification('Import completed successfully.');

        } catch (Exception $e) {
            Log::error('Error importing employees: ' . $e->getMessage());
            $this->sendNotification('Import failed. Please try again.');
        }
    }

    private function sendNotification($message)
    {
        $fallbackAdmin = Admin::where('email', 'admin@admin.com')->first();

        if ($fallbackAdmin) {
            Notification::send($fallbackAdmin, new EmployeeImportStatus($message));
        } else {
            Log::error('No fallback admin to send notification to.');
        }
    }
}
