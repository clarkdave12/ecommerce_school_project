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
Route::post('/product_search', 'ProductsController@productSearch');
Route::post('/validate', 'AppController@validateCaptcha');

Route::get('/execute-payment/{id}/{totalAmount}', 'PaymentController@execute');
Route::post('/create-payment/{id}/{totalAmount}', 'PaymentController@create')->name('create-payment');

Route::get('/payments', 'OrdersController@index');
Route::delete('/clear_cart/{user_id}', 'CartsController@clearCart');
Route::get('/orders/{id}', 'OrdersController@history');
Route::get('/get_history_products/{order_id}', 'OrdersController@historyProducts');

Route::get('/manage_users', 'AppController@manageUsers');
Route::delete('/remove_user/{id}', 'AppController@removeUser');

Route::get('/getorders', 'AppController@getOrders');
Route::get('/shipping_info/{id}', 'AppController@getShippingInfo');

Route::get('/get_sales/{month}/{year}', 'SalesController@getSales');
Route::post('/send_code', 'SendCode@send');
Route::post('/verify_code', 'SendCode@verifyCode');
Route::get('/validate_email/{email}', 'SendCode@validateEmail');
Route::post('/reset_password', 'SendCode@resetPassword');

Route::get('/profile_history/{id}', 'OrdersController@profileHistory');
Route::get('/get_change_profile/{id}', 'AppController@changeProfile');
Route::post('/change_email', 'AppController@changeEmail');
Route::post('/change_firstname', 'AppController@changeFirstname');
Route::post('/change_lastname', 'AppController@changeLastname');
Route::post('/change_address', 'AppController@changeAddress');
Route::post('/check_password', 'AppController@checkPassword');

Route::get('/new_products', 'ProductsController@newProducts');

Route::post('/change_quantity', 'CartsController@changeQuantity');
Route::get('/get_most_popular', 'ProductsController@getMostPopular');
Route::get('/search_by_category/{id}', 'ProductsController@searchByCategory');

Route::get('/get_user_data/{id}', 'MessagesController@getUserData');
Route::get('/get_message_history/{id}', 'MessagesController@getMessageHistory');