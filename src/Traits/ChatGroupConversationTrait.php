<?php


namespace Vns\Chatting\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use stdClass;
use Vns\Chatting\ChattingFacade;
use Vns\Chatting\Helpers\ApiMessage;
use Vns\Chatting\Models\ChatConversation;

trait ChatGroupConversationTrait
{
    private function canEditGroup(ChatConversation $conversation)
    {
        return $conversation->group_admin_id === auth()->id();
    }

    public function storeGroupConversation(array $userIDS, string $groupName, string $groupImage = null)
    {
        $conversation = ChatConversation::create([
            'is_group'       => true,
            'name'           => $groupName,
            'group_admin_id' => auth()->id()
        ]);

        if ($groupImage) $conversation->saveMedia($groupImage);

        $conversation->users()->attach([...$userIDS, auth()->id()]);

        return $conversation;
    }

    public function updateGroupInfo(int $conversationID, string $name, string $image = null)
    {
        $conversation = ChatConversation::find($conversationID);

        if ($this->canEditGroup($conversation)) {
            $conversation->update(['name'  => $name]);

            if ($image) {
                $conversation->clearMediaCollection();
                $conversation->saveMedia($image);
            }

            return ApiMessage::success('group info updated');
        }

        return ApiMessage::error('you are not the admin');
    }

    public function changeGroupAdmin(int $conversationID, int $userID)
    {
        $conversation = ChatConversation::find($conversationID);

        if ($this->canEditGroup($conversation)) {
            $conversation->update(['group_admin_id' => $userID]);

            return ApiMessage::success('group admin changed');
        }

        return ApiMessage::error('you are not the admin');
    }

    public function addMembersToGroup(int $conversationID, array $userIDS)
    {
        $conversation = ChatConversation::find($conversationID);

        if ($this->canEditGroup($conversation)) {
            $conversation->users()->syncWithoutDetaching($userIDS);

            return ApiMessage::success('members added to group');
        }

        return ApiMessage::error('you are not the admin');
    }

    public function deleteMemberFromGroup(int $conversationID, int $userID)
    {
        $conversation = ChatConversation::find($conversationID);

        if ($this->canEditGroup($conversation)) {

            // admin
            if ($conversation->group_admin_id === $userID) {
                // check if group is empty
                if (count($conversation->users) <= 1) {
                    $conversation->users()->detach($userID);

                    $conversation->delete();

                    return ApiMessage::success('member removed from group and group is deleted');
                } else {
                    return ApiMessage::error("admin can't left the group when the group not empty");
                }
            }

            // normal member
            $conversation->users()->detach($userID);
            return ApiMessage::success('member removed from group');
        }

        return ApiMessage::error('you are not the admin');
    }
}
