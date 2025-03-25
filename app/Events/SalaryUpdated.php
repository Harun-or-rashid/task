<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalaryUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employeeId;
    public $oldSalary;
    public $newSalary;
    /**
     * Create a new event instance.
     */
    public function __construct($employeeId, $oldSalary, $newSalary)
    {
        $this->employeeId = $employeeId;
        $this->oldSalary = $oldSalary;
        $this->newSalary = $newSalary;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

}
