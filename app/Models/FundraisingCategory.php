<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundraisingCategory extends Model
{
  use HasFactory;

  protected $casts = ['id' => 'integer', 'published' => 'integer', 'sort_index' => 'integer'];

  public function fundraisings()
  {
    return $this->hasMany(Fundraising::class, 'category_id', 'id')
      ->where('fundraisings.published', '=', 1)
      ->orderBy('fundraisings.category_id', 'asc')
      ->orderBy('fundraisings.sort_index', 'asc');
  }
}
