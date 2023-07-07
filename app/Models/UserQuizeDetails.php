<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizeDetails extends Model
{
  use HasFactory;
  protected $guarded = [];
  public static $Pending = 0;
  public static $Atttemted = 1;
  public static $Declined = 2;
  public static $Completed = 3;

  public function getStatusAttribute($value) {
    $status = 'Pending';
    switch ($value) {
      case '1':
        $status = 'Atttemted';
        break;
      case '2':
        $status = 'Declined';
        break;
      case '3':
        $status = 'Completed';
        break;
      default:
        $status = 'Pending';
        break;
    }
    return $this->attributes['status'] = $status;
  }
}