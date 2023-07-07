<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
  //quize_status
  
  public static $completedStatus = 0;
  public static $runningStatus = 1; 
  
  /***
   * public function getStatusAttribute(){
    return $this->attributes['status'] == self::$activeStatus  ? 'Active' :
    'Deactive';
  }
  */
  
  
  public function getQuizeStatusAttribute(){
    return $this->attributes['quize_status'] == self::$completedStatus  ? 'Completed' : 'Running';
  }
  
  public function category(){
    return $this->belongsToMany(Category::class,QuizeCategory::class,'quize_id','category_id');
  }
  
  public function users(){
    return $this->belongsToMany(User::class,QuizeUser::class,'quize_id','user_id');
  }
  
  public function questions(){
    return $this->belongsToMany(Question::class,QuizeQuestion::class,'quize_id','question_id');
  }
  
  public function attemptuser(){
    return $this->hasMany(UserQuizeHistory::class,'quize_id','id');
  }
  
  public function quizeUserDetails(){
    return
    $this->hasOne(UserQuizeDetails::class,'quize_id','id')
    ->withDefault(['status' => UserQuizeDetails::$Pending]);
  }
  
}