<?php

namespace App\Jobs;

use App\Mail\CustomMailable;
use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->email->to_email)->send(
                new CustomMailable($this->email->to_email)
            );
            Log::channel('emails')->info(
                'Email sent to: ' .
                    $this->email->to_email .
                    ' with type of: ' .
                    $this->email->type .
                    ', with the title of: ' .
                    $this->email->title .
                    ', with the name of: ' .
                    $this->email->from_name .
                    ' and the content of: ' .
                    $this->email->content
            );
        } catch (\Swift_TransportException $e) {
            var_dump('Exception: ', $e);
        }

        $email = Email::find($this->email->id);

        $email->delete();
    }
}
