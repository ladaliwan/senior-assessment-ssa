<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            Route::macro('softDeletes', function () {
                Route::get('users/trashed', 'UsersController@trashed')->name('users.trashed');
                Route::delete('users/{user}/force-delete', 'UsersController@forcedelete')->name('users.forcedelete');
                Route::patch('users/{user}/restore', 'UsersController@restore')->name('users.restore');
        });   
    }
}
