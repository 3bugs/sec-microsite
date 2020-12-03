<?php

namespace App\Utils;

class Utils
{
  public static function formatThaiDateTime($dateTimeString) {
  }

  public static function formatDisplayDate($dateString)
  {
    $dateParts = explode('-', $dateString);
    $day = $dateParts[2];
    $month = $dateParts[1];
    $year = $dateParts[0];
    //$year = intval($dateParts[0]) + 543;
    //$year %= 100; // เอาเฉพาะ 2 หลักท้าย
    return "${day}.${month}.${year}";
  }

  public static function getShortMonthName($dateString)
  {
    $monthNames = array(
      'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN',
      'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC',
    );
    $dartParts = explode('-', $dateString);
    return $monthNames[intval($dartParts[1]) - 1];
  }
}
