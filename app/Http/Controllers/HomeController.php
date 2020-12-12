<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Media;
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
      array(
        'id' => 1,
        'title' => 'สำรวจตัวเอง',
        'text' => 'ช่องทางระดมทุนไหนที่ตอบโจทย์ความต้องการของท่านมากที่สุด ? ท่านสามารถหาคำตอบได้ด้วยตัวของท่านเอง โดยใช้เวลาเพียงน้อยนิดผ่านการตอบคำถามเพียงไม่กี่ข้อ ถ้าพร้อมแล้ว มาหาคำตอบช่องทางระดมทุนของท่านกันเลย',
        'buttonText' => 'เริ่มแบบสำรวจ',
        'buttonMarginTop' => 25,
      ),
      array(
        'id' => 2,
        'title' => 'เครื่องมือระดมทุน',
        'text' => 'สำหรับท่านที่ต้องการระดมเงินทุนผ่านตลาดทุน โดยเฉพาะอย่างยิ่งหากท่านเป็นผู้ประกอบการ SME หรือ Startup ต้องทำความรู้จักกับ “ผลิตภัณฑ์” ซึ่งถือเป็นเครื่องมือที่จะเสนอขายให้แก่ผู้ลงทุน และช่วยให้ท่านได้มาซึ่งเงินทุนสำหรับนำไปใช้ดำเนินธุรกิจหรือขยายกิจการต่อไป',
        'buttonText' => 'ดูเพิ่มเติม',
        'buttonMarginTop' => 20,
      ),
      array(
        'id' => 3,
        'title' => 'แหล่งข้อมูลระดมทุน',
        'text' => 'ท่านสามารถรับชมคลิปวิดีโอที่มีเนื้อหาเกี่ยวข้องกับการระดมทุนในรูปแบบต่าง ๆ ตามที่ท่านต้องการได้ โดยในแต่ละหัวข้อจะแบ่งออกเป็นเรื่องย่อยที่มีเนื้อหาเกี่ยวข้องกัน เพื่อท่านเห็นภาพกระบวนการระดมทุนในหลากหลายรูปแบบได้อย่างชัดเจนมากยิ่งขึ้น',
        'buttonText' => 'ดูเพิ่มเติม',
        'buttonMarginTop' => 20,
      ),
      array(
        'id' => 4,
        'title' => 'SEC Event',
        'text' => 'ปฏิทินกิจกรรมที่น่าสนใจสำหรับผู้ประกอบการ SMEs และ Startups ที่จัดขึ้นในหลากหลายรูปแบบ อาทิ งานสัมมนา Webinar Business Matching และ คลินิกระดมทุน',
        'buttonText' => 'ดูเพิ่มเติม',
        'buttonMarginTop' => 20,
      ),
      array(
        'id' => 5,
        'title' => 'คลินิกระดมทุน',
        'text' => 'สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์<br><i class="fa fa-envelope"></i> 333/3 ถนนวิภาวดีรังสิต แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร 10900<br><i class="fa fa-phone"></i> 1207 กด 4',
        'buttonText' => 'ดูเพิ่มเติม',
        'buttonMarginTop' => 20,
      ),
      array(
        'id' => 6,
        'title' => 'ก.ล.ต. กับ SMEs',
        'text' => 'สำนักงาน ก.ล.ต. มีพันธกิจสำคัญในการช่วยส่งเสริมและพัฒนาศักยภาพผู้ประกอบการ SMEs และ Startups เพื่อให้สามารถเข้าถึงแหล่งเงินทุนจากตลาดทุนได้เช่นเดียวกับกิจการขนาดใหญ่ รวมถึงมีเครื่องมือที่หลากหลายให้เลือกใช้ได้อย่างเหมาะสม',
        'buttonText' => 'ดูเพิ่มเติม',
        'buttonMarginTop' => 20,
      ),
    );

    $bannerList = Banner::where('published', 1)
      ->orderBy('sort_index', 'asc')
      ->get();

    $eventCategoryList = EventCategory::orderBy('id', 'asc')
      ->get();

    $eventList = Event::where('published', 1)
      //->whereDate('begin_date', '>=', Carbon::today())
      ->where('pinned', 1)
      ->orderBy('begin_date', 'desc')
      ->get();
    foreach ($eventList as $event) {
      $event->cover_image = Storage::url($event->cover_image);
      $event->begin_day = explode('-', $event->begin_date)[2];
      $event->begin_month = Utils::getShortMonthName($event->begin_date);
      $event->begin_date_display = Utils::formatDisplayDate($event->begin_date);
      $event->end_date_display = Utils::formatDisplayDate($event->end_date);
    }

    $mediaList = Media::where('published', 1)
      ->where('category_id', '>', 2)
      ->offset(0)
      ->limit(6)
      ->get();
    foreach ($mediaList as $media) {
      $media->cover_image = Storage::url($media->cover_image);
    }

    return view('home', [
      'bannerList' => $bannerList,
      'cardDataList' => $cardDataList,
      'eventCategoryList' => $eventCategoryList,
      'eventList' => $eventList,
      'mediaList' => $mediaList,
    ]);
  }
}
