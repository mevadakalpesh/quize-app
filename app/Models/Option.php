<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    //status
    public static $wrongStatus = 0;//default
    public static $rightStatus = 1;
    
    public function question(){
      return $this->belongsTo(Question::class,'id','question_id');
    }
}
