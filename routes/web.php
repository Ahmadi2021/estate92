<?php

use App\Http\Controllers\Project\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Projects\UnitController;

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

//Route::get('/users/{user}', function (\App\Models\User   $user) {
//    return  $user->email;
//    return view('welcome');
//});

Route::redirect('/', '/home');
Route::get('test',function(){
    return auth()->user()->getRoleNames()->first();
})->middleware('auth');

//Route::resource('task',UnitController::class);
//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Protected Route

Route::group(['middleware' => ['auth']], function () {
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('projects', \App\Http\Controllers\Projects\ProjectController::class);
});
