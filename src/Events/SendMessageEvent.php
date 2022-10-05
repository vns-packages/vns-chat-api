<?php

namespace Vns\Chatting\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(
        public $conversationID,
        public $message
    ) {
    }

    public function broadcastOn()
    {
        return ['private-chat-conversation.' . $this->conversationID];
    }

    public function broadcastAs()
    {
        return 'send-message';
    }
}
