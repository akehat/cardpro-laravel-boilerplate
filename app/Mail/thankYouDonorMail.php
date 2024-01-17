<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class thankYouDonorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $request;
    public $usdAmount;
    public $feeAmount=0;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$request,$usdAmount,$feeAmount=0)
    {
        $this->details = $details;
        $this->request = $request;
        $this->usdAmount = $usdAmount;
        $this->feeAmount = $feeAmount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from ' . config('app.company_name'))
                    ->view('email.thankYouDonorMail');
    }
}
