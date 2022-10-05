<?php


namespace Vns\Chatting\Traits;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vns\Chatting\Models\ChatConversation;

trait ChatDirectConversationTrait
{
    private function getDirectConversationByUserID(int $userID)
    {
        return ChatConversation::whereHas(
            'users',
            fn (Builder $query) => $query->where('user_id', $userID)->where('is_group', false)
        )->first();
    }

    public function storeDirectConversation(int $userID)
    {
        if ($this->getDirectConversationByUserID($userID)) {
            return $this->getDirectConversationByUserID($userID);
        }

        // create new conversation
        $conversation = ChatConversation::create(['is_group' => false]);
        $conversation->users()->attach([$userID, auth()->id()]);

        return $conversation;
    }
}
