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
use App\Events\TestEvent;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* For Admin */
Route::resource('/categories', 'CategoriesController');
Route::resource('/products', 'ProductsController');
Route::get('/admin/users', 'AppController@getUserList');

/* Others */
Route::post('/register', 'AppController@register');
Route::get('/user-role/{id}', 'AppController@getUserRole')->middleware('auth:api');
Route::resource('/feedbacks', 'FeedbackController');
Route::resource('/carts', 'CartsController');
Route::resource('/profile', 'ProfilesController');
Route::get('/user-feedback/{user_id}', 'FeedbackController@getUserFeedback');
Route::post('/update-profile/{user_id}', 'ProfilesController@updateProfile');
Route::get('/reply/{id}/{message}', 'MessagesController@getReply');
Route::post('/saveReply', 'MessagesController@saveReply');
Route::get('/get_products_by_category/{category}', 'LexinController@productByCategory');
Route::get('/get_product_info/{id}', 'LexinController@productInfo');

Route::resource('/specs', 'SpecsController');
Route::resource('/messages', 'MessagesController');
Route::get('/message_admin', 'MessagesController@messageAdmin');
Route::get('/message_user', 'MessagesController@messageUSer');