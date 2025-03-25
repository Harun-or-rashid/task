<?php
namespace App\Jobs;

use Exception;
use App\Models\User;
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
            // Read the JSON file content
            $employees = json_decode(Storage::get($this->file), true);
            $totalEmployees = count($employees);
            $currentEmployee = 0;

            $employeeData = [];

            foreach ($employees as $employee) {
                // Optionally check for duplicate emails
                if (!User::where('email', $employee['email'])->exists()) {
                    // Prepare data for bulk insert
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

                // Send progress update for every 50 records
                if ($currentEmployee % 50 == 0) {
                    event(new ImportProgressUpdated($currentEmployee, $totalEmployees));
                }
            }

            // Insert all employee data in bulk
            if (!empty($employeeData)) {
                User::insert($employeeData);
            }

            // Send notification to the user upon success
            $this->sendNotification('Import completed successfully.');

        } catch (Exception $e) {
            Log::error('Error importing employees: ' . $e->getMessage());
            $this->sendNotification('Import failed. Please try again.');
        }
    }

    private function sendNotification($message)
    {
        // Check if the user is authenticated
        $user = auth()->user();
        if ($user) {
            // Send notification to the user
            Notification::send($user, new EmployeeImportStatus($message));
        } else {
            Log::error('No authenticated user to send notification to.');
        }
    }
}
