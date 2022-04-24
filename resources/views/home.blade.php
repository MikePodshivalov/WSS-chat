@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-content page-container border-dark" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-left">
                    @foreach($rooms as $room)
                        <div class="col-md-6 mb-2">
                            <div class="box box-warning direct-chat direct-chat-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Chat room {{$room->id}}</h3>
                                    <span class="badge bg-yellow" >User1</span>
                                    <span class="badge bg-yellow" >User2</span>
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
                                                            <div class="direct-chat-text">{{$message->message}}</div>
                                                        </div>
                                                    @else
                                                        <div class="direct-chat-msg">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name pull-left">{{$message->name}}</span>
                                                                <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                                                            </div>
                                                            <img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">
                                                            <div class="direct-chat-text"> {{$message->message}} </div>
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
                            @if(isset($userName))
                                <div class="card-body" id="card-body-{{$room->id}}">
                                    <button id="enter-{{$room->id}}" type="button" name="enter-{{$room->id}}" class="btn btn-warning btn-lg btn-block enter">Войти как {{$userName}}</button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
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
                        // console.log(data.messages);
                        // console.log(data.room_id);
                    }
                });
            });

            $(".message-send").on('click', function (e) {
                e.preventDefault();
                const room = this.id.slice(-1);
                console.log(room);
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
                        console.log(data);
                        if (data) {
                            let message = $('#chat-messages-' + data.room_id);
                            message.append('<div class="direct-chat-msg right">' +
                                '<div class="direct-chat-info clearfix">' +
                                '<span class="direct-chat-name pull-right">' + data.user + ' ' + '</span>' +
                                '<span class="direct-chat-timestamp pull-left">' + data.created + '</span>' +
                                '</div><img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">' +
                                '<div class="direct-chat-text">' + data.message + '</div></div>');
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
    </script>
@endsection

