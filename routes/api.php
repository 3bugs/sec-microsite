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

Route::get('/fundraising', function (Request $request) {
  app('debugbar')->disable();

  //$fundraisingList = Fundraising::orderBy('id', 'asc')->get();

  $fundraisingList = DB::table('fundraisings')
    ->join('fundraising_categories', 'fundraisings.category_id', '=', 'fundraising_categories.id')
    ->select('fundraisings.*', 'fundraising_categories.title AS category_title')
    ->get();

  foreach ($fundraisingList as $fundraising) {
    $fundraising->cover_image = Storage::url($fundraising->cover_image);
  }
  $fundraisingCategoryList = FundraisingCategory::orderBy('id', 'asc')->get();

  //return $fundraisingList->toJson();

  return json_encode(array(
    'status' => 'ok',
    'data_list' => $fundraisingList,
    'category_list' => $fundraisingCategoryList,
  ));
});

Route::post('/fundraising', function (Request $request) {
  // imagePath: public/fundraising/xxx.jpg
  // imageUrl: /storage/fundraising/xxx.jpg
  try {
    $imagePath = $request->file('cover_image')->store(PATH_PUBLIC_FUNDRAISING);
    $imageUrl = Storage::url($imagePath);
    $title = $request->title;
    $description = $request->description;
    $categoryId = $request->category_id;

    $fundraising = new Fundraising;
    $fundraising->title = $title;
    $fundraising->description = $description;
    $fundraising->category_id = $categoryId;
    $fundraising->cover_image = $imagePath;
    $fundraising->content = '';
    $fundraising->save();

    $message = "Title: $title\n"
      . "Description: $description\n"
      . "Category ID: $categoryId\n"
      . "Cover image imagePath: $imagePath\n"
      . "Cover image URL: $imageUrl";

    return json_encode(array(
      'status' => 'ok',
      'message' => $message,
    ));
  } catch (Exception $e) {
    return json_encode(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ));
  }
});

Route::put('/fundraising', function (Request $request) {
  try {
    $imagePath = null;
    if ($request->hasFile('cover_image')) {
      $imagePath = $request->file('cover_image')->store(PATH_PUBLIC_FUNDRAISING);
      $imageUrl = Storage::url($imagePath);
    }
    $id = $request->id;
    $title = $request->title;
    $description = $request->description;
    $categoryId = $request->category_id;

    $fundraising = Fundraising::find($id);
    $fundraising->title = $title;
    $fundraising->description = $description;
    $fundraising->category_id = $categoryId;
    $fundraising->content = '';
    if ($imagePath != null) {
      $fundraising->cover_image = $imagePath;
    }
    $fundraising->save();

    $message = "ID: $id\n"
      . "Title: $title\n"
      . "Description: $description\n"
      . "Category ID: $categoryId\n"
      . "Cover image imagePath:" . $fundraising->cover_image . "\n"
      . "Cover image URL: " . Storage::url($fundraising->cover_image);

    return json_encode(array(
      'status' => 'ok',
      'message' => $message,
    ));
  } catch (Exception $e) {
    return json_encode(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ));
  }
});

Route::delete('/fundraising', function (Request $request) {
  try {
    $id = $request->id;
    $fundraising = Fundraising::find($id);
    $fundraising->delete();

    return json_encode(array(
      'status' => 'ok',
      'message' => 'success',
    ));
  } catch (Exception $e) {
    return json_encode(array(
      'status' => 'error',
      'message' => $e->getMessage(),
    ));
  }
});
