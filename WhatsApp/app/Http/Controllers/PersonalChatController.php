<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalChat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalChatMessage;


class PersonalChatController extends Controller
{

    public function getChat($userId){
        $chat = PersonalChat::where(function ($query) use ($userId){
            $query->where("user1_id",Auth::user()->id)
                ->where("user2_id",$userId);
        })->orWhere(function ($query) use ($userId){
            $query->where("user2_id",Auth::user()->id)
                ->where("user1_id",$userId);
        })->get();

        return $chat;

    }


    public function createChat($userId){
        $newChat = new PersonalChat();
        $newChat->user1_id = Auth::user()->id;
        $newChat->user2_id = $userId;
        $newChat->save();
        return $newChat->id;

        // chatid return ki yönlendirsin
    }

    public function chatActive($chat){
        // benim aktive durumu 0 sa 1 yap
        $chat = $chat[0];
        if($chat->user1_id == Auth::user()->id){
            $chat->user1_active = 1;
            $chat->save();
        }elseif($chat->user2_id == Auth::user()->id){
            $chat->user2_active = 1;
            $chat->save();
        }
        
        return $chat->id;

    }

    public function redirectToChat($chatId){
        $encodedId = base64_encode($chatId);
        return redirect()->route("chatMessages",$encodedId);

    }



    public function createNewChatOrSkip($chat,$userId){
        
        $exist = count($chat);
        if($exist){
            $chatID = $this->chatActive($chat);

        }else{
            $chatID = $this->createChat($userId);
        }
        return $this->redirectToChat($chatID);

    }

    
    public function newChat($userId){
        return   $this->createNewChatOrSkip($this->getChat($userId),$userId);

    }







    public function deleteChatAndMessages($chatId){
        PersonalChatMessage::where("chat_id",$chatId)->delete();
        PersonalChat::where("id",$chatId)->delete();
        
        
        

    }

    public function chatDisactive($chatId){
        $chatId = base64_decode($chatId);
        $chat = PersonalChat::find($chatId);
        
        
        if($chat->user1_id == Auth::user()->id){
            if($chat->user2_active==0){
                $this->deleteChatAndMessages($chatId);
                
            }else{
                $chat->user1_active = 0;
                $chat->save();

            }
        }else{

            if($chat->user1_active==0){
                $this->deleteChatAndMessages($chatId);
                
               
            }else{
                $chat->user2_active = 0;
                $chat->save();

            }
        }
        
        return redirect()->route("home");
    }
}
