<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsCode;
use App\Models\User;

class SmsCodeController extends Controller
{
    public static function isSmsCodeExists($user_id){
        return SmsCode::where("user_id",$user_id)->first();

    }


    public static function createSmsCode($user_id,$sms_code){
        return SmsCode::create([
            "user_id" => $user_id,
            "sms_code" => $sms_code
        ]);

    }

    /*
    public static function updateSmsCode($user_id,$sms_code){
        return SmsCode::where("user_id",$user_id)->update([
            "sms_code" => $sms_code
        ]);

    }*/



    public static function sendSmsCodeNotification($toPhoneNumber,$user_id){
        $smsCode = SmsCode::where("user_id",$user_id)->first();


        $basic  = new \Vonage\Client\Credentials\Basic("*******", "**********");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($toPhoneNumber, "WHATSAPP", "GİRİŞ KODUNUZ: $smsCode->sms_code")
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            //mesaj başarıyla gönderildi
            SmsCode::where("user_id",$user_id)->update([
                "sms_code_sent_date" => time(),
            ]);

            return 1;
        } else {
           return 0;
        }
        
        

    }





    public function sendCodeAgainOrFail(Request $request){

        $phoneNumber = base64_decode($request->phoneNumber);
        $user = User::where("ip",$phoneNumber)->first();
        $smsSentDate =  $user->getSmsCode->sms_code_sent_date;
        
        
        if((time()-$smsSentDate) > 180){
            
            if(/*$this->sendSmsCodeNotification($phoneNumber,$user->id)*/TRUE){
                return back()->with("success","SMS code is sent again");
            }else{
                return back()->with("error","UNEXPECTED ERROR");
                
            }
        }else{
            return back()->with("error","You have to wait 3 minutes to send code again");
        }
        

    }






}
