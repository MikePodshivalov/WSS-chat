<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    /**
     * The queue on which to broadcast the event
     */
    public $broadcastQueue = 'events:message-created';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $roomId, public User $user, public $message, public $created_at)
    {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.'. $this->roomId);
    }
}
