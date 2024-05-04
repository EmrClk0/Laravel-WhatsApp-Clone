<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalChat;
use App\Models\PersonalChatMessage;
use Illuminate\Support\Facades\Auth;

class PersonalChatMessageController extends Controller
{

    public function updateSeen($chatid){
        PersonalChatMessage::where("chat_id",$chatid)->where("from","!=",Auth::user()->id)->update(["seen"=>"1"]);

    }


    public function ChatMessages($chatid){
        // chat id den sohbetleri bul
        // yollas
        
        
        $chatid= base64_decode($chatid);
        $chat = PersonalChat::find($chatid);
        $chatMessages = PersonalChatMessage::where("chat_id", $chatid)->get();
        

        if($chat->user1_id==Auth::user()->id ){

            $user = $chat->getUser2;

        }elseif($chat->user2_id==Auth::user()->id){

            $user = $chat->getUser1;
        }

        $this->updateSeen($chatid);
       
        return view("whatsApp",compact("chatMessages","user","chatid"));


    }




    public function chatUserActiveUpdate($chatId){
        $personalChat = PersonalChat::find($chatId);
        if($personalChat->user1_id == Auth::user()->id){
            $personalChat->user2_active = 1;
        }else{
            $personalChat->user1_active = 1;

        }
        $personalChat->save();


    }


    public function sendTextMessage(Request $request){
        
        $chatId = base64_decode($request->chatId);
        $newPersonalChatMessage = new PersonalChatMessage;
        $newPersonalChatMessage->chat_id = $chatId;
        $newPersonalChatMessage->from=Auth::user()->id;
        $newPersonalChatMessage->message= $request->chatMessage;
        $newPersonalChatMessage->save();

        $this->chatUserActiveUpdate($chatId);
        return back();
        
        

    }


    public function sendFileMessage(Request $request){
        $allowedExts = ["xlm","xlsx","zip","rar","pdf","doc","docx"];
        $chatId = base64_decode($request->chatId);
        $file = $request->file;
        $fileName = uniqid().$file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension(); 
        if(!in_array($fileExtension,$allowedExts)){
            return back();
        }
        if($file->move("userDocuments/userFiles",$fileName)){
            PersonalChatMessage::create([
                "chat_id" => $chatId,
                "from" =>Auth::user()->id,
                "message" => $fileName,
                "message_type" => "file"
            ]);
            $this->chatUserActiveUpdate($chatId);

            return back();
            
        }else{
            return back()->withError("Dosya gönderimi başarısız");
        }


    }



    public function sendImageMessage(Request $request){

        $allowedExts = ["jpg","jpeg","gif","png"];
        $chatId = base64_decode($request->chatId);
        $image = $request->image;
        $imageName = uniqid().$image->getClientOriginalName();
        $imageExtension = $image->getClientOriginalExtension(); 
        if(!in_array($imageExtension,$allowedExts)){
            return back();
        }
        if($image->move("userDocuments/userChatImages",$imageName)){
            PersonalChatMessage::create([
                "chat_id" => $chatId,
                "from" =>Auth::user()->id,
                "message" => $imageName,
                "message_type" => "image"
            ]);
            $this->chatUserActiveUpdate($chatId);

            return back();
            
        }else{
            return back()->withError("Dosya gönderimi başarısız");
        }
    }



    public function deleteMessage($chatId,$messageId){
        $chatId = base64_decode($chatId);
        $messageId = base64_decode($messageId);

        $deletingMessage = PersonalChatMessage::where("chat_id",$chatId)->where("id",$messageId)->first();
        if($deletingMessage){
            $deletingMessage->delete();
        }
        return back();

       

    }
}
