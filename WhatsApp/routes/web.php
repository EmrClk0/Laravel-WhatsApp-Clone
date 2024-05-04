<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalChatMessageController;
use App\Http\Controllers\PersonalChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\SmsCodeController;
use Nexmo\Laravel\Facade\Nexmo;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/logout",[UserController::class,"logout"])->name("logout");

Route::get("/login",function(){
    return view("login");
})->name("login");

Route::post("/login/attempt",[UserController::class,"loginAttempt"])->name("loginAttempt");

Route::get("/login/attempt/verify/{phoneNumber}",function($phoneNumber){
    return view("verify",compact("phoneNumber"));
})->name("verifyCode");

Route::post("/login/attempt/sendCodeAgain",[SmsCodeController::class,"sendCodeAgainOrFail"])->name("sendCodeAgainOrFail");

Route::post("/login/attempt/verify/logining",[UserController::class,"logining"])->name("logining");



Route::middleware('auth')->get("/",function(){
    return view("layout.appLayout");
})->name("home");

Route::middleware('auth')->get("/chat/{chatid}",[PersonalChatMessageController::class,"ChatMessages"])->name("chatMessages");

Route::middleware('auth')->post("/sendTextMessage",[PersonalChatMessageController::class,"sendTextMessage"])->name("sendTextMessage");
Route::middleware('auth')->post("/sendFileMessage",[PersonalChatMessageController::class,"sendFileMessage"])->name("sendFileMessage");
Route::middleware('auth')->post("/sendImageMessage",[PersonalChatMessageController::class,"sendImageMessage"])->name("sendImageMessage");
Route::middleware('auth')->get("/newChat/{userId}",[PersonalChatController::class,"newChat"])->name("newChat");
Route::middleware('auth')->get("/deleteMessage/chat/{chatId}/message/{messageId}",[PersonalChatMessageController::class,"deleteMessage"])->name("deleteMessage");
Route::middleware('auth')->get("/chatDisactive/{chatId}",[PersonalChatController::class,"chatDisactive"])->name("chatDisactive");
Route::middleware('auth')->post("/addFriend",[FriendController::class,"addFriend"])->name("addFriend");



Route::post("/hata",[UserController::class,"hata"])->name("hata");
