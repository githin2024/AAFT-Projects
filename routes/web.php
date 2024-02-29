<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtHomeController;
use App\Http\Controllers\IntHomeController;
use App\Http\Controllers\AdminController;

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

//External Marketing Dashboard
Route::get('home', [ExtHomeController::class, 'index']);
Route::get("campaign", [ExtHomeController::class, 'campaign']);
Route::get('create-campaign', [ExtHomeController::class, 'createCampaign']);
Route::get('courses', [ExtHomeController::class, 'getCourses']);
Route::get('excel-campaign', [ExtHomeController::class, 'excelCampaign']);
Route::post('store-campaign', [ExtHomeController::class, 'storeCampaign']);
Route::post('parameter-campaign', [ExtHomeController::class, 'parameterCampaign']);
Route::post('confirm-lead', [ExtHomeController::class, 'confirmLead']);

//Internal Marketing Dashboard
Route::get('int-home', [IntHomeController::class, 'InternalIndex']);
Route::get('int-landing-page', [IntHomeController::class, 'LandingPage']);
Route::get('int-campaign', [IntHomeController::class, 'InternalCampaign']);

//Admin Dashboard
Route::get('admin-institution', [AdminController::class, 'AdminInstitution']);
Route::get('admin-home/{id}', [AdminController::class, 'AdminHomeInstitution']);

