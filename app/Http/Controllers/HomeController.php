<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $userName = Auth::user()->name;
        $roomsEntered = Room::listOfRoomsUserEntered($userId);
        $rooms = Room::all();
        $messages = Message::query()
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->whereIn('room_id', $roomsEntered)
            ->select('message', 'users.name', 'room_id', 'messages.created_at')
            ->get();
        return view('home', compact('userName', 'roomsEntered', 'messages', 'rooms'));
    }
}
