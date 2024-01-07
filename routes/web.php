<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Web Routes For Admin
|--------------------------------------------------------------------------
*/
Route::get('/', [AdminController::class, 'index'])->name('login');
Route::get('login', [AdminController::class, 'login'])->name('login');
Route::post('post-login', [AdminController::class, 'processLogin'])->name('login.post'); 
Route::get('registration', [AdminController::class, 'registration'])->name('registration');
Route::post('post-registration', [AdminController::class, 'postRegistration'])->name('registration.post');  
Route::get('logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    ### user
    Route::resource('user', UserController::class);
    ### Blog
    Route::resource('blog', BlogController::class);
    ### Comment
    Route::resource('comment', CommentController::class);
});

