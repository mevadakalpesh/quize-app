<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $casts = [
    'created_at' => 'date:Y-m-d',
  ];

  //status
  public static $deactiveStatus = 0;
  public static $activeStatus = 1; //default


  public function category() {
    return $this->belongsToMany(
      Category::class,
      'question_categories',
      'question_id',
      'category_id');
  }
  
  public function options() {
    return $this->hasMany(Option::class,'question_id','id');
  }

}