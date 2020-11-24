<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// https://stackoverflow.com/questions/31527050/laravel-5-controller-sending-json-integer-as-string
class Fundraising extends Model
{
  use HasFactory;

  protected $casts = ['id' => 'integer', 'category_id' => 'integer', 'published' => 'integer', 'pinned' => 'integer'];

  public function fundraisingCategory()
  {
    return $this->belongsTo(FundraisingCategory::class, 'category_id', 'id');
  }
}
