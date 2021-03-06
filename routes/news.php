<?php

use Illuminate\Support\Facades\Route;
use GrnSpc\News\Http\Controllers\ArticleController;

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

Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');



Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

});
