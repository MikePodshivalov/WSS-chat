<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
