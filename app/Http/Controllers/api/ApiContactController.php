<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ApiContactController extends Controller
{
  public function __construct()
  {
    app('debugbar')->disable();
  }

  public function index(Request $request)
  {
    try {
      $contactList = Contact::orderBy('id', 'asc')->get();
      $unseenCount = Contact::where('seen', 0)->count();

      return json_encode(array(
        'status' => 'ok',
        'data_list' => $contactList,
        'unseen_count' => $unseenCount,
      ));
    } catch (Exception $e) {
      return json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ));
    }
  }

  public function update(Request $request)
  {
    try {
      $contact = Contact::find($request->id);
      if ($request->has('seen')) {
        $contact->seen = $request->seen;
      }
      $contact->save();

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

  public function destroy(Request $request)
  {
    try {
      $id = $request->id;
      $category = Contact::find($id);
      $category->delete();

      return response()->json(array(
        'status' => 'ok',
        'message' => 'success',
      ), 200);
    } catch (Exception $e) {
      return response()->json(array(
        'status' => 'error',
        'message' => $e->getMessage(),
      ), 200);
    }
  }
}
