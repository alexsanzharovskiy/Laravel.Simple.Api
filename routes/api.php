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

// Auth
Route::post('auth', 'AuthController@auth');

Route::group(['middleware' => ['web', 'auth:api']], function()

{
    // Create New Customer POST PARAMS: ['name', 'cnp']
    Route::post('customer/create', 'CustomerController@create');

    // Getting transaction By filters
    Route::get('transaction', ['uses' => 'TransactionController@getWithFilters']);

    // Getting transaction
    Route::get('transaction/{customer_id}/{transaction_id}', ['uses' => 'TransactionController@get'])
        ->where([
            'customer_id' => '[0-9]+',
            'transaction_id' => '[0-9]+'
        ]);

    // Creation new transaction
    Route::post('transaction', ['uses' => 'TransactionController@create']);

    // Update new transaction
    Route::patch('transaction/{id}', ['uses' => 'TransactionController@update']);

    // Delete transaction
    Route::delete('transaction/{id}', ['uses' => 'TransactionController@destroy']);

});