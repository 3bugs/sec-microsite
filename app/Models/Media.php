<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  use HasFactory;

  public function mediaCategory()
  {
    return $this->belongsTo(MediaCategory::class, 'category_id', 'id');
  }
}
