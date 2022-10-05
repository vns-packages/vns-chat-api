<?php

namespace Vns\Chatting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;


/**
 * @method static \VnsChatting\Models\ChatConversation createConversation(array $participants, array $data = [])
 * @method static \VnsChatting\Models\ChatConversation createDirectConversation(array $participants, array $data = [])
 * @method static \VnsChatting\Services\MessageService message($message)
 * @method static \VnsChatting\Services\MessageService messages()
 * @method static \VnsChatting\Services\ConversationService conversation(Model $conversation)
 * @method static \VnsChatting\Services\ConversationService conversations()
 * @method static array unReadNotifications(Model $participant)
 * @method static \VnsChatting\Services\NotificationsService setParticipants(Model $participantModel1, Model $participantModel2)
 * @see Chatting
 * @see NotificationsService
 */
class ChattingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance('chatting-backend');
        return 'chatting-backend';
    }
}
