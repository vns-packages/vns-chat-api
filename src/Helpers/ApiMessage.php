<?php

namespace Vns\Chatting\Helpers;



class ApiMessage
{
    public static function success($message): array
    {
        return ['message' => $message, 'status'  => true];
    }

    public static function error($message): array
    {
        return ['message' => $message, 'status' => true];
    }
}
