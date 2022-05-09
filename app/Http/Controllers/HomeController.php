<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Room $room) : Renderable
    {
        $userName = Auth::user()->name;
        $rooms = Room::all();
        return view('home', compact('userName', 'rooms'));
    }
}
