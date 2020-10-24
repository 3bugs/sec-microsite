<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundraising extends Model
{
  use HasFactory;

  public function fundraisingCategory()
  {
    return $this->belongsTo(FundraisingCategory::class, 'category_id', 'id');
  }
}
