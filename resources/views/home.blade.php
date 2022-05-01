@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-content page-container border-dark" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-left">
                    @foreach($rooms as $room)
                        <div class="col-md-6 mb-2">
                            <div class="box box-warning direct-chat direct-chat-warning">
                                <div class="box-header with-border user-list" id="user-list-{{$room->id}}">
                                    <h3 class="box-title list-group">Chat room {{$room->id}}</h3>
{{--                                        <span class="badge bg-yellow" >User1</span>--}}
{{--                                        <span class="badge bg-yellow" >User2</span>--}}
                                </div>
                                    <div class="box-body">
                                        <div id="room-{{$room->id}}" hidden>
                                            <div id="chat-messages-{{$room->id}}" class="direct-chat-messages">
{{--                                                @foreach($messages as $message)--}}
{{--                                                    @if($message->room_id === $room->id)--}}
{{--                                                        @if($message->name === Auth::user()->name)--}}
{{--                                                            <div class="direct-chat-msg right">--}}
{{--                                                                <div class="direct-chat-info clearfix">--}}
{{--                                                                    <span class="direct-chat-name pull-right">{{$message->name}}</span>--}}
{{--                                                                    <span class="direct-chat-timestamp pull-left">{{$message->created_at}}</span>--}}
{{--                                                                </div>--}}
{{--                                                                <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">--}}
{{--                                                                <div class="direct-chat-text text-wrap">{{$message->message}}</div>--}}
{{--                                                            </div>--}}
{{--                                                        @else--}}
{{--                                                            <div class="direct-chat-msg">--}}
{{--                                                                <div class="direct-chat-info clearfix">--}}
{{--                                                                    <span class="direct-chat-name pull-left">{{$message->name}}</span>--}}
{{--                                                                    <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>--}}
{{--                                                                </div>--}}
{{--                                                                <img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">--}}
{{--                                                                <div class="direct-chat-text text-wrap"> {{$message->message}} </div>--}}
{{--                                                            </div>--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                @endforeach--}}
                                            </div>
                                            <div class="box-footer">
                                                <form class="form-message-send" id="form-message-send-{{$room->id}}" action="#" method="post">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <button id="message-send-{{$room->id}}" name="message-send" class="btn btn-warning message-send" type="submit">Send</button>
                                                        </div>
                                                        <input type="text" id="message-{{$room->id}}" name="message" class="form-control message-send">
                                                    </div>
                                                </form>
                                                <button id="exit-{{$room->id}}" type="button" name="exit-{{$room->id}}" class="btn btn-danger btn-sm btn-block float-right mb-1 exit">Выйти из Chat room {{$room->id}}</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                                <div class="card-body-enter" id="card-body-enter-{{$room->id}}">
                                    <button id="enter-{{$room->id}}" type="button" name="enter-{{$room->id}}" class="btn btn-warning btn-lg btn-block enter">Войти как {{$userName}}</button>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
    <script>
        $(function (){

            const Http = window.axios;

            //входим в одну из комнат чата и загружаем messages
            $(".enter").on('click', function() {
                const room = this.name.slice(-1);
                let scroll = $('#chat-messages-' + room);
                $("#card-body-enter-" + room).attr("hidden",true);
                $("#room-" + room).attr("hidden",false);

                Http.post("{{route('fetch.messages')}}", {
                    'room_id': room,
                }).then(function (data) {
                    console.log(data);
                    if (data.status === 200) {
                        renderMessages(data.data);
                        scroll.animate({scrollTop: $(this).height()});
                    } else {
                        console.log('status is not OK from fetchMessages');
                    }
                });

                //слушатели событий
                const Echo = window.Echo;
                Echo.join(`room.${room}`)
                    .here((users) => {
                        let list = '';

                        for (let i = 0; i < users.length; i++) {
                            list += `<span class="badge bg-yellow" >${users[i].name}</span>` + ` `;
                        }

                        $('#user-list-' + room).append(list);
                        console.log(users);
                    })
                    .joining((user) => {
                        $('#user-list-' + room).append(`<span class="badge bg-yellow" id="user-${user.name}">${user.name}</span>`);
                        console.log(user);
                    })
                    .leaving((user) => {
                        $('#user-' + user.name).remove();
                        console.log(user)
                    })
                    .listen('MessageSentEvent', (data) => {
                        let messageGet = $('#chat-messages-' + data.roomId);
                        messageGet.append(theirMessages(data));
                        // console.log(e);
                    });
            });

            //Отправляем сообщение
            $('.message-send').click(function (e) {
                e.preventDefault();
                const room = this.id.slice(-1);
                const message = $("#message-" + room);

                Http.post("{{route('messages.store')}}", {
                    'room_id': room,
                    'message': message.val()
                }).then(function (response) {
                    console.log(response);
                    if (response.status === 201) {
                        let messageCreated = $('#chat-messages-' + response.data.room_id);
                        messageCreated.append(`<div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><strong>${response.data.user}</strong> </span>
                            <span class="direct-chat-timestamp pull-left">${response.data.created_at}</span>
                        </div>
                            <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">
                            <div class="direct-chat-text text-wrap">${response.data.message}</div>
                        </div>`);
                        messageCreated.animate({scrollTop: $(this).height()});
                        $("#message-" + response.data.room_id).val('');
                }}).catch(function (error) {
                        console.log(error);
                });
            });

            {{--$(".exit").on('click', function () {--}}
            {{--    const room = this.id.slice(-1);--}}
            {{--    $.ajax({--}}
            {{--        url: '{{route('rooms.exit')}}',--}}
            {{--        method: 'delete',--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        dataType: 'json',--}}
            {{--        data: {room_id: room},--}}
            {{--        success: function(data){--}}
            {{--            if(data) {--}}
            {{--                $("#card-body-" + room).attr("hidden",false);--}}
            {{--                $("#room-" + room).attr("hidden",true);--}}
            {{--                $("#exit-" + room).attr("hidden",true);--}}
            {{--                $("#enter-" + room).attr("hidden",false);--}}
            {{--            }--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
        });

        function renderMessages(data) {
            let message = $('#chat-messages-' + data.room_id);
            // message.html('');
            if (data.messages.length === 0) {
                return;
            }
            for(let i = 0; i < data.messages.length; i++) {
                if(data.user === data.messages[i].user.name) {
                    message.append(myMessage(data.messages[i]));
                } else {
                    message.append(theirMessages(data.messages[i]));
                }
            }
            message.animate({scrollTop: $(this).height()});
        }

        function myMessage($data) {
            return `<div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right"><strong>${data.user.name}</strong> </span>
                <span class="direct-chat-timestamp pull-left">${data.created_at}</span>
            </div>
            <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">
            <div class="direct-chat-text">${data.message}</div>
            </div>`;
        }

        function theirMessages($data) {
            return `<div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left"><strong>${data.user.name}</strong> </span>
                <span class="direct-chat-timestamp pull-right">${data.created_at}</span>
            </div>
            <img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">
            <div class="direct-chat-text text-wrap">${data.message}</div>
            </div>`;
        }
    </script>
@endsection

