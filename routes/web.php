<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserStoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('projects.index');
    });

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.user-stories', UserStoryController::class)->shallow();
});

// Remove this line that's causing the error
// require __DIR__.'/auth.php';

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
