<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PersonalChat;
use App\Http\Controllers\FriendController;
use App\Models\SmsCode;
use App\Http\Controllers\SmsCodeController;
use App\Models\LastSeen;



class UserController extends Controller
{


    public function logout(){
        Auth::logout();
        return redirect()->route("login");
    }

    public function getUser($ip){
        return User::where("ip",$ip)->first();
    }

    public function createUser($ip,$photo="default.png"){
       return User::create([
            "ip" => $ip,
            "photo" => $photo
        ]);
    }

    public function createLastSeen($user_id){
        LastSeen::create([
            "user_id" => $user_id
        ]);
        
    }

    public function loginAttempt(Request $request){
        $this->verifyPhone($request);
        
        $phoneNumber = "+90" . str_replace(" ","",$request->phone);
        
        if(!$this->getUser($phoneNumber)){
           $user = $this->createUser($phoneNumber);
            $this->createLastSeen($user->id);
        }else{
            $user = $this->getUser($phoneNumber);
        }

        
        if(!SmsCodeController::isSmsCodeExists($user->id)){
            SmsCodeController::createSmsCode($user->id,random_int(1111,9999));
        }

        $smsCode = SmsCode::where("user_id",$user->id)->first();
       

        if($smsCode->sms_code_sent_date!=null){
            // "sms kodunuz zaten gönderilmiş verify ediniz";
            // bilgi mesajıyşa git
            //return view("verify",compact("phoneNumber"))->with("error","Code already send");
            return redirect()->route('verifyCode',base64_encode($phoneNumber))->with("error","Code already send. Verify your account");  

        }else{
            // "sms kodunuz gönderilecek ve verify sayfasına yönlendirileceksini";
            if(/*SmsCodeController::sendSmsCodeNotification($phoneNumber,$user->id)*/ TRUE){
                // "verify yönlendirmece";
                
                //return view("verify",compact("phoneNumber"))->with("success","Enter the code");
                return redirect()->route('verifyCode',base64_encode($phoneNumber))->with("success","Code has been send. Verify your account");  

                
            }else{
                // "beklenmedik bir hata";
                // redirect back with error
                return back()->withError("Cant send sms");
            }
        }
        // SmsCodeController::sendSmsCodeNotification($phoneNumber,$user->id);
        //sms at ayrı bi fonsiyon sms fonksiyonunda süre kontrolü yap

        



        // VERİFY COD YAP KODUN KAYTEDİLME TARİHİ 3 DK GEÇTİYSE TEKRAR KOD İSTE 

    }


    public function logining(Request $request){
        $phoneNumber = base64_decode($request->phoneNumber);
        
        $this->verifyCode($request);
        $code = $request->code;
        $user = $this->getUser($phoneNumber);
        $userSms = $user->getSmsCode;
        $userSmsCode = $userSms->sms_code;

        if($userSmsCode==$code){
            
            Auth::login($user);
            $userSms->delete();
            return redirect()->route("home");


        }else{
            return back()->with("error","Code doesn't match");
        }
        

    }







   public function verifyPhone(Request $request){
        $request->validate([
                
            "phone" =>[
                "required",
                "regex:/^([0-9]){3} ([0-9]){3} ([0-9]){4}/"
            ],
        ]);  
   }

   public function verifyCode(Request $request){

        $request->validate([
                    
            "code" =>[
                "required",
                "regex:/^([0-9]{4})$/"
            ],
        ]);  


   }




   public function hata(Request $request){
    return back()->with("error","deneme hatası");

   }

}
