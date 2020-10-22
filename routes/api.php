<?php

use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
  $fundraisingList = Fundraising::orderBy('id', 'asc')->get();
  $fundraisingCategoryList = FundraisingCategory::orderBy('id', 'asc')->get();

  //return $fundraisingList->toJson();

  return json_encode(array(
    'status' => 'ok',
    'data_list' => $fundraisingList,
    'category_list' => $fundraisingCategoryList,
  ));
});
