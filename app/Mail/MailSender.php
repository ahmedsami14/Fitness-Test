<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSender extends Mailable
{
    use Queueable, SerializesModels;
    
    public $message;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message , $path = null)
    {
        $this->message = $message;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
        ->subject('Mail Sender')
        ->view('emails.mail_sender')
        ->with(['customMessage' => $this->message]);
        return $email;
    }
}