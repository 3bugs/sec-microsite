<?php

namespace App\Http\Controllers;

use App\Models\MediaCategory;
use Illuminate\Http\Request;

class MediaController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $mediaCategoryList = MediaCategory::where('published', 1)
      ->orderBy('id', 'asc')->get();

    return view('media', [
      'mediaCategoryList' => $mediaCategoryList,
    ]);
  }
}
