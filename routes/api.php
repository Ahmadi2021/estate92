<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Empolyee\EmpolyeeController;
use App\Http\Controllers\Projects\FloorController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\UnitController;
use App\Http\Controllers\property\PropertyController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/users/{user:email}', function (\App\Models\User   $user) {
    return  response()->json(['data' => $user]);
    return view('welcome');
});
//Route::apiResource('/users', UserController::class)
Route::apiResource('/blogs', BlogController::class);
Route::apiResource('/comments', CommentController::class);

//  Public Route
Route::post('login', [LoginController::class, 'check_login']);
Route::post('register', [\App\Http\Controllers\auth\RegisterController::class, 'register']);

// Route::post('register');

// Protected Route
// Route::middleware('auth:api')->group(function(){
//     Route::apiResource('/projects' ,  ProjectController::class );
// });

Route::group(['middleware' => ['auth:api']], function () {
//    Route::prefix('estate92')->group(function(){
        Route::apiResource('/projects', ProjectController::class);
        Route::apiResource('/floors', FloorController::class);
        Route::apiResource('/units', UnitController::class);
        Route::apiResource('/properties', PropertyController::class);
        Route::apiResource('/employees', EmpolyeeController::class);
//    });

});



