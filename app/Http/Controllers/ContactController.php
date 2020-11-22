<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    return view('contact', [
    ]);
  }

  public function store(Request $request)
  {
    /*$this->validate($request, [
      'title' => 'required|max:255',
      'description' => 'required',
      'content' => 'required',
    ]);*/

    try {
      $contact = new Contact;
      $contact->name = $request->name;
      $contact->email = $request->email;
      $contact->phone = $request->phone;
      $contact->message = $request->message;
      $contact->save();
      //return redirect('/contact');
      return view('contact', [
        'formSubmitSuccess' => true,
      ]);
    } catch (Exception $e) {
      return view('contact', [
        'formSubmitSuccess' => false,
        'errorMessage' => $e->getMessage(),
      ]);
    }
  }
}
