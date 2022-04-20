<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>{{config('app.name')}}</title>
</head>
<body>
    <div class="container">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-left">
                    <div class="col-md-6">
                        <div class="box box-warning direct-chat direct-chat-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Chat room 1</h3>
                                <div class="box-tools pull-right">
                                    <span class="badge bg-yellow" >User1</span>
                                    <span class="badge bg-yellow" >User2</span>
                                    <span class="badge bg-yellow" >User3</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div id="room-1" hidden>
                                    <div class="direct-chat-messages">
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-left">Timona Siera</span>
                                                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                            </div>
                                            <img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">
                                            <div class="direct-chat-text"> For what reason would it be advisable for me to think about business content? </div>
                                        </div>
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-left">Timona Siera</span>
                                                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                            </div>
                                            <img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">
                                            <div class="direct-chat-text"> For what reason would it be advisable for me to think about business content? </div>
                                        </div>
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                            </div>
                                            <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/administrator-male.png" alt="message user image">
                                            <div class="direct-chat-text"> Thank you for your believejhbjhbjbjhbjhbjhbjbjhbjhbjhbjhbjbjhb in our supports </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <form action="#" method="post">
                                            <div class="input-group">
                                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                                <span class="input-group-btn">
                                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                                        </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <input class="form-control mb-3 mt-5" id="username" type="text" name="username-1" placeholder="Username">
                                <button id="enter-1" type="button" name="enter-1" value="enter-1" class="btn btn-warning btn-lg btn-block">Войти</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-warning direct-chat direct-chat-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Chat room 2</h3>
                                <div class="box-tools pull-right">
                                    <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">User1</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="direct-chat-messages">
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Timona Siera</span>
                                            <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> For what reason would it be advisable for me to think about business content? </div>
                                    </div>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                            <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> Thank you for your believejhbjhbjbjhbjhbjhbjbjhbjhbjhbjhbjbjhb in our supports </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <form action="#" method="post">
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-warning direct-chat direct-chat-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Chat room 3</h3>
                                <div class="box-tools pull-right">
                                    <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">User1</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="direct-chat-messages">
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Timona Siera</span>
                                            <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> For what reason would it be advisable for me to think about business content? </div>
                                    </div>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                            <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> Thank you for your believejhbjhbjbjhbjhbjhbjbjhbjhbjhbjhbjbjhb in our supports </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <form action="#" method="post">
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-warning direct-chat direct-chat-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Chat room 4</h3>
                                <div class="box-tools pull-right">
                                    <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">User1</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="direct-chat-messages">
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Timona Siera</span>
                                            <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> For what reason would it be advisable for me to think about business content? </div>
                                    </div>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                            <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                        </div>
                                        <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/administrator-male.png" alt="message user image">
                                        <div class="direct-chat-text"> Thank you for your believejhbjhbjbjhbjhbjhbjbjhbjhbjhbjhbjbjhb in our supports </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <form action="#" method="post">
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
    <script>
        $("#enter-1").on('click', function() {
            $("#enter-1").hide();
            $("#room-1").attr("hidden",false);

            console.log(e);
        });
    </script>
</body>

</html>
