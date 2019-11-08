<?php

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

use App\Http\Controllers\UsersController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/getUser/{id}', 'UsersController@show');

Route::get('/getUsers', 'UsersController@index');

Route::post('/addUser', 'UsersController@store');

Route::put('/updateUser/{id}', 'UsersController@update');

Route::delete('/delUser/{id}', 'UsersController@destroy');

Route::get('/findUser/{nombre}', 'UsersController@search');

