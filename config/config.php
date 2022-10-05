<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'file-extensions' => ['png', 'gif', 'jpeg', 'pdf', 'wav', 'mp3', 'mp4', 'x-wav'],


    /*
    |-------------------------------------
    | Pusher API credentials
    |-------------------------------------
    */
    'pusher' => [
        'key'    => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster'   => env('PUSHER_APP_CLUSTER'),
            'encrypted' => false,
        ],
    ],
];
