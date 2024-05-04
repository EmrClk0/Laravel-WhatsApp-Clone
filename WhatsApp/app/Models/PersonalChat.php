<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PersonalChatMessage;

class PersonalChat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1_id',
        'user2_id',
        'user1_active',
        "user2_active",
    ];


    public function getUser1(){
        return $this->hasOne(User::class,"id","user1_id");
    }

    public function getUser2(){
        return $this->hasOne(User::class,"id","user2_id");
    }


    public function getMessages(){
        return $this->hasMany(PersonalChatMessage::class,"chat_id","id")->orderBy("id","DESC");
    }

}
