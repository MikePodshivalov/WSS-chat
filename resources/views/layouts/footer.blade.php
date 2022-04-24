        <script src="{{ asset("js/app.js") }}"></script>
        <script>
            $("#enter-1").on('click', function() {
                $(".card-body").hide();
                $("#room-1").attr("hidden",false);
                $("#exit-1").attr("hidden",false);
                $(".direct-chat-messages").animate({ scrollTop: $('.direct-chat-messages').height()}, 1000);
                $.ajax({
                    url: '{{route('chat.index')}}',
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {room_id: 1},
                    success: function(data){
                        console.log(data);
                    }
                });
            });
        </script>

    </body>
</html>
