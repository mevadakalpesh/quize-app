<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function question() {
    return $this->belongsToMany(
      Question::class,
      'question_categories',
      'category_id',
      'question_id',
      );
  }
}
