<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Events\RoomEnteredEvent;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MessagesController extends Controller
{
    /**
     * @param Request $request
     * @param Message $message
     * @return JsonResponse
     */
    public function fetchMessages(Request $request, Message $message) : JsonResponse
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

    /**
     * @param Request $request
     * @return false|JsonResponse
     */
    public function store(Request $request) : JsonResponse|false
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
            broadcast(new MessageSentEvent($message->room_id, $request->user(), $message->message, $message->created_at))->toOthers();
            return Response::json([
                'message' => $message->message,
                'user' => $request->user()->name,
                'room_id' => $message->room_id,
                'created_at' => $message->created_at,
            ], 201);
        } else {
            return false;
        }
    }
}
