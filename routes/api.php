<?php

use Illuminate\Http\Request;

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


Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::resource('users', 'UserController');
    Route::group(['middleware' => 'jwt.auth'], function ($router) {
        Route::post('me', 'AuthController@me');

        Route::get('myTickets', 'TicketsController@myTickets');

        Route::get('exportEvents', 'EventsController@export');
        Route::post('refreshUser', 'UserController@me');
        Route::get('checkTicket', 'TicketsController@hasJoined');

        Route::resource('events', 'EventsController');
        Route::resource('tickets', 'TicketsController');

    });

});

