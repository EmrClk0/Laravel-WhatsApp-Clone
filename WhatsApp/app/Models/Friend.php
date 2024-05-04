<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1_id',
        'user2_id',
        'verified',
        
    ];

    public function getUser1(){
        return $this->hasOne(User::class,"id","user1_id");

    }

    public function getUser2(){
        return $this->hasOne(User::class,"id","user2_id");

    }
}
