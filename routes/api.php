<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HandymanController;
use App\Http\Controllers\SubscriptionTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// * Tags
Route::get('/tags', [TagController::class, 'index'])->name('tag.index');


// * Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');


// * Services
Route::get('/services', [ServiceController::class, 'index'])->name('service.index');


// * Subscriptions
Route::get('/subscriptions', [SubscriptionTypeController::class, 'index'])->name('subscription.index');


// * Handymen
Route::get('/handymen', [HandymanController::class, 'index'])->name('handyman.index');
Route::get('/handymen/{handymen}', [HandymanController::class, 'show'])->name('handyman.show');
Route::post('/handymen', [HandymanController::class, 'store'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('handyman.store');
Route::put('/handymen/{handymen}', [HandymanController::class, 'update'])->name('handyman.update');
Route::delete('/handymen/{handymen}', [HandymanController::class, 'destroy'])->name('handyman.destroy');

Route::post('/handymen/{handyman}/subscriptions/{subscriptionType}', [HandymanController::class, 'subscribe'])->name('handyman.subscribe');
Route::post('/handymen/{handyman}/subscriptions', [HandymanController::class, 'unsubscribe'])->name('handyman.unsubscribe');









// * With Auth
// Route::group(['middleware' => 'auth:sanctum'], function () {
//     // * Tags
//     Route::get('/tags', [TagController::class, 'index'])->name('tag.index');

//     // * User
//     Route::get('/user', UserController::class)->name('user');
// });
