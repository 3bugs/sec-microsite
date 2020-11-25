<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;

class MediaController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $mediaCategoryList = MediaCategory::where('published', 1)
      ->orderBy('id', 'asc')->get();

    return view('media', [
      'mediaCategoryList' => $mediaCategoryList,
    ]);
  }

  public function show($id)
  {
    $media = Media::find($id);

    $pattern = '#<figure class="media"><oembed url="(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?"></oembed></figure>#U';
    $media->content = preg_replace(
      $pattern,
      '<div class="col-12 wrap_video"><div><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div></div>',
      $media->content
    );

    $media->content = str_replace('<a href', '<a target="_blank" href', $media->content);

    return view('media-details', [
      'item' => $media,
    ]);
    /*if ($media->category_id > 2) {
      return view('media-details', [
        'item' => $media,
      ]);
    } else {
      return view('fundraising-details', [
        'item' => $media,
      ]);
    }*/
  }
}
