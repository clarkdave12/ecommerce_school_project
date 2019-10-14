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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* For Admin */
Route::resource('/categories', 'CategoriesController');

Route::get('/admin/users', 'AppController@getUserList');

/* Others */
Route::post('/register', 'AppController@register');
Route::get('/user-role/{id}', 'AppController@getUserRole');
