<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Chat</title>
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        Chat room
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="data-message">

                        </div>
                        <div class="form-group">
                            <textarea id="message" placeholder="message..." class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button id="button-send" class="btn btn-block btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(function (){

            const Http = window.axios;
            const Echo = window.Echo;
            const message = $('#message');

            $('textarea').keyup(function () {
                $(this).removeClass('is-invalid');
            });

            $('#button-send').click(function () {
                if (message.val() === '') {
                    message.addClass('is-invalid');
                } else {
                    Http.post("{{url('send')}}", {
                        'message': message.val()
                    }).then(() => {
                        message.val('');
                    });
                }
            });

            let channel = Echo.channel('channel-chat')
                .listen('.App\\Events\\ChatEvent', function (data) {
                    console.log(data.message.message);
                   $('#data-message')
                    .append(data.message.message + '<br>');
                });
        })
    </script>
</body>
</html>

