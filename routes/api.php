<?php

use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

define('PATH_PUBLIC_FUNDRAISING', 'public/fundraising');

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

Route::get('/fundraising', function (Request $request) {
  app('debugbar')->disable();
  //date_default_timezone_set('Asia/Bangkok');

  try {
    $fundraisingList = DB::table('fundraisings')
      ->join('fundraising_categories', 'fundraisings.category_id', '=', 'fundraising_categories.id')
      ->select('fundraisings.*', 'fundraising_categories.title AS category_title')
      ->orderBy('id', 'desc')
      ->get();

    foreach ($fundraisingList as $fundraising) {
      $fundraising->cover_image = Storage::url($fundraising->cover_image);
    }
    $fundraisingCategoryList = FundraisingCategory::orderBy('id', 'asc')->get();

    //return $fundraisingList->toJson();

    /*return json_encode(array(
      'status' => 'ok',
      'data_list' => $fundraisingList,
      'category_list' => $fundraisingCategoryList,
    ));*/
    return response()->json(array(
      'status' => 'ok',
      'data_list' => $fundraisingList,
      'category_list' => $fundraisingCategoryList,
    ), 200);
  } catch (Exception $e) {
    return response()->json(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ), 200);
  }
});

Route::post('/fundraising', function (Request $request) {
  app('debugbar')->disable();

  // imagePath: public/fundraising/xxx.jpg
  // imageUrl: /storage/fundraising/xxx.jpg
  try {
    $imagePath = $request->file('cover_image')->store(PATH_PUBLIC_FUNDRAISING);
    $imageUrl = Storage::url($imagePath);
    $title = $request->title;
    $description = $request->description;
    $categoryId = $request->category_id;
    $content = $request->content_data;

    $fundraising = new Fundraising;
    $fundraising->title = $title;
    $fundraising->description = $description;
    $fundraising->category_id = $categoryId;
    $fundraising->cover_image = $imagePath;
    $fundraising->content = $content;
    $fundraising->save();

    $message = "Title: $title\n"
      . "Description: $description\n"
      . "Category ID: $categoryId\n"
      . "Cover image imagePath: $imagePath\n"
      . "Cover image URL: $imageUrl";

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

Route::put('/fundraising', function (Request $request) {
  app('debugbar')->disable();

  try {
    $imagePath = null;
    if ($request->hasFile('cover_image')) {
      $imagePath = $request->file('cover_image')->store(PATH_PUBLIC_FUNDRAISING);
      $imageUrl = Storage::url($imagePath);
    }

    $fundraising = Fundraising::find($request->id);
    if ($request->has('title')) {
      $fundraising->title = $request->title;
    }
    if ($request->has('description')) {
      $fundraising->description = $request->description;
    }
    if ($request->has('category_id')) {
      $fundraising->category_id = $request->category_id;
    }
    if ($request->has('content_data')) {
      $fundraising->content = $request->content_data;
    }
    if ($request->has('published')) {
      $fundraising->published = $request->published;
    }
    if ($imagePath != null) {
      $fundraising->cover_image = $imagePath;
    }
    $fundraising->save();

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

Route::delete('/fundraising', function (Request $request) {
  app('debugbar')->disable();

  try {
    $id = $request->id;
    $fundraising = Fundraising::find($id);
    $fundraising->delete();

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

Route::post('/editor-file-upload', function (Request $request) {
  app('debugbar')->disable();
  //header('Access-Control-Allow-Origin: *');

  // imagePath: public/fundraising/xxx.jpg
  // imageUrl: /storage/fundraising/xxx.jpg
  try {
    $imagePath = $request->file('upload')->store(PATH_PUBLIC_FUNDRAISING);
    $imageUrl = Storage::url($imagePath);

    return response()->json(array(
      'error' => array(
        'code' => 0,
        'message' => 'ok',
      ),
      'url' => $imageUrl,
    ), 200);
  } catch (Exception $e) {
    return response()->json(array(
      'error' => array(
        'code' => 1,
        'message' => 'เกิดข้อผิดพลาดในการบันทึกไฟล์',
      ),
      'url' => null,
    ), 200);
  }
});
