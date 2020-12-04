<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaCategory;
use \Validator;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    /*$mediaCategoryList = MediaCategory::where('published', 1)
      ->orderBy('id', 'asc')
      ->get();

    return view('media', [
      'mediaCategoryList' => $mediaCategoryList,
    ]);*/

    $validator = Validator::make($request->all(), [
      'searchTerm' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('/search')
        ->withInput()
        ->withErrors($validator);
    } else {
      $isCheckFundraising = $request->has('fundraisingCheck');
      $isCheckMedia = $request->has('mediaCheck');
      $isCheckEvent = $request->has('eventCheck');

      $mediaCategoryList = MediaCategory::where('published', 1)
        ->orderBy('id', 'asc')
        ->get();

      return view('search', [
        'mediaCategoryList' => $mediaCategoryList,
        'fundraisingCheck' => $isCheckFundraising,
        'mediaCheck' => $isCheckMedia,
        'eventCheck' => $isCheckEvent,
      ]);
    }
  }
}
