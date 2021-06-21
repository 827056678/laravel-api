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
    ->group(function ($router) {
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function ($router) {
                $router->post('captchas', 'CaptchasController@index');
                $router->post('captchas/verification', 'CaptchasController@verification');
                $router->post('login', 'AuthController@login');
                $router->post('logout', 'AuthController@logout');
            });
        Route::middleware(['refresh.token', 'throttle:' . config('api.rate_limits.access')])
            ->group(function ($router) {
                $router->get('profile', 'AuthController@profile');
            });
    });

