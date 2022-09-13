<?php

use App\Http\Controllers\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PopularPackageController;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/package/popular',[DataController::class,'popularPackage']);
Route::get('/activity/popular',[DataController::class,'activities']);
Route::get('/general',[DataController::class,'general']);
Route::get('/social',[DataController::class,'social']);
Route::get('/destination',[DataController::class,'destination']);
Route::get('/banner',[DataController::class,'banner']);
Route::get('/gallery',[DataController::class,'gallery']);
Route::get('/footer',[DataController::class,'footerHolidays']);
Route::get('/testimonial',[DataController::class,'testimonial']);
Route::get('/hotel/popular',[DataController::class,'popularHotel']);
Route::get('/association',[DataController::class,'associationLogos']);
Route::get('/transport',[DataController::class,'transport']);

