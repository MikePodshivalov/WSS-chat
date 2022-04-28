<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class MessageController extends Controller
{
    public function index(Request $request, Room $room)
    {
        $roomId = $request->room_id;
        $message = Message::query()
            ->where('room_id', $roomId)
            ->leftJoin('users', function($join) {
                $join->on('users.id', '=', 'messages.user_id');
            })->latest()
            ->get(['message', 'name', 'messages.created_at'])->toArray();

        $data = [
          'user' => Auth::user()->name,
          'room_id' => $roomId,
          'messages' => $message,
        ];
        $room->addUserToRoom($roomId, Auth::user()->id);
        return Response::json($data, 200);
    }

    public function store(Request $request)
    {

        $user_id = Auth::user()->id;
        $room_id = $request->room_id;
        $data = [
            'message' => $request->message,
            'user_id' => $user_id,
            'room_id' => $room_id,
        ];
        $result = Message::create($data);

        if ($result) {
            return Response::json([
                'message' => $request->message,
                'user' => Auth::user()->name,
                'room_id' => $room_id,
                'created_at' => $result->created_at,
            ], 201);
        } else {
            return false;
        }

    }
}
