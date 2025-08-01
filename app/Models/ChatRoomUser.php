<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoomUser extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chat_room_id',
        'last_seen',
        'sender_id',
    ];
    public function chat_room():BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }
    public function message():HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
