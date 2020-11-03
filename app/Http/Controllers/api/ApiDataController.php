<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiDataController extends Controller
{
  private $mModelClass, $mCategoryModelClass;
  private $mTableName, $mCategoryTableName;
  private $mStoragePath;

  /*public function __construct($modelClass, $categoryModelClass, $tableName, $categoryTableName, $storagePath, $enableDebugBar = false)
  {
    $this->mModelClass = $modelClass;
    $this->mCategoryModelClass = $categoryModelClass;
    $this->mTableName = $tableName;
    $this->mCategoryTableName = $categoryTableName;
    $this->mStoragePath = $storagePath;

    if (!$enableDebugBar) app('debugbar')->disable();
  }*/

  public function __construct()
  {
    app('debugbar')->disable();

    switch (Request()->route()->getPrefix()) {
      case 'api/fundraising':
        $this->mModelClass = Fundraising::class;
        $this->mCategoryModelClass = FundraisingCategory::class;
        $this->mTableName = 'fundraisings';
        $this->mCategoryTableName = 'fundraising_categories';
        $this->mStoragePath = 'public/fundraising';
        break;
      case 'api/media':
        $this->mModelClass = Media::class;
        $this->mCategoryModelClass = MediaCategory::class;
        $this->mTableName = 'media';
        $this->mCategoryTableName = 'media_categories';
        $this->mStoragePath = 'public/media';
        break;
    }
  }

  public function index(Request $request)
  {
    try {
      /*$dataList = DB::table('fundraisings')
        ->join('fundraising_categories', 'fundraisings.category_id', '=', 'fundraising_categories.id')
        ->select('fundraisings.*', 'fundraising_categories.title AS category_title')
        ->orderBy('id', 'desc')
        ->get();*/
      $dataList = DB::table($this->mTableName)
        ->join($this->mCategoryTableName, ($this->mTableName) . '.category_id', '=', ($this->mCategoryTableName) . '.id')
        ->select(($this->mTableName) . '.*', ($this->mCategoryTableName) . '.title AS category_title')
        ->orderBy('id', 'desc')
        ->get();

      foreach ($dataList as $data) {
        $data->cover_image = Storage::url($data->cover_image);
      }
      $categoryList = ($this->mCategoryModelClass)::orderBy('id', 'asc')->get();

      return response()->json(array(
        'status' => 'ok',
        'data_list' => $dataList,
        'category_list' => $categoryList,
      ), 200);
    } catch (Exception $e) {
      return response()->json(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ), 200);
    }
  }

  public function store(Request $request)
  {
    // imagePath: public/fundraising/xxx.jpg
    // imageUrl: /storage/fundraising/xxx.jpg
    try {
      $imagePath = $request->file('cover_image')->store($this->mStoragePath);
      $imageUrl = Storage::url($imagePath);
      $title = $request->title;
      $description = $request->description;
      $categoryId = $request->category_id;
      $content = $request->content_data;

      $data = new $this->mModelClass;
      $data->title = $title;
      $data->description = $description;
      $data->category_id = $categoryId;
      $data->cover_image = $imagePath;
      $data->content = $content;
      $data->save();

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
  }

  public function update(Request $request)
  {
    try {
      $imagePath = null;
      if ($request->hasFile('cover_image')) {
        $imagePath = $request->file('cover_image')->store($this->mStoragePath);
        $imageUrl = Storage::url($imagePath);
      }

      $data = ($this->mModelClass)::find($request->id);
      if ($request->has('title')) {
        $data->title = $request->title;
      }
      if ($request->has('description')) {
        $data->description = $request->description;
      }
      if ($request->has('category_id')) {
        $data->category_id = $request->category_id;
      }
      if ($request->has('content_data')) {
        $data->content = $request->content_data;
      }
      if ($request->has('published')) {
        $data->published = $request->published;
      }
      if ($imagePath != null) {
        $data->cover_image = $imagePath;
      }
      $data->save();

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
      $data = ($this->mModelClass)::find($id);
      $data->delete();

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

  public function storeUploadFile(Request $request)
  {
    try {
      $imagePath = $request->file('upload')->store($this->mStoragePath);
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
  }
}
