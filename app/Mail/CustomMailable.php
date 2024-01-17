<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    /**
     * Create a new message instance
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	//    return $this->view('email');
	    return $this->subject($this->email->title)->view('email.email',['contact'=>$this->email->title]);
    }
}
