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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Book router;

Route::get('/book', 'BookController@index');
Route::post('/book', 'BookController@store');
Route::patch('/book/update/{id}', 'BookController@update');
Route::delete('/book/delete/{id}', 'BookController@destroy');

// Category Router;

Route::get('/category', 'CategoryController@index');
Route::post('/category', 'CategoryController@store');
Route::patch('/category/update/{id}', 'CategoryController@update');
Route::get('/category/delete/{id}', 'CategoryController@destroy');

// Borrower Router;

Route::get('/borrower', 'BorrowerController@index');
Route::post('/borrower', 'BorrowerController@store');
Route::get('/borrower/{id}', 'BorrowerController@show');
Route::put('/borrower/{id}', 'BorrowerController@update');
Route::delete('/borrower/{id}', 'BorrowerController@destroy');

// Borrow Router

