<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Restaurant;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [RestaurantController::class, 'index'])->name('home');
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| Authentication  ({role} = customer | restaurant)
|--------------------------------------------------------------------------
*/
Route::where(['role' => 'customer|restaurant'])->group(function () {
    Route::get('/register/{role}', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/{role}', [AuthController::class, 'register']);
    Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/{role}', [AuthController::class, 'login']);
    Route::post('/logout/{role}', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Customer area
|--------------------------------------------------------------------------
*/
Route::middleware('auth:customer')->name('customer.')->group(function () {
    Route::get('/profile', [Customer\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Customer\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/orders', [Customer\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [Customer\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [Customer\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [Customer\OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/reservations', [Customer\ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [Customer\ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [Customer\ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::post('/menus/{menu}/rate', [Customer\RatingController::class, 'storeMenu'])->name('menus.rate');
    Route::post('/restaurants/{restaurant}/rate', [Customer\RatingController::class, 'storeRestaurant'])->name('restaurants.rate');
});

/*
|--------------------------------------------------------------------------
| Restaurant area
|--------------------------------------------------------------------------
*/
Route::middleware('auth:restaurant')->prefix('dashboard')->name('restaurant.')->group(function () {
    Route::get('/', [Restaurant\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [Restaurant\DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [Restaurant\DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::resource('menus', Restaurant\MenuController::class)->except('show');

    Route::get('/orders', [Restaurant\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Restaurant\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Restaurant\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('/orders/{order}/paid', [Restaurant\OrderController::class, 'markPaid'])->name('orders.paid');

    Route::get('/reservations', [Restaurant\ReservationController::class, 'index'])->name('reservations.index');
});
