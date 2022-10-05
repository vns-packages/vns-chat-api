<?php

namespace Vns\Chatting\Helpers;

use Pusher\Pusher;

class PusherHelper
{
    public function __construct(public $pusher)
    {
        $this->pusher = new Pusher(
            config('vns_chatting.pusher.key'),
            config('vns_chatting.pusher.secret'),
            config('vns_chatting.pusher.app_id'),
            config('vns_chatting.pusher.options'),
        );
    }


    public function trigger($channel, $event, $data)
    {
        return $this->pusher->trigger($channel, $event, $data);
    }


    public function auth($channelName, $socket_id, $data = null)
    {
        return $this->pusher->socketAuth($channelName, $socket_id, $data);
    }
}
