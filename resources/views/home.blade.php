@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-content page-container border-dark" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-left">
                    @foreach($rooms as $room)
                        <div class="col-md-6 mb-2">
                            <div class="box box-warning direct-chat direct-chat-warning">
                                <div class="box-header with-border user-list" id="user-list">
                                    <h3 class="box-title list-group">Chat room {{$room->id}}</h3>
                                    <div id="user-list-{{$room->id}}"></div>
                                </div>
                                    <div class="box-body">
                                        <div id="room-{{$room->id}}" hidden>
                                            <div id="chat-messages-{{$room->id}}" class="direct-chat-messages"></div>
                                            <div class="box-footer">
                                                <form class="form-message-send" id="form-message-send-{{$room->id}}" action="#" method="post">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <button id="message-send-{{$room->id}}" name="message-send" class="btn btn-warning message-send-btn" type="submit">Send</button>
                                                        </div>
                                                        <label for="message-{{$room->id}}"></label>
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
                $('#card-body-enter-' + room).attr("hidden",true);
                $('#room-' + room).attr("hidden",false);

                Http.post("{{route('fetch.messages')}}", {
                    'room_id': room,
                }).then(function (data) {
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
                            list += `<span class="badge bg-yellow" id="user-${users[i].name}">${users[i].name}</span>` + ` `;
                        }
                        $('#user-list-' + room).append(list);
                    })
                    .joining((user) => {
                        $('#user-list-' + room).append(`<span class="badge bg-yellow" id="user-${user.name}">${user.name}</span>`);
                    })
                    .leaving((user) => {
                        $('#user-' + user.name).remove();
                    })
                    .listen('MessageSentEvent', (data) => {
                        let messageGet = $('#chat-messages-' + data.roomId);
                        messageGet.append(theirMessages(data));
                        messageGet.animate({scrollTop: $(this).height()});
                    });

                //выход из комнаты по нажатию на кнопку
                $('.exit').on('click', function () {
                    const room = this.id.slice(-1);
                    $('#card-body-enter-' + room).attr("hidden",false);
                    $('#room-' + room).attr("hidden",true);
                    $('#chat-messages-' + room).html('');
                    window.Echo.leave(`room.${room}`);
                    $('#user-list-' + room).html('');
                });
            });

            //Отправляем сообщение
            $('.message-send-btn').click(function (e) {
                e.preventDefault();
                const room = this.id.slice(-1);
                const message = $("#message-" + room);

                Http.post("{{route('messages.store')}}", {
                    'room_id': room,
                    'message': message.val()
                }).then(function (response) {
                    if (response.status === 201) {
                        let messageCreated = $('#chat-messages-' + response.data.room_id);
                        messageCreated.append(`<div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><strong>${response.data.user}</strong> </span>
                            <span class="direct-chat-timestamp pull-left">${response.data.created_at}</span>
                        </div>
                            <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">
                            <div class="direct-chat-text">
                                <div class="text-message">
                                    ${response.data.message}
                                </div>
                            </div>
                        </div>`);
                        messageCreated.animate({scrollTop: $(this).height()});
                        $('#message-' + response.data.room_id).val('');
                }}).catch(function (error) {
                        console.log(error);
                });
            });
        });

        function renderMessages(data) {
            let message = $('#chat-messages-' + data.room_id);
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

        function myMessage(data) {
            return `<div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right"><strong>${data.user.name}</strong> </span>
                <span class="direct-chat-timestamp pull-left">${data.created_at}</span>
            </div>
            <img class="direct-chat-img" src="{{asset('images/me.png')}}" alt="message user image">
                <div class="direct-chat-text">
                    <div class="text-message">
                        ${data.message}
                    </div>
                </div>
            </div>`;
        }

        function theirMessages(data) {
            return `<div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left"><strong>${data.user.name}</strong> </span>
                <span class="direct-chat-timestamp pull-right">${data.created_at}</span>
            </div>
            <img class="direct-chat-img" src="{{asset('images/male.png')}}" alt="message user image">
            <div class="direct-chat-text text-wrap">
                <div class="text-message">
                    ${data.message}
                </div>
            </div>
            </div>`;
        }
    </script>
@endsection
