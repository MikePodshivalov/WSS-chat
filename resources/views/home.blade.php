@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-content page-container border-dark" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-left">
                    @foreach($rooms as $room)
                        <div class="col-md-6 mb-2">
                            <div class="box box-warning direct-chat direct-chat-warning">
                                <div class="box-header with-border user-list">
                                    <h3 class="box-title list-group">Chat room {{$room->id}}</h3>

{{--                                        <span class="badge bg-yellow" >User1</span>--}}
{{--                                        <span class="badge bg-yellow" >User2</span>--}}
                                </div>

                                    <div class="box-body">
                                        <div id="room-{{$room->id}}" hidden>
                                            <div id="chat-messages-{{$room->id}}" class="direct-chat-messages">
                                                @foreach($messages as $message)
                                                    @if($message->room_id === $room->id)
                                                        @if($message->name === Auth::user()->name)
                                                            <div class="direct-chat-msg right">
                                                                <div class="direct-chat-info clearfix">
                                                                    <span class="direct-chat-name pull-right">{{$message->name}}</span>
                                                                    <span class="direct-chat-timestamp pull-left">{{$message->created_at}}</span>
                                                                </div>
                                                                <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">
                                                                <div class="direct-chat-text text-wrap">{{$message->message}}</div>
                                                            </div>
                                                        @else
                                                            <div class="direct-chat-msg">
                                                                <div class="direct-chat-info clearfix">
                                                                    <span class="direct-chat-name pull-left">{{$message->name}}</span>
                                                                    <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                                                                </div>
                                                                <img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">
                                                                <div class="direct-chat-text text-wrap"> {{$message->message}} </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="box-footer">
                                                <form class="form-message-send" id="form-message-send-{{$room->id}}" action="#" method="post">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <button id="message-send-{{$room->id}}" name="message-send" class="btn btn-warning message-send" type="submit">Send</button>
                                                        </div>
                                                        <input type="text" id="message-{{$room->id}}" name="message" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                                    </div>
                                                </form>
                                                <button id="exit-{{$room->id}}" type="button" name="exit-{{$room->id}}" class="btn btn-danger btn-sm btn-block float-right mb-1 exit" hidden>Выйти из Chat room {{$room->id}}</button>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                                <div class="card-body" id="card-body-{{$room->id}}">
                                    <button id="enter-{{$room->id}}" type="button" name="enter-{{$room->id}}" class="btn btn-warning btn-lg btn-block enter">Войти как {{$userName}}</button>
                                </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
{{--    <script src="https://cdn.jsdelivr.net/gh/centrifugal/centrifuge-js@2.8.4/dist/centrifuge.min.js"></script>--}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>






        $(document).ready(function() {
            $(".enter").on('click', function() {
                const room = this.name.slice(-1);
                let scroll = $('#chat-messages-' + room);
                $("#card-body-" + room).attr("hidden",true);
                $("#room-" + room).attr("hidden",false);
                $("#exit-" + room).attr("hidden",false);
                $("#enter-" + room).attr("hidden",true);
                scroll.animate({ scrollTop: scroll.height()}, 500);
                $.ajax({
                    url: '{{route('message.index')}}',
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {room_id: room},
                    success: function(data){
                        if(data) {
                            renderMessages(data);
                        }
                    }
                });
            });

            $(".message-send").on('click', function (e) {
                e.preventDefault();
                const room = this.id.slice(-1);

                let message = $("#message-" + room).val();
                $.ajax({
                    url: '{{route('message.store')}}',
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {room_id: room, message: message},
                    success: function(data){
                        if (data) {
                            let message = $('#chat-messages-' + data.room_id);
                            message.append('<div class="direct-chat-msg right">' +
                                '<div class="direct-chat-info clearfix">' +
                                '<span class="direct-chat-name pull-right">' + data.user + ' ' + '</span>' +
                                '<span class="direct-chat-timestamp pull-left">' + data.created_at.replace("T", " ").replace(".000000Z", "") + '</span>' +
                                '</div><img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">' +
                                '<div class="direct-chat-text text-wrap">' + data.message + '</div></div>');
                            message.animate({ scrollTop: message.height()}, 500);
                            $("#message-" + data.room_id).val('');
                        }
                    }
                });
            });
            $(".exit").on('click', function () {
                const room = this.id.slice(-1);
                $.ajax({
                    url: '{{route('room.exit')}}',
                    method: 'delete',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {room_id: room},
                    success: function(data){
                        if(data) {
                            $("#card-body-" + room).attr("hidden",false);
                            $("#room-" + room).attr("hidden",true);
                            $("#exit-" + room).attr("hidden",true);
                            $("#enter-" + room).attr("hidden",false);
                        }
                    }
                });
            });
        });

        function renderMessages(data) {
            let message = $('#chat-messages-' + data.room_id);
            message.html('');
            for(let i = (data.messages.length - 1); i >= 0; i--) {
                if(data.user === data.messages[i].name) {
                    message.append('<div class="direct-chat-msg right">' +
                        '<div class="direct-chat-info clearfix">' +
                        '<span class="direct-chat-name pull-right">' + data.messages[i].name + ' ' + '</span>' +
                        '<span class="direct-chat-timestamp pull-left">' + data.messages[i].created_at.replace("T", " ").replace(".000000Z", "") + '</span>' +
                        '</div><img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">' +
                        '<div class="direct-chat-text text-wrap">' + data.messages[i].message + '</div></div>');
                } else {
                    message.append('<div class="direct-chat-msg"><div class="direct-chat-info clearfix">' +
                        '<span class="direct-chat-name pull-left">' + data.messages[i].name + ' ' + '</span><span' +
                        'class="direct-chat-timestamp pull-right">' + data.messages[i].created_at.replace("T", " ").replace(".000000Z", "") + '</span></div>' +
                        '<img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">' +
                        '<div class="direct-chat-text text-wrap">' + data.messages[i].message + '</div></div>');
                }

            }
            message.animate({ scrollTop: message.height()}, 500);
        }


        Pusher.logToConsole = true;

        var pusher = new Pusher('1fe647baf78aec18aed1', {
            cluster: 'eu',
            auth: {
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            }
        });

        var channel = pusher.subscribe('news');
        channel.bind('App\\Events\\MyNewEvent', function(data) {
            alert('sdfsdfsdfsdf');
        });

        // const config = {subscribeEndpoint: '/broadcasting/auth'};
        // const centrifuge = new Centrifuge('wss://centrifuge.example.com/connection/websocket', config);
        //
        // // CONNECTION_TOKEN must be obtained via generateConnectionToken ()
        // centrifuge.setToken("CONNECTION_TOKEN");
        // let subscription = centrifuge.subscribe("$private:channel", function (ctx) {
        //     console.log('ctx');
        // });

        // centrifuge.connect();


        // window.users = [];
        //
        // function updateUserList()
        // {
        //     const list = $('.list-group');
        //
        //     window.users.forEach(user => {
        //         list.children(`<span class="badge bg-yellow" >${user.name}</span>`);
        //     });
        //
        //     $('.user-list').html(list);
        // }
        //
        // window.Echo
        //     .join('everywhere')
        //     .here(users => {
        //         // This runs once the user has joined the channel for only that user.
        //
        //         console.log(users);
        //
        //         window.users = users;
        //
        //         updateUserList();
        //     })
        //     .joining(user => {
        //         // When another user joins this will fire with the user who logged in.
        //         window.users.push(user);
        //         updateUserList();
        //
        //         jQuery('.card-body').prepend(`<div class="mt-2 alert alert-primary">${user.name} has joined</div>`);
        //
        //         setTimeout(() => {
        //             jQuery('.alert-primary').remove();
        //         }, 2000);
        //
        //         console.log(user);
        //     })
        //     .leaving(user => {
        //         // When the users connection is lost, we get the object of the user who has left.
        //         window.users = window.users.filter(u => u.id !== user.id);
        //         updateUserList();
        //
        //         jQuery('.card-body').prepend(`<div class="mt-2 alert alert-danger">${user.name} has left</div>`);
        //
        //         setTimeout(() => {
        //             jQuery('.alert-danger').remove();
        //         }, 2000);
        //
        //         console.log(user);
        //     })
        //     .listen('UserRegisteredEvent', ({ name }) => {
        //         console.log(name)
        //         jQuery('.card-body').prepend(`<div class="mt-2 alert alert-info">${name} has just registered</div>`);
        //
        //         setTimeout(() => {
        //             jQuery('.alert-info').remove();
        //         }, 2000);
        //     });
    </script>
@endsection

