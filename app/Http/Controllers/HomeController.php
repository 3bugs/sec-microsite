<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $cardDataList = array(
      array('id' => 1, 'buttonText' => 'สำรวจตัวเอง', 'buttonMarginTop' => 25),
      array('id' => 2, 'buttonText' => 'เครื่องมือระดมทุน', 'buttonMarginTop' => 25),
      array('id' => 3, 'buttonText' => 'แหล่งข้อมูลระดมทุน', 'buttonMarginTop' => 25),
      array('id' => 4, 'buttonText' => 'SEC Event', 'buttonMarginTop' => 25),
      array('id' => 5, 'buttonText' => 'คลินิกระดมทุน', 'buttonMarginTop' => 5),
      array('id' => 6, 'buttonText' => 'ก.ล.ต. กับ SMEs', 'buttonMarginTop' => 25),
    );

    $eventCategoryList = EventCategory::orderBy('id', 'asc')
      ->get();

    $eventList = Event::where('published', 1)
      ->whereDate('begin_date', '>=', Carbon::today())
      ->orderBy('begin_date', 'asc')
      ->orderBy('pinned', 'desc')
      ->get();

    foreach ($eventList as $event) {
      $event->cover_image = Storage::url($event->cover_image);
      $event->begin_day = explode('-', $event->begin_date)[2];
      $event->begin_month = Utils::getShortMonthName($event->begin_date);
      $event->begin_date_display = Utils::formatDisplayDate($event->begin_date);
      $event->end_date_display = Utils::formatDisplayDate($event->end_date);
    }

    return view('home', [
      'cardDataList' => $cardDataList,
      'eventCategoryList' => $eventCategoryList,
      'eventList' => $eventList,
    ]);
  }
}
