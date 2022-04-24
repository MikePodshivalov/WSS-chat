<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class MessageController extends Controller
{
    public function index(Request $request)
    {
        $room_id = $request->room_id;
        $message = Message::query()
            ->where('room_id', $room_id)
            ->latest()
            ->get(['message', 'created_at'])
            ->toArray();
        $data = [
          'user' => Auth::user()->name,
          'room_id' => $room_id,
          'messages' => $message,
        ];
        Room::addUserToRoom($room_id, Auth::user()->id);
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
                'created' => $result->created_at->toDateTimeString(),
            ], 201);
        } else {
            return false;
        }

    }
}
