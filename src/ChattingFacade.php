<?php

namespace Vns\Chatting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;


/**
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
