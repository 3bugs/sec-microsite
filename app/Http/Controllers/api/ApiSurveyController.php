<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SurveyResult;
use Illuminate\Http\Request;

class ApiSurveyController extends Controller
{
  public function __construct()
  {
    app('debugbar')->disable();
  }

  public function store(Request $request)
  {
    try {
      $surveyResult = new SurveyResult;
      $surveyResult->ip = \Request::ip();
      $surveyResult->result = $request->result;
      $surveyResult->save();

      return response()->json(array(
        'status' => 'ok',
        'message' => '',
      ), 200);
    } catch (Exception $e) {
      return response()->json(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ), 200);
    }
  }
}
