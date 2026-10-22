<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\restaurant\MenuController;
use App\Http\Controllers\restaurant\DashboardController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/rest_delistf', function () {
    return view('rest_delistf');
});

Route::get('/rest_index', [DashboardController::class, 'index'])->name('rest_index');
Route::get('/rest_editM', [CategoryController::class, 'index'])->name('rest_editM');

//Route::get('/rest_editM', function () {
//    return view('rest_editM');});
Route::get('/restaurantprofile', function () {
    return view('restaurantprofile');
});
Route::get('/rest_reservation', function () {
    return view('rest_reservation');
});
Route::get('/welcome', function () {
    return view('welcome');
});


//login

Route::post('/register', [AuthController::class, 'register']);

Route::get('/welcome', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


//make category 
Route::post('/makeCat', [CategoryController::class, 'makeCat']);
Route::post('/makeMenu', [MenuController::class, 'store']);

//delete menu 

//Route::get('/', function () {
    return view('welcome');
//});
