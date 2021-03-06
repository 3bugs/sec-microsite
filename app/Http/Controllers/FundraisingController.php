<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use App\Models\FundraisingCategory;
use Illuminate\Http\Request;

class FundraisingController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $fundraisingCategoryList = FundraisingCategory::where('published', 1)
      ->orderBy('id', 'asc')
      ->get();

    return view('fundraising', [
      'fundraisingCategoryList' => $fundraisingCategoryList,
    ]);
  }

  public function show($id)
  {
    $fundraising = Fundraising::find($id);

    /* link อันนี้มีปัญหา ทำให้ content ทั้งหมดไม่แสดงเลย
    <figure class="media"><oembed url="https://www.youtube.com/watch?v=54Z5DE25iZ0&amp;feature=emb_title"></oembed></figure>
     */

    $pattern = '#<figure class="media"><oembed url="(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?"></oembed></figure>#U';
    $fundraising->content = preg_replace(
      $pattern,
      '<div class="col-12 wrap_video"><div><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div></div>',
      $fundraising->content
    );

    $fundraising->content = str_replace('<a href', '<a target="_blank" href', $fundraising->content);

    return view('fundraising-details', [
      'item' => $fundraising,
    ]);
  }

  /*public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|max:255',
      'description' => 'required',
      'content' => 'required',
    ]);
  }*/
}
