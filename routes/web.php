<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  $cardDataList = array(
    array('id' => 1, 'buttonText' => 'สำรวจตัวเอง', 'buttonMarginTop' => 25),
    array('id' => 2, 'buttonText' => 'เครื่องมือระดมทุน', 'buttonMarginTop' => 25),
    array('id' => 3, 'buttonText' => 'แหล่งข้อมูลระดมทุน', 'buttonMarginTop' => 25),
    array('id' => 4, 'buttonText' => 'SEC Event', 'buttonMarginTop' => 25),
    array('id' => 5, 'buttonText' => 'คลินิกระดมทุน', 'buttonMarginTop' => 5),
    array('id' => 6, 'buttonText' => 'ก.ล.ต. กับ SMEs', 'buttonMarginTop' => 25),
  );
  return view('index', [
    'cardDataList' => $cardDataList,
  ]);
});

Route::get('/survey', function () {
  return view('survey');
});

/*Route::get('/fundraising', function () {
  return view('fundraising');
});*/

Route::get('/fundraising', [FundraisingController::class, 'index']);
Route::get('/fundraising/{fundraising}', [FundraisingController::class, 'show']);

Route::get('/media', [MediaController::class, 'index']);
Route::get('/media/{media}', [MediaController::class, 'show']);

Route::get('/event', [EventController::class, 'index']);
Route::get('/event/{event}', [EventController::class, 'show']);

Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/admin', function () {
  return redirect('/admin/dashboard');
});
Route::get('/admin/{any}', function () {
  app('debugbar')->disable();
  return view('admin');
})->where('any', '.*');

Route::get('/testfile', function () {
  return view('testfile');

  /*$testFiles = TestFile::orderBy('id', 'asc')->get();
  return json_encode(array(
    'data_list' => $testFiles,
  ));*/
});
Route::post('/testfile', function (Request $request) {
  $path = $request->file('myFile')->store('avatars');
  return 'PATH: '.$path.'<br>'.'myText: '.$request->myText;
});

/*Route::get('/', function () {
  $tasks = Task::orderBy('created_at', 'asc')->get();
  return view('tasks', [
    'tasks' => $tasks,
  ]);
});

Route::post('/task', function (Request $request) {
  $validator = Validator::make($request->all(), [
    'name' => 'required|max:255',
  ]);

  if ($validator->fails()) {
    return redirect('/')
      ->withInput()
      ->withErrors($validator);
  }

  // Create the task
  $task = new Task;
  $task->name = $request->name;
  $task->save();

  return redirect('/');
});

Route::delete('/task/{id}', function ($id) {
  Task::findOrFail($id)->delete();

  return redirect('/');
});*/
