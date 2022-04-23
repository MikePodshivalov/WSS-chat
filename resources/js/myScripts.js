$("#enter-1").on('click', function() {
    if ($('#username').val() !== '') {
        $(".card-body").hide();
        $("#room-1").attr("hidden",false);
        $(".direct-chat-messages").animate({ scrollTop: $('.direct-chat-messages').height()}, 1000);
        // $.ajax({
        //     url: '/',
        //     method: 'post',
        //     headers: {
        //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     dataType: 'html',
        //     data: {text: 'Текст'},
        //     success: function(data){
        //         alert(data);
        //     }
        // });
    }
});
