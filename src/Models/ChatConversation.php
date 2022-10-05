<?php

namespace Vns\Chatting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ChatConversation extends Model
{
    use HasFactory;

    protected $fillable = ['is_group', 'name'];

    protected $appends = ['un_read_message_count', 'last_message'];

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
}
