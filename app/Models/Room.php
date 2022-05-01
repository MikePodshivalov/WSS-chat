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

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function addUserToRoom(User $user, Room $room)
    {
        return DB::table('room_user')->insert(
            ['user_id' => $user->id, 'room_id' => $room->id,]
        );
    }

    public function exitUserFromRoom(int $room_id, int $user_id)
    {
        return DB::table('room_user')->where([
            ['room_id', $room_id],
            ['user_id', $user_id],
        ])->delete();
    }

    public function listOfRoomsUserEntered(int $userId) : array
    {
        return DB::table('room_user')->where('user_id', $userId)->pluck('room_id')->toArray();
    }
}
