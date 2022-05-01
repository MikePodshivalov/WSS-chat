<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'room_id',
    ];

    /**
     * Столбец created_at в формате H:i:s.
     *
     * @param  string  $value
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  Carbon::parse($value)->setTimezone('Europe/Moscow')->format('H:i:s'),
        );
    }

    public function fetchMessages($roomId)
    {
        return $this->query()
            ->where('room_id', $roomId)
            ->where('created_at', '>', Carbon::now()->subMinutes((int)config('message.N'))->toDateTimeString())
            ->with('user')
            ->get();
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
