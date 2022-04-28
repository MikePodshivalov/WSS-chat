<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoomsController extends Controller
{
    public function exitUserFromRoom(Request $request, Room $room)
    {
        $room_id = $request->room_id;
        $user_id = Auth::user()->id;
        $response = $room->exitUserFromRoom($room_id, $user_id);
        return Response::json($response, 200);
    }
}
