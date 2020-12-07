<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  use HasFactory;

  protected $casts = ['id' => 'integer', 'published' => 'integer', 'sort_index' => 'integer'];
}
