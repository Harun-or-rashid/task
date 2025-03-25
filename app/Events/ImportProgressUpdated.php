<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportProgressUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $current;
    public $total;

    public function __construct($current, $total)
    {
        $this->current = $current;
        $this->total = $total;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('employee-import-progress'),
        ];
    }

    public function broadcastAs()
    {
        return 'import-progress-updated';
    }
}
