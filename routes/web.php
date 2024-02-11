<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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

Route::get('/', [ListingController::class,'index'])->name('Listing.index');

Route::prefix('/Listings')->name('Listings.')->group(function(){
    //! Showing one listing
    Route::get('/{Listing}',[ListingController::class,'show'])->name('show')
    ->where('Listing','[0-9]+');
    //! creating a job
    Route::get('/create',[ListingController::class,'create'])->name('create');

    //! editing a job
    Route::get('/{Listing}/edit',[ListingController::class,'edit'])->name('edit')
    ->where('Listing','[0-9]+');
    //! update
    Route::put('/{Listing}',[ListingController::class,'update'])->name('update')
    ->where('Listing','[0-9]+');
    //! storing new job
    Route::post('/',[ListingController::class,'store'])->name('store');
    //! Deleting

    Route::delete('/{Listing}/delete', [ListingController::class,'destroy'])->name('store');

    //! manage listings

    Route::get('/manage',[ListingController::class,'manage'])->name('manage');
});

//! registering
Route::get('/register',[UserController::class,'create'])->name('register')->middleware('guest');

Route::post('/users',[UserController::class,'store'])->name('store')->middleware('guest');

//! logout

Route::post('/logout',[UserController::class,'logout'])->name('logout')->middleware('auth');


//! Show Login

Route::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');

//! login
Route::post('/users/authenticate', [UserController::class,'authenticate'])->middleware('guest');

