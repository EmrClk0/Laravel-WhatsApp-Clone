<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PersonalChat;
use App\Models\Friend;
use App\Models\LastSeen;

use App\Models\SmsCode;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'photo',
        'status',
    ];

    public function getPersonalChats1(){
        return $this->hasMany(PersonalChat::class,"user1_id","id");
       
       
    
    }

    public function getPersonalChats2(){
        return $this->hasMany(PersonalChat::class,"user2_id","id");
    
    }

    
    

    public function getFriends1(){
        return $this->hasMany(Friend::class,"user1_id","id");

    }

    public function getFriends2(){
        return $this->hasMany(Friend::class, "user2_id","id");
    }

    public function getLastSeenDetails(){
        return $this->hasOne(LastSeen::class,"user_id","id");
    }

    public function getSmsCode(){
        return $this->hasOne(SmsCode::class,"user_id","id");
    }
    
}
