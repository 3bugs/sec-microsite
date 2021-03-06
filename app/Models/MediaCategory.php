<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
  use HasFactory;

  protected $casts = ['id' => 'integer', 'published' => 'integer', 'sort_index' => 'integer'];

  public function media()
  {
    return $this->hasMany(Media::class, 'category_id', 'id')
      ->where('media.published', '=', 1)
      ->orderBy('media.category_id', 'asc')
      ->orderBy('media.sort_index', 'asc');
  }
}
