<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\AuthController;

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
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    dd('cache cleared');
});


Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'authenticate'])->name('authenticate');
});

Route::middleware(['isLogin','isAdmin'])->group(function () {
    Route::group(['prefix'=>'user','as'=>'user.'], function() {
        Route::get('/', [CrudController::class,'index'])->name('dashboard');
        Route::post('/create', [CrudController::class,'create'])->name('create');
        Route::get('/edit/{id}', [CrudController::class,'edit'])->name('edit');
        Route::put('/update', [CrudController::class,'update'])->name('update');
        Route::delete('/delete', [CrudController::class,'delete'])->name('delete');
    });
});

Route::get('/logout',[AuthController::class,'logout'])->name('logout');
