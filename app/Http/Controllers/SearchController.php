<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Fundraising;
use App\Models\FundraisingCategory;
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

      $fundraisingList = null;
      $mediaList = null;
      $eventList = null;

      $searchTerm = trim($request->searchTerm);
      //$searchTermParts = preg_split('/\s+/', $searchTerm);

      if ($isCheckFundraising) {
        $fundraisingList = $this->doSearch(
          Fundraising::class,
          'fundraisingCategory',
          $searchTerm
        );
      }
      if ($isCheckMedia) {
        $mediaList = $this->doSearch(
          Media::class,
          'mediaCategory',
          $searchTerm
        );
      }
      if ($isCheckEvent) {
        $eventList = $this->doSearch(
          Event::class,
          'eventCategory',
          $searchTerm
        );
      }

      return view('search', [
        'searchTerm' => $searchTerm,
        'fundraisingList' => $fundraisingList,
        'mediaList' => $mediaList,
        'eventList' => $eventList,
        'isCheckFundraising' => $isCheckFundraising,
        'isCheckMedia' => $isCheckMedia,
        'isCheckEvent' => $isCheckEvent,
      ]);
    }
  }

  function doSearch($model, $category, $searchTerm): array
  {
    $rows = $model::where('published', 1)
      ->orderBy('created_at', 'desc')
      ->get();

    $dataList = array();
    foreach ($rows as $key => $data) {
      if ($data[$category]->published === 1 &&
        (strpos($data->title, $searchTerm) !== false
          || strpos($data->description, $searchTerm) !== false
          || strpos(strip_tags($data->content), $searchTerm) !== false)) {
        array_push($dataList, $data);
      }
    }

    return $dataList;
  }
}
