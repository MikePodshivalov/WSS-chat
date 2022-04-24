<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = Message::query()
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->select('message', 'users.name', 'room_id', 'messages.created_at')
            ->get();
        $userName = Auth::user()->name;
        $rooms = Room::all();
        return view('home', compact('userName', 'rooms', 'messages'));
    }
}
