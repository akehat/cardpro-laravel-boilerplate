<?php


namespace App\Console\Commands;

use App\Events\SendEmailEvent;
use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sendemails';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $viewPath = 'email.content';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $limit = (int) config('app.contact_us_email_limit', 10);
        Log::info('sending '.$limit.'emails');
        $emails = Email::query()->take($limit)->get();

        foreach ($emails as $email) {
            switch ($email->type) {
                case 'contact_us':
                    $this->viewPath = 'email.email';
                    break;
                default:
                    break;
            }
            event( new SendEmailEvent($this->viewPath, $email));
        }

        return 0;
    }
}
