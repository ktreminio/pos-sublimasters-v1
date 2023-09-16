<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Finance\CashRegisters;
use App\Http\Livewire\Maintenance\Categories;
use App\Http\Livewire\Maintenance\Colors;
use App\Http\Livewire\Maintenance\ProductForm;
use App\Http\Livewire\Maintenance\Products;
use App\Http\Livewire\Maintenance\SubCategories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaginationController;

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
    return redirect('/login');
});

Route::middleware('guest')->group(function(){
    Route::get('/login',Login::class)->name('login');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::get('/forget-password',[AuthController::class,'forgetPassword'])->name('forget_password');
    Route::post('/authenticate',[AuthController::class,'authenticate'])->name('authenticate');
    Route::post('/signup',[AuthController::class,'signup'])->name('signup');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/subcategories', SubCategories::class)->name('subcategories');
    Route::get('/colors', Colors::class)->name('colors');
    Route::get('products', Products::class)->name('products');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');
    Route::get('cash-register',  function (){
        return view('livewire.finance.cash-registers-and-cash-movements')->layout('layouts.app');
    })->name('cash_register');
    Route::get('orders',  function (){
        return view('livewire.order.orders')->layout('layouts.app');
    })->name('orders');
});

Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');
Route::get('/lang/{lang}',[ LanguageController::class,'switchLang'])->name('switch_lang');
Route::get('/pagination-per-page/{per_page}',[ PaginationController::class,'set_pagination_per_page'])->name('pagination_per_page');
