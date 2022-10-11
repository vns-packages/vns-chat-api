<?php


namespace Vns\Chatting\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use stdClass;
use Vns\Chatting\Models\ChatConversation;

trait ChatGroupConversationTrait
{
    public function storeGroupConversation(array $userIDS, string $groupName, string $groupImage)
    {
        $conversation = ChatConversation::create([
            'is_group'       => true,
            'name'           => $groupName,
            'group_admin_id' => auth()->id()
        ]);

        $conversation->saveMedia($groupImage);

        $conversation->users()->attach([...$userIDS, auth()->id()]);

        return $conversation;
    }

    public function updateGroupInfo(int $conversationID, string $name, string $image = null)
    {
        $conversation = ChatConversation::find($conversationID);

        $data =  new stdClass;
        $data->name = $name;


        $conversation->update(['name'  => $name]);

        if ($image) {
            $conversation->clearMediaCollection();
            $conversation->saveMedia($image);
        }

        return $conversation;
    }

    public function changeGroupAdmin(int $conversationID, int $userID)
    {
        $conversation = ChatConversation::find($conversationID);

        $conversation->update(['group_admin_id' => $userID]);

        return $conversation;
    }

    public function addMembersToGroup(int $conversationID, array $userIDS)
    {
        $conversation = ChatConversation::find($conversationID);

        $conversation->users()->syncWithoutDetaching($userIDS);

        return $conversation;
    }

    public function deleteMemberFromGroup(int $conversationID, int $userID)
    {
        $conversation = ChatConversation::find($conversationID);

        $conversation->users()->detach($userID);

        return $conversation;
    }
}
