<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('jsonapi','App\Http\Controllers\JsonApiController@index')->name('jsonapi');
Route::get('duplicatejsonapi','App\Http\Controllers\JsonApiController@duplicatejsonapi')->name('duplicatejsonapi');
Route::any('create-users','App\Http\Controllers\JsonApiController@createusers')->name('createusers');
Route::any('send-email','App\Http\Controllers\JsonApiController@sendemail')->name('sendemail');
Route::get('public-ip','App\Http\Controllers\JsonApiController@public_ip')->name('public_ip');

