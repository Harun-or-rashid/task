<?php
namespace App\Events;

use App\Models\Admin;
use Log;
use Exception;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmployeeImportStatus;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeImportStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('employee-import-channel'),
        ];
    }

    public function handle()
    {
        try {
            // Read and decode the JSON file
            $employees = json_decode(Storage::get($this->file), true);
            $totalEmployees = count($employees);
            $currentEmployee = 0;

            // Process each employee
            foreach ($employees as $employee) {
                $existingEmployee = User::where('email', $employee['email'])->first();

                if (!$existingEmployee) {
                    // If the employee doesn't exist, create a new user
                    User::create($employee);
                } else {
                    Log::info('Employee with email ' . $employee['email'] . ' already exists.');
                }

                $currentEmployee++;
                event(new ImportProgressUpdated($currentEmployee, $totalEmployees));
            }

            $fallbackAdmin = Admin::where('email', 'admin@admin.com')->first();

            if ($fallbackAdmin) {
                Notification::send($fallbackAdmin, new EmployeeImportStatus('Import completed successfully.'));
            } else {
                Log::error('No fallback admin to send notification to.');
            }

        } catch (Exception $e) {
            Log::error('Error importing employees: ' . $e->getMessage());

            $fallbackAdmin = Admin::where('email', 'admin@admin.com')->first(); // Admin table fallback

            if ($fallbackAdmin) {
                Notification::send($fallbackAdmin, new EmployeeImportStatus('Import failed. Please try again.'));
            } else {
                Log::error('No fallback admin to send failure notification to.');
            }
        }
    }
}
