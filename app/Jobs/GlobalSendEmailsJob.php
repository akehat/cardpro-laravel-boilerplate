<?php

namespace App\Jobs;

use App\Mail\GlobalMailer;
use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Log;

class GlobalSendEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData;
    protected $viewPath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($viewPath, $mailData)
    {
        $this->viewPath = $viewPath;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug(__FILE__ . '::' . __FUNCTION__);
        // Log::debug('$this->mailData->to_email: ' . $this->mailData->to_email);
        // Log::debug('$this->mailData->from_email: ' . $this->mailData->from_email);

        //Mail::to(config('app.to_mail'))

        Mail::to($this->mailData->to_email)
            ->send(new GlobalMailer($this->viewPath, $this->mailData));

        Email::query()->findOrFail($this->mailData->id)->delete();
    }
}
