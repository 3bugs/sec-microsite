<?php

use App\Http\Controllers\api\ApiCategoryController;
use App\Http\Controllers\api\ApiContactController;
use App\Http\Controllers\api\ApiDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//define('PATH_PUBLIC_FUNDRAISING', 'public/fundraising');
//define('PATH_PUBLIC_MEDIA', 'public/media');

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

$apiDataCallback = function () {
  Route::get('/', [ApiDataController::class, 'index']);
  Route::get('/{id}', [ApiDataController::class, 'show']);
  Route::post('/', [ApiDataController::class, 'store']);
  Route::post('/upload-file', [ApiDataController::class, 'storeUploadFile']);
  Route::put('/', [ApiDataController::class, 'update']);
  Route::delete('/', [ApiDataController::class, 'destroy']);
  Route::get('/date/{date}', [ApiDataController::class, 'indexByDate']);
};
Route::prefix('fundraising')->group($apiDataCallback);
Route::prefix('media')->group($apiDataCallback);
Route::prefix('media-more')->group($apiDataCallback);
Route::prefix('event')->group($apiDataCallback);

$apiCategoryCallback = function () {
  Route::get('/', [ApiCategoryController::class, 'index']);
  Route::post('/', [ApiCategoryController::class, 'store']);
  Route::put('/', [ApiCategoryController::class, 'update']);
  Route::delete('/', [ApiCategoryController::class, 'destroy']);
};
Route::prefix('fundraising-category')->group($apiCategoryCallback);
Route::prefix('media-category')->group($apiCategoryCallback);
Route::prefix('event-category')->group($apiCategoryCallback);

Route::get('/contact', [ApiContactController::class, 'index']);
Route::put('/contact', [ApiContactController::class, 'update']);
Route::delete('/contact', [ApiContactController::class, 'destroy']);
