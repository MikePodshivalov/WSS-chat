<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;

class SendController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $message = [
            'message' => $request->message,
        ];
        \App\Events\ChatEvent::dispatch(new ChatEvent($request->message));
//        response()->json(['status' => 'ok'], 200);
    }
}
