<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;

class ApiMediaController extends Controller
{
  private function createDataController()
  {
    return new _ApiDataController(
      Media::class,
      MediaCategory::class,
      'media',
      'media_categories',
      'public/media',
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
