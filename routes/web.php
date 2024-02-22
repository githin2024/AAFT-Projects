<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtHomeController;
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

Route::get('home', [ExtHomeController::class, 'index']);
Route::get("campaign", [ExtHomeController::class, 'campaign']);
Route::get('create-campaign', [ExtHomeController::class, 'createCampaign']);
Route::get('courses', [ExtHomeController::class, 'getCourses']);
Route::post('store-campaign', [ExtHomeController::class, 'storeCampaign']);