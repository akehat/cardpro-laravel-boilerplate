<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class GlobalMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $viewPath;
    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($viewPath, $mailData)
    {
        $this->viewPath = $viewPath;
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): GlobalMailer
    {
        // Log::debug(__FILE__ . '::' . __FUNCTION__);
        // Log::debug('$this->mailData->to_email: ' . $this->mailData->to_email);
        // Log::debug('$this->mailData->from_email: ' . $this->mailData->from_email);
        // Log::debug('$this->viewPath: ' . print_r($this->viewPath,1));

        if( $this->mailData->type === 'contact_us') {
            return $this->view($this->viewPath)->with([
                'mailData' => $this->mailData
            ])->from($this->mailData->from_email, $this->mailData->from_name)
            ->subject($this->mailData->title);
        }else {
            return $this->view($this->viewPath)->with([
                'mailData' => $this->mailData
            ])->from(config('app.from_mail'), config('app.name'))
                ->subject($this->mailData->title);
        }
    }
    // {
    //     return $this->view($this->viewPath)->with([
    //         'mailData' => $this->mailData
    //     ])->from($this->mailData->from_email, $this->mailData->from_name)
    //     ->subject($this->mailData->title);
    // }
}
