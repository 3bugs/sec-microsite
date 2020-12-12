<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

define('STORAGE_PATH', 'public/banner');

class ApiBannerController extends Controller
{
  public function __construct()
  {
    app('debugbar')->disable();
  }

  public function index(Request $request): JsonResponse
  {
    try {
      $bannerList = Banner::orderBy('id', 'asc')
        ->get();

      foreach ($bannerList as $banner) {
        $banner->image = Storage::url($banner->image);
      }

      return response()->json(array(
        'status' => 'ok',
        'data_list' => $bannerList,
      ));
    } catch (Exception $e) {
      return response()->json(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ));
    }
  }

  public function show($id): JsonResponse
  {
    try {
      $banner = Banner::find($id);
      if ($banner == null) {
        return response()->json(array(
          'status' => 'error',
          'message' => "ไม่พบข้อมูล id: $id",
        ), 200);
      }

      $banner->image = Storage::url($banner->image);

      return response()->json(array(
        'status' => 'ok',
        'data' => $banner,
      ), 200);
    } catch (Exception $e) {
      return response()->json(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ), 200);
    }
  }

  public function store(Request $request): JsonResponse
  {
    try {
      $imagePath = $request->file('image')->store(STORAGE_PATH);
      //$imageUrl = Storage::url($imagePath);

      $banner = new Banner;
      $banner->title = $request->title;
      $banner->url = $request->url;
      $banner->image = $imagePath;
      $banner->published = $request->published;
      $banner->save();

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

  public function update(Request $request): JsonResponse
  {
    try {
      $imagePath = null;
      if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store(STORAGE_PATH);
        //$imageUrl = Storage::url($imagePath);
      }

      $banner = Banner::find($request->id);
      if ($request->has('title')) {
        $banner->title = $request->title;
      }
      if ($request->has('url')) {
        $banner->url = $request->url;
      }
      if ($request->has('published')) {
        $banner->published = $request->published;
      }
      if ($imagePath != null) {
        $banner->image = $imagePath;
      }
      $banner->save();

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

  public function destroy(Request $request): JsonResponse
  {
    try {
      $id = $request->id;
      $banner = Banner::find($id);
      $banner->delete();

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
