<?php

use App\Http\Controllers\BooksController;
use App\Models\Book;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'books'], function () {
    Route::get('/', [BooksController::class, 'index']);
    Route::get('/{id}', [BooksController::class, 'show']);
});