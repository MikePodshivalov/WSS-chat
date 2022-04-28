<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Private channel. You can write channel name without prefix $
Broadcast::channel('private:channel', function (){
    // Some auth logic for example:
    return \Auth::user()->group === 'private-channel-group';
});

// Public channel
Broadcast::channel('public:channel', function (){
    return true;
});


//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
//
//Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
//    if ($user->canJoinRoom($roomId)) {
//        return ['id' => $user->id, 'name' => $user->name];
//    }
//});

Broadcast::channel('messages', function ($user, $id) {
    return true;
});

Broadcast::channel('news', function ($user) {
    return true;
});






//Broadcast::channel('everywhere', function ($user) {
//    return $user;
//});
//
//Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
//    return $user;
//});
