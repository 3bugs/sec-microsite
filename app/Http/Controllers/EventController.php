<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    $highlightEventList = Event::select('id', 'category_id', 'cover_image', 'description', 'title', 'begin_date', 'end_date', 'begin_time', 'end_time')
      //->whereDate('begin_date', '>=', Carbon::today())
      //->where('pinned', 1)
      ->where('published', 1)
      ->orderBy('pinned', 'desc')
      ->orderBy('category_id', 'asc')
      ->orderBy('begin_date', 'desc')
      ->get();

    foreach ($highlightEventList as $event) {
      $event->cover_image = Storage::url($event->cover_image);
      $event->begin_day = explode('-', $event->begin_date)[2];
      $event->begin_month = Utils::getShortMonthName($event->begin_date);
      $event->begin_year = explode('-', $event->begin_date)[0];
      $event->begin_date_display = Utils::formatDisplayDate($event->begin_date);
      $event->end_date_display = Utils::formatDisplayDate($event->end_date);
    }

    return view('event', [
      //'categoryListByDate' => $categoryListByDate,
      'eventCategoryList' => $eventCategoryList,
      'eventList' => $eventList,
      'highlightEventList' => $highlightEventList,
    ]);
  }

  public function show($id)
  {
    $event = Event::find($id);

    $pattern = '#<figure class="media"><oembed url="(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?"></oembed></figure>#U';
    $event->content = preg_replace(
      $pattern,
      '<div class="col-12 wrap_video"><div><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div></div>',
      $event->content
    );

    $event->content = str_replace('<a href', '<a target="_blank" href', $event->content);

    return view('event-details', [
      'item' => $event,
    ]);
  }
}
