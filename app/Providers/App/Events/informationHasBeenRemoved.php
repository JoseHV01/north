<?php

namespace App\Providers\App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class informationHasBeenRemoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id, $table, $resultQueryOperation;

    public function __construct($id, $table, $resultQueryOperation)
    {
        $this->id = $id;
        $this->table = $table;
        $this->resultQueryOperation = $resultQueryOperation;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
