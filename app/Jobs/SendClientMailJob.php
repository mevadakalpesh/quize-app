<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendClientMail;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

class SendClientMailJob implements ShouldQueue
{
  use Dispatchable,
  InteractsWithQueue,
  Queueable,
  SerializesModels;

  public $email;
  public $data;
  public $requestData;
  /**
  * Create a new job instance.
  */
  public function __construct($email,$data,$requestData) {
    $this->email = $email;
    $this->data = $data;
    $this->requestData = $requestData;
  }

  /**
  * Execute the job.
  */
  public function handle(): void
  {
    Mail::to($this->email)->send(new SendClientMail($this->data,$this->requestData));
  }
}