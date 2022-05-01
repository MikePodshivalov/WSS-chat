<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\MessageSentEvent;
use App\Events\RoomEnteredEvent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class MessagesController extends Controller
{
    public function fetchMessages(Request $request, Room $room, Message $message)
    {
        $request->validate([
            'room_id' => 'required|integer',
        ]);

        $roomId = $request->room_id;

        $responseData = [
          'user' => $request->user()->name,
          'room_id' => $roomId,
          'messages' => $message->fetchMessages($roomId),
        ];

        event(new RoomEnteredEvent($request->user(), $roomId));

        return Response::json($responseData, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'message' => 'required',
        ]);

        $message = Message::query()->create([
            'message' => $request->get('message'),
            'user_id' => $request->user()->id,
            'room_id' => $request->get('room_id')
        ]);

        if ($message) {
            broadcast(new MessageSentEvent($request->get('room_id'), $request->user(), $request->get('message'), $message->created_at))->toOthers();
            return Response::json([
                'message' => $request->get('message'),
                'user' => $request->user()->name,
                'room_id' => $request->get('room_id'),
                'created_at' => $message->created_at,
            ], 201);
        } else {
            return false;
        }
    }
}
