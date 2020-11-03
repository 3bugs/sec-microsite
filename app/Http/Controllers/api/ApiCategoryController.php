<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\FundraisingCategory;
use App\Models\MediaCategory;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
  private $mCategoryModelClass;

  public function __construct()
  {
    app('debugbar')->disable();

    switch (Request()->route()->getPrefix()) {
      case 'api/fundraising-category':
        $this->mCategoryModelClass = FundraisingCategory::class;
        break;
      case 'api/media-category':
        $this->mCategoryModelClass = MediaCategory::class;
        break;
    }
  }

  public function index(Request $request)
  {
    try {
      $categoryList = ($this->mCategoryModelClass)::orderBy('id', 'asc')->get();

      return json_encode(array(
        'status' => 'ok',
        'data_list' => $categoryList,
      ));
    } catch (Exception $e) {
      return json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ));
    }
  }

  public function store(Request $request)
  {
    try {
      $title = $request->title;
      $description = $request->description;

      $category = new $this->mCategoryModelClass;
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
  }

  public function update(Request $request)
  {
    try {
      $category = ($this->mCategoryModelClass)::find($request->id);
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
  }

  public function destroy(Request $request)
  {
    try {
      $id = $request->id;
      $category = ($this->mCategoryModelClass)::find($id);
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
  }
}
