<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteMacroServiceProvider extends ServiceProvider
{ 
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Route::macro('softDeletes', function ($user) {
        //     Route::get('users/trashed', 'UsersController@trashed')->name('users.trashed');
        //     Route::patch('users/{user}/restore', 'UsersController@restore')->name('users.restore');
        //     Route::delete('users/{user}/delete', 'UsersController@delete')->name('users.delete');
        // });   
    }
}
