<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Events\MyNewEvent;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoomController extends Controller
{
    public function exitUserFromRoom(Request $request, Room $room)
    {
        $room_id = $request->room_id;
        $user_id = Auth::user()->id;
        $response = $room->exitUserFromRoom($room_id, $user_id);
        return Response::json($response, 200);
    }
}
