<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $ip = \Request::ip();

    return view('test-ip', [
      'ip' => $ip,
    ]);
  }
}
