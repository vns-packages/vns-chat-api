<?php


namespace Vns\Chatting\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vns\Chatting\Models\ChatConversation;

trait ChatGroupConversationTrait
{
    public function storeGroupConversation(array $userIDS, string $groupName = null)
    {
        $conversation = ChatConversation::create(['is_group' => true, 'name' => $groupName]);

        $conversation->users()->attach([...$userIDS, auth()->id()]);

        return $conversation;
    }
}
