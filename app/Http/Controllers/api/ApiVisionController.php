<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiVisionController extends Controller
{
  public function __construct()
  {
    app('debugbar')->disable();
  }

  public function index(Request $request)
  {
    try {
      $vision = Vision::first();

      return json_encode(array(
        'status' => 'ok',
        'data' => $vision,
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
      $currentVision = Vision::first();
      $vision = null;
      if ($currentVision == null) {
        $vision = new Vision;
      } else {
        $vision = Vision::find($currentVision->id);
      }
      $vision->content = $request->content_data;
      $vision->save();

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

  public function storeUploadFile(Request $request)
  {
    try {
      $imagePath = $request->file('upload')->store('public/vision');
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
