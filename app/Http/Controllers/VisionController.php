<?php

namespace App\Http\Controllers;

use App\Models\Vision;
use Illuminate\Http\Request;

class VisionController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $vision = Vision::first();

    return view('vision', [
      'data' => $vision,
    ]);
  }
}
