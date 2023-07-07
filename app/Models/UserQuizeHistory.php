<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizeHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public static $wrongStatus = 0;//default
    public static $rightStatus = 1;
    
    public function user(){
      return $this->hasOne(User::class,'id','user_id');
    }
}
