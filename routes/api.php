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

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                Route::post('captchas', 'CaptchasController@index');
                Route::post('captchas/verification', 'CaptchasController@verification');
                Route::post('login', 'AuthController@login');
                Route::post('logout', 'AuthController@logout');
            });
        Route::post('test', 'TestController@index');
        Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::middleware(['refresh.token', 'throttle:' . config('api.rate_limits.access')])
            ->group(function () {
                Route::get('profile', 'AuthController@profile');
            });
    });
