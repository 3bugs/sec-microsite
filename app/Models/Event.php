<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  use HasFactory;

  protected $casts = ['id' => 'integer', 'category_id' => 'integer', 'published' => 'integer', 'pinned' => 'integer'];

  public function eventCategory()
  {
    return $this->belongsTo(EventCategory::class, 'category_id', 'id');
  }
}
