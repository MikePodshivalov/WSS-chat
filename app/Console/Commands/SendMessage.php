<?php

namespace App\Console\Commands;

use App\Events\MessageWasReceived;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:message {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send chat message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::query()->first();
        $message = Message::create([
            'message' => 'message',
            'user_id' => $user->id,
            'room_id' => 1,
        ]);
        event(new MessageWasReceived($message, $user));
        return 0;
    }
}
