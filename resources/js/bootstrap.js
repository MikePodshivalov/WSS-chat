window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    encrypted: false,
    wssPort: 6001,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

// Echo.channel('messages')
//     .listen('.message-added', (e) => {
//         console.log(e);
//     });


// window.users = [];
//
// function updateUserList()
// {
//     const list = $('.list-group');
//
//     window.users.forEach(user => {
//         list.append(`<li class="list-group-item">${user.name}</li>`);
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

// window.Echo
//     .private('chat.1')
//     .listenForWhisper('helloooo', ({ name }) => {
//         console.log(event);
//
//         jQuery('.card-body').prepend(`<div class="mt-2 alert alert-info">${name} has just said HI!</div>`);
//
//         setTimeout(() => {
//             jQuery('.alert-info').remove();
//         }, 2000);
//     });
//
// jQuery(function () {
//     jQuery('#sayHi').click(() => {
//         window.Echo.private('chat.1').whisper('helloooo', window.active_user);
//     });
// });
