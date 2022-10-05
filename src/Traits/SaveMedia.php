<?php


namespace Vns\Chatting\Traits;


use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Vns\Chatting\Helpers\MediaHelper;

trait SaveMedia
{
    public function saveMedia($mediaStrings, array $props = [],  $collection = 'default')
    {
        //        $media = json_decode($mediaStrings);
        $media = Arr::wrap($mediaStrings);
        foreach ($media as $key => $b64) {
            if (!MediaHelper::isValidBase64($b64)) {
                throw ValidationException::withMessages(['Base64 value is not a valid image']);
            }

            $ext = MediaHelper::getFileExtension($b64);

            $this
                ->addMediaFromString(base64_decode($b64))
                ->usingFileName(bin2hex(random_bytes(5)) . '-' . $this->id . '.' . $ext)
                ->withCustomProperties($props)
                ->toMediaCollection($collection);
        }
    }
}
