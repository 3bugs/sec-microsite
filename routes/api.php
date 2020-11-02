<?php

use App\Http\Controllers\api\_ApiDataController;
use App\Models\FundraisingCategory;
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

Route::get('/fundraising-category', function (Request $request) {
  app('debugbar')->disable();

  try {
    $fundraisingCategoryList = FundraisingCategory::orderBy('id', 'asc')->get();

    return json_encode(array(
      'status' => 'ok',
      'data_list' => $fundraisingCategoryList,
    ));
  } catch (Exception $e) {
    return json_encode(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ));
  }
});

Route::post('/fundraising-category', function (Request $request) {
  app('debugbar')->disable();

  // imagePath: public/fundraising/xxx.jpg
  // imageUrl: /storage/fundraising/xxx.jpg
  try {
    $title = $request->title;
    $description = $request->description;

    $category = new FundraisingCategory;
    $category->title = $title;
    $category->description = $description;
    $category->save();

    $message = "Title: $title\n"
      . "Description: $description";

    return response()->json(array(
      'status' => 'ok',
      'message' => $message,
    ), 200);
  } catch (Exception $e) {
    return response()->json(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ), 200);
  }
});

Route::put('/fundraising-category', function (Request $request) {
  app('debugbar')->disable();

  try {
    $category = FundraisingCategory::find($request->id);
    if ($request->has('title')) {
      $category->title = $request->title;
    }
    if ($request->has('description')) {
      $category->description = $request->description;
    }
    if ($request->has('published')) {
      $category->published = $request->published;
    }
    $category->save();

    return response()->json(array(
      'status' => 'ok',
      'message' => '',
    ), 200);
  } catch (Exception $e) {
    return response()->json(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ), 200);
  }
});

Route::delete('/fundraising-category', function (Request $request) {
  app('debugbar')->disable();

  try {
    $id = $request->id;
    $category = FundraisingCategory::find($id);
    $category->delete();

    return response()->json(array(
      'status' => 'ok',
      'message' => 'success',
    ), 200);
  } catch (Exception $e) {
    return response()->json(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ), 200);
  }
});

$apiDataCallback = function () {
  Route::get('/', [_ApiDataController::class, 'index']);
  Route::post('/', [_ApiDataController::class, 'store']);
  Route::post('/upload-file', [_ApiDataController::class, 'storeUploadFile']);
  Route::put('/', [_ApiDataController::class, 'update']);
  Route::delete('/', [_ApiDataController::class, 'destroy']);
};
Route::prefix('fundraising')->group($apiDataCallback);
Route::prefix('media')->group($apiDataCallback);
