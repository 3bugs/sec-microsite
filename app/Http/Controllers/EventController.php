<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    /*$classNameList = array(
      'seminar', 'webinar', 'business_matching', 'information',
    );

    $categoryListByDate = Event::groupBy('begin_date')
      ->selectRaw('begin_date, GROUP_CONCAT(DISTINCT category_id) AS category_id_list')
      ->get();
    foreach ($categoryListByDate as $row) {
      $categoryIdList = explode(',', $row->category_id_list);
      $classText = '';

      for ($i = 0; $i < sizeof($classNameList); $i++) {
        if (in_array(strval($i + 1), $categoryIdList)) {
          $classText .= $classNameList[$i] . ' ';
        }
      }
      $row->classes = trim($classText);
    }*/

    $eventCategoryList = EventCategory::where('published', 1)
      ->orderBy('id', 'asc')->get();

    $eventList = Event::select('category_id', 'begin_date', 'end_date')
      ->where('published', 1)
      ->orderBy('begin_date', 'asc')
      ->get();

    return view('event', [
      //'categoryListByDate' => $categoryListByDate,
      'eventCategoryList' => $eventCategoryList,
      'eventList' => $eventList,
    ]);
  }

  public function show($id)
  {
    $event = Event::find($id);

    $pattern = '#<figure class="media"><oembed url="(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?"></oembed></figure>#U';
    $event->content = preg_replace(
      $pattern,
      '<iframe src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
      $event->content
    );

    return view('event-details', [
      'item' => $event,
    ]);
  }
}
