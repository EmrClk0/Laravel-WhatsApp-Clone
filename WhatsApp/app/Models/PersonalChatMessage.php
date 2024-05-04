<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_id',
        'from',
        'message_type',
        'message',
        'seen',
    ];
}
