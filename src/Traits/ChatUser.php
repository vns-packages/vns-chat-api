<?php


namespace Vns\Chatting\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vns\Chatting\Models\ChatConversation;

trait ChatUser
{
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(ChatConversation::class, 'chat_conversation_user',   'user_id', 'conversation_id');
    }
}
