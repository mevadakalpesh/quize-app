<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quize extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $casts = [
    'created_at' => 'date:Y-m-d',
  ];
  //status
  public static $deactiveStatus = 0;
  public static $activeStatus = 1; //default

}