<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\LastSeen;


class LastMessageServiceProvider extends ServiceProvider
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
        
        //LastSeen::where("user_id",Auth::user()->id)->update(["user_id"=>Auth::user()->id]);
        
    }

   
}
