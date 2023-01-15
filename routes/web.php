<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvideController;

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
    //
    return view('provider.index');
});

// Routes for ProvideController
Route::controller(ProvideController::class)->group(function() 
{
    Route::get('/provider/list','getProviders')->name('providers.list');
});

Route::get('/home', function() {
    return view('provider.index');
})->name('test');
