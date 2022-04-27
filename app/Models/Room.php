<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    static public function addUserToRoom(int $room_id, int $user_id)
    {
        return DB::table('room_user')->insert(
            ['room_id' => $room_id, 'user_id' => $user_id]
        );
    }

    static public function exitUserFromRoom(int $room_id, int $user_id)
    {
        return DB::table('room_user')->where([
            ['room_id', $room_id],
            ['user_id', $user_id],
        ])->delete();
    }

    static public function listOfRoomsUserEntered(int $userId) : array
    {
        return DB::table('room_user')->where('user_id', $userId)->pluck('room_id')->toArray();
    }
}
