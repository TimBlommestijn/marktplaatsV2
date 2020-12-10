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
Route::middleware(['auth:sanctum', 'verified'])->get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [ProductController::class, 'collection'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/create-product',[ProductController::class, 'create'])->name('create-product');
Route::middleware(['auth:sanctum', 'verified'])->put('/product/{id}',[ProductController::class, 'update'])->name('update-product');
Route::middleware(['auth:sanctum', 'verified'])->post('/product', [ProductController::class, 'store'])->name('store-product');
Route::middleware(['auth:sanctum', 'verified'])->delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy-product');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('show-product');




