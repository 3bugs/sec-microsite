<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use Illuminate\Http\Request;

class ApiFundraisingController extends Controller
{
  private function createDataController()
  {
    return new _ApiDataController(
      Fundraising::class,
      FundraisingCategory::class,
      'fundraisings',
      'fundraising_categories',
      'public/fundraising',
    );
  }

  public function index(Request $request)
  {
    $apiDataController = $this->createDataController();
    return $apiDataController->index($request);
  }

  public function store(Request $request)
  {
    $apiDataController = $this->createDataController();
    return $apiDataController->store($request);
  }

  public function storeUploadFile(Request $request)
  {
    $apiDataController = $this->createDataController();
    return $apiDataController->storeUploadFile($request);
  }

  public function update(Request $request)
  {
    $apiDataController = $this->createDataController();
    return $apiDataController->update($request);
  }

  public function destroy(Request $request)
  {
    $apiDataController = $this->createDataController();
    return $apiDataController->destroy($request);
  }
}
