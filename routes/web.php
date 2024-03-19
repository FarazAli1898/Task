<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

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

Route::get('/', function () {
    return view('welcome');
});     

Route::get('/store', [StoreController::class, 'index']);
Route::get('/api/cities/{countryId}', [StoreController::class, 'getCitiesByCountry']);
Route::get('/api/landmarks/{cityId}', [StoreController::class, 'getLandmarksByCity']);
Route::post('/api/stores', [StoreController::class, 'store']);
Route::put('/api/stores/{id}', [StoreController::class, 'update']);
Route::get('/api/stores/{id}', [StoreController::class, 'show']);
Route::post('/api/landmarks', [StoreController::class, 'createLandmark']);
Route::post('/api/cities', [StoreController::class, 'createCity']);
Route::post('/api/countries', [StoreController::class, 'createCountry']);