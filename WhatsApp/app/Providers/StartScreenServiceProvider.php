<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PersonalChat;
use App\Models\LastSeen;
use App\Models\Friend;
use App\Models\SmsCode;


use Illuminate\Support\ServiceProvider;

class StartScreenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        

        
        view()->composer(
            'layout.appLayout', 
            function ($view){

               


                $view->with('chats',Auth::user()->getPersonalChats1->merge(Auth::user()->getPersonalChats2))
                    ->with("friends",Auth::user()->getFriends1->merge(Auth::user()->getFriends2));
                
            }
        );  
    }
    
}
