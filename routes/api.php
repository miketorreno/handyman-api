<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HandymanController;
use App\Http\Controllers\YardSaleController;
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
Route::get('/handymen', [HandymanController::class, 'index'])->name('handymen.index');
Route::get('/handymen/{handyman}', [HandymanController::class, 'show'])->name('handymen.show');
Route::post('/handymen', [HandymanController::class, 'store'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('handymen.store');
Route::put('/handymen/{handyman}', [HandymanController::class, 'update'])->name('handymen.update');
Route::delete('/handymen/{handyman}', [HandymanController::class, 'destroy'])->name('handymen.destroy');

Route::post('/handymen/{handyman}/subscriptions/{subscriptionType}', [HandymanController::class, 'subscribe'])->name('handymen.subscribe');
Route::post('/handymen/{handyman}/subscriptions', [HandymanController::class, 'unsubscribe'])->name('handymen.unsubscribe');

// Route::get('/handymen/{handyman}/reviews', [ReviewController::class, 'index'])->name('handymen.reviews.index');
// Route::post('/handymen/{handyman}/reviews', [ReviewController::class, 'store'])->name('handymen.reviews.store');


// * Reviews
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


// * Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::post('/events', [EventController::class, 'store'])
    ->middleware(['auth:sanctum'])
    ->name('events.store');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');


// * Yard Sales
Route::get('/yardsales', [YardSaleController::class, 'index'])->name('yardsales.index');
Route::get('/yardsales/{yardsale}', [YardSaleController::class, 'show'])->name('yardsales.show');
Route::post('/yardsales', [YardSaleController::class, 'store'])
    ->middleware(['auth:sanctum'])
    ->name('yardsales.store');
Route::put('/yardsales/{yardsale}', [YardSaleController::class, 'update'])->name('yardsales.update');
Route::delete('/yardsales/{yardsale}', [YardSaleController::class, 'destroy'])->name('yardsales.destroy');






// * With Auth
// Route::group(['middleware' => 'auth:sanctum'], function () {
//     // * Tags
//     Route::get('/tags', [TagController::class, 'index'])->name('tag.index');

//     // * User
//     Route::get('/user', UserController::class)->name('user');
// });
