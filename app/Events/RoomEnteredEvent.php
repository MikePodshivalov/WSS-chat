<?php

namespace App\Events;

use App\Models\Room;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomEnteredEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The name of the queue on which to place the event
     */
    public $broadcastQueue = 'events:room-joined';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user, public $roomId)
    {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.' . $this->roomId);
    }

    /**
     * The event's broadcast name
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'room.joined';
    }
}
