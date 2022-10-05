<?php

namespace Vns\Chatting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Vns\Chatting\Traits\SaveMedia;

class ChatMessage extends Model implements HasMedia
{
    use HasFactory, SaveMedia, InteractsWithMedia;

    protected $fillable = [
        'body',
        'type',
        'user_id',
        'conversation_id',
        'reply_to_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'user_id' => 'int',
        'conversation_id' => 'int',
        'reply_to_id' => 'int',
    ];

    protected $appends = ['is_sender'];

    /*********** relations methods  ***********/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply_to()
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to_id');
    }

    public function conversation()
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }


    public function getBodyAttribute($body)
    {
        if ($this->type == 'file') {
            $media = $this->getFirstMedia();

            return ['path' => $this->getFirstMediaUrl('default'), 'mime_type' => $media['mime_type'], 'name' => $media['name']];
        }

        return $body;
    }

    public function getIsSenderAttribute()
    {
        return auth()->id() == $this->user_id;
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->singleFile();
    }
}
