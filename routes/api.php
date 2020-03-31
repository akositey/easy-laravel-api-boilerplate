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


//IMPORTANT NOTE: apply middleware in production
// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
Route::patch('employees/{employee}/restore', 'Api\EmployeeController@restore')->name('employees.restore');
Route::apiResource('employees', 'Api\EmployeeController');
// });

//Auth Routes
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('authenticate', 'AuthController@authenticate')->name('api.authenticate');
    Route::post('register', 'AuthController@register')->name('api.register');

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});