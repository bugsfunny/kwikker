<?php

use App\Http\Controllers\KweekController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('kweeks', [KweekController::class, 'index'])->name('kweeks.index');



Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::post('kweeks', [KweekController::class, 'store'])->name('kweeks.store');

    Route::get('/followings', [KweekController::class, 'followings'])->name('kweeks.followings');
    Route::post('/follows/{user:id}', [KweekController::class, 'follows'])->name('kweeks.follows');
    Route::post('/unfollows/{user:id}', [KweekController::class, 'unfollows'])->name('kweeks.unfollows');

    Route::get('/profile/{user:name}', [KweekController::class, 'profile'])->name('kweeks.profile');
});