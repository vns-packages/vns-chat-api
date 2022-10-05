<?php

namespace Vns\Chatting\Helpers;



class MediaHelper
{
    public static function isValidBase64(string $base64): bool
    {
        return base64_decode($base64);
    }

    public static function getFileExtension(string $base64): string
    {
        $bin = base64_decode($base64);

        $mime_type = finfo_buffer(finfo_open(), $bin, FILEINFO_MIME_TYPE);

        $base_extension = explode('/', $mime_type)[1];

        $ext = explode('-', $base_extension);

        return $ext[count($ext) - 1];
    }
}
