<?php
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')->get('/transactions', function(\Illuminate\Http\Request $request){

    if($request->session()->get('token') === null){
        session(['token' => Auth::user()->createToken('Request Token')->accessToken]);
    }
    $http = new GuzzleHttp\Client;

    $response = $http->get('http://'. $_SERVER['REMOTE_ADDR'] .':8080/api/transaction', [
        'headers' => [
            'Accept' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer '.$request->session()->get('token'),
        ]
    ])->getBody()->getContents();

    return view('transactions')->with('transactions', json_decode($response));

});
