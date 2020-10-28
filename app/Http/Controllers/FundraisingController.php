<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use Illuminate\Http\Request;

class FundraisingController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $fundraisingCategoryList = FundraisingCategory::where('published', 1)
      ->orderBy('id', 'asc')->get();

    return view('fundraising', [
      'fundraisingCategoryList' => $fundraisingCategoryList,
    ]);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|max:255',
      'description' => 'required',
      'content' => 'required',
    ]);
  }
}
