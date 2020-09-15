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
Route::get('/book/getByTitle/{title}', 'BookController@findByTitle');
Route::get('/book/perCategory/{category}', 'BookController@getBookPerCat');
Route::post('/book', 'BookController@store');
Route::put('/book/update/{id}', 'BookController@update');
Route::delete('/book/delete/{id}', 'BookController@destroy');

// Category Router;

Route::get('/category', 'CategoryController@index');
Route::post('/category', 'CategoryController@store');
Route::put('/category/{id}', 'CategoryController@update');
Route::delete('/category/{id}', 'CategoryController@destroy');

// Borrower Router;

Route::get('/borrower', 'BorrowerController@index');
Route::post('/borrower', 'BorrowerController@store');
Route::get('/borrower/show/{id}', 'BorrowerController@show');
Route::get('/borrower/showbyname/{name}', 'BorrowerController@findByName');
Route::put('/borrower/update/{id}', 'BorrowerController@update');
Route::delete('/borrower/delete/{id}', 'BorrowerController@destroy');

// Borrow Router

Route::get('/loan', 'BorrowController@index');
Route::post('/loan', 'BorrowController@store');
Route::post('/loan/back/{id}', 'BorrowController@comeback');
Route::delete('/loan/{id}', 'BorrowController@destroy');
