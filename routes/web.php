<?php

use Illuminate\Support\Facades\Route;


Route::resource('users', 'UsersController');
Route::softDeletes('users', 'UsersController');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

