<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendClientMail extends Mailable
{
  use Queueable,
  SerializesModels;
  public $data;
  public $requestData;
  /**
  * Create a new message instance.
  */
  public function __construct($data, $requestData) {
    $this->data = $data;
    $this->requestData = $requestData;
  }

  /**
  * Get the message envelope.

  public function envelope(): Envelope
  {
  return new Envelope(
  subject: $this->data->subject,
  );
  }

  /**
  * Get the message content definition.

  public function content(): Content
  {
  return new Content(
  markdown: 'mail.send-client-mail',
  );
  }

  /**
  * Get the attachments for the message.
  *
  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
  */
  public function build() {
    $mail = $this->subject($this->data->subject);
    if ($this->requestData['status'] == true) {
      $mail->markdown('mail.send-client-mail');
    } else {
      $mail->text('mail.normalMail'); // Plain text content
    }
    return $mail;
  }

  public function attachments(): array
  {
    return [];
  }
}