<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;



class FriendController extends Controller
{
    public function addFriend(Request $request){
        $friend = User::where("ip",$request->ip)->first();
        if($friend){
            $newFriend = new Friend();
            $newFriend->user1_id = Auth::user()->id;
            $newFriend->user2_id = $friend->id;
            $newFriend->verified =1;
            $newFriend->save();

            return back();

        }else{
            return back()->withError("NO VALİD USER");
        }

    }


    
}
