<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PersonalChat;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   /*
        $ip= $_SERVER['REMOTE_ADDR'];
        $user = User::where("ip",$ip)->first();
         
         
        if(!$user){
            $user = new User();
            $user->ip= $ip;
            $user->save();
        }
        
        Auth::login($user);

        $chats = Auth::user()->getPersonalChats1->merge(Auth::user()->getPersonalChats2);
        // friendleri de çek
        view()->composer(
            'layout.appLayout', 
            function ($view) {
                $view->with('chats',Auth::user()->getPersonalChats1->merge(Auth::user()->getPersonalChats2));
            }
        );*/


      
    }
}
