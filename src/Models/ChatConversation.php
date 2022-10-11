<?php

namespace Vns\Chatting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Vns\Chatting\Traits\SaveMedia;

class ChatConversation extends Model implements HasMedia
{
    use HasFactory, SaveMedia, InteractsWithMedia;

    protected $fillable = ['is_group', 'name', 'group_admin_id', 'image'];

    protected $appends = ['un_read_message_count', 'last_message', 'group_admin'];

    protected $casts = ['is_group' => 'boolean'];


    /*********** relations methods  ***********/
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_conversation_user',  'conversation_id', 'user_id');
    }

    public function groupAdmin()
    {
        return $this->belongsTo(User::class, 'group_admin_id');
    }


    /*********** attributes methods  ***********/
    public function getUnReadMessageCountAttribute()
    {
        return $this->messages()->where('is_read', 0)->whereNot('user_id', auth()->id())->count();
    }

    public function getLastMessageAttribute()
    {
        $last_message = ChatMessage::where('conversation_id', $this->id)->latest()->first();

        return $last_message;
    }

    public function getGroupAdminAttribute()
    {
        return User::find($this->group_admin_id);
    }

    public function getImageAttribute()
    {
        $media = $this->getFirstMedia();

        if ($media) {
            return [
                'path'      => $this->getFirstMediaUrl('default'),
                'mime_type' => $media['mime_type'],
                'name'      => $media['name']
            ];
        }

        return null;
    }
}
