<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class MessageController extends Controller
{
    public function index(Request $request)
    {
        return Response::json(['response' => $request->toArray()], 200);
    }
}
