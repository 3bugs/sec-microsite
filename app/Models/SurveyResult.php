<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
  use HasFactory;

  //const UPDATED_AT = false;

  protected $casts = ['id' => 'integer'];
}
