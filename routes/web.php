<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', ['as' => 'get_seats', 'uses' => 'Controller@getSeats']);

Route::post('/book', ['as' => 'book_seats', 'uses' => 'Controller@bookSeats']);

Route::post('/cancel', ['as' => 'cancel_booking', 'uses' => 'Controller@cancelBooking']);
