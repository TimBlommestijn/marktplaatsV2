<?php

use App\Http\Controllers\ProductController;
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


Route::get('/',[ProductController::class, 'index'])->name('home');

Route::prefix('product')->group(function(){
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy-product')->middleware('auth');
    Route::get('/create',[ProductController::class, 'create'])->name('product-create')->middleware('auth');
    Route::get('/collection', [ProductController::class, 'collection'])->name('collection')->middleware('auth');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit')->middleware('auth');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show-product');
    Route::put('/{id}',[ProductController::class, 'update'])->name('update-product')->middleware('auth');
    Route::post('/', [ProductController::class, 'store'])->name('store-product')->middleware('auth');
});


Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('auth');






