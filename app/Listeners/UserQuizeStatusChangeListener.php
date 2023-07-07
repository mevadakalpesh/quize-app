<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuizeDetails;

class UserQuizeStatusChangeListener
{

  /**
  * Create the event listener.
  */
  public function __construct() {}

  /**
  * Handle the event.
  */
  public function handle(object $event): void
  {

    if (!blank($event->status)) {
      UserQuizeDetails::updateOrCreate([
        'quize_id' => $event->quize,
        'user_id' => Auth::user()->id
      ], [
        'quize_id' => $event->quize,
        'status' => $event->status,
        'user_id' => Auth::user()->id
      ]);
    } else {
      info('UserQuizeStatusChangeListener', ['quize not found']);
    }

  }
}