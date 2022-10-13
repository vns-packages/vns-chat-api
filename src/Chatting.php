<?php

namespace Vns\Chatting;

use Auth;
use Log;
use Vns\Chatting\Events\SendMessageEvent;
use Vns\Chatting\Models\ChatConversation;
use Vns\Chatting\Models\ChatMessage;
use Vns\Chatting\Traits\ChatDirectConversationTrait;
use Vns\Chatting\Traits\ChatGroupConversationTrait;

class Chatting
{
    use ChatDirectConversationTrait, ChatGroupConversationTrait;

    /*********** conversations ***********/

    public function getConversationById($conversationID)
    {
        return ChatConversation::findOrFail($conversationID);
    }

    public function deleteConversation($conversationID)
    {
        return ChatConversation::where('id', $conversationID)->delete();
    }


    /*********** messages ***********/
    public function getMessages($conversationID)
    {
        // $this->readAllMessages($conversationID);

        return ChatMessage::where('conversation_id', $conversationID)->latest()->with('user')->paginate(15);
    }

    public function storeMessage($user_id, $conversationID, $body, $type)
    {
        if ($type === 'file') {
            $message = ChatMessage::create([
                'body'            => 'file',
                'type'            => 'file',
                'user_id'         => $user_id,
                'conversation_id' => $conversationID,
            ]);

            if ($type == 'file') $message->saveMedia($body);
        } else {
            $message = ChatMessage::create([
                'body'            => $body,
                'type'            => 'text',
                'user_id'         => $user_id,
                'conversation_id' => $conversationID,
            ]);
        }

        // if ($this->getConversationById($conversationID)->is_group) {
        // } else

        // Log::info('', [$this->getConversationById($conversationID), $conversationID]);

        // event(new SendMessageEvent($conversationID, $message));

        return $message;
    }

    public function readAllMessages($conversationID)
    {
        return ChatMessage::where('conversation_id', $conversationID)->update(['is_read' => true]);
    }


    /*********** conversation users ***********/
    public function getConversationUsers($conversationID)
    {
        $conversation = ChatConversation::where('id', $conversationID)->with('users')->first();

        return $conversation->users;
    }

    public function addUsersToConversation($conversationID, $userIDS)
    {
        $conversation = ChatConversation::find($conversationID);

        $conversation->users()->attach($userIDS);

        return $conversation->users;
    }

    public function deleteUserFromConversation($conversationID, $userID)
    {
        $conversation = ChatConversation::find($conversationID);

        $oldUserIDS = $conversation->users->pluck('id');

        $oldUserIDS = array_filter($oldUserIDS->toArray(), fn ($value) => $value != $userID);

        $conversation->users()->sync($oldUserIDS);

        return true;
    }
}
