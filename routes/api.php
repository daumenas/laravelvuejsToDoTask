<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('users')->group(function () {
        Route::get('all', 'UserController@index')->middleware('isAdmin');;
        Route::post('createUser', 'UserController@create')->middleware('isAdmin');
        Route::post('editUser/{id}', 'UserController@edit')->middleware('isAdmin');
        Route::delete('deleteUser/{id}', 'UserController@delete')->middleware('isAdmin');
        });
        Route::post('logout', 'AuthController@logout');
    });
Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('tasks')->group(function () {
        Route::post('changeStatus/{id}', 'ToDoTaskController@changeStatus');
        Route::post('createTask', 'ToDoTaskController@create')->middleware('isAdmin');
        Route::post('editTask/{id}', 'ToDoTaskController@edit')->middleware('isAdmin');
        Route::delete('deleteTask/{id}', 'ToDoTaskController@delete')->middleware('isAdmin');
        Route::get('allAdmin', 'ToDoTaskController@indexAdmin')->middleware('isAdmin');;
        Route::get('allUser', 'ToDoTaskController@indexUser');
    });
});
