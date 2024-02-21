<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\webhooksController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class registerWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $type='BASIC';
        $username=config("app.api_webhook_username");
        $password=config("app.api_webhook_password");
        URL::forceRootUrl(config('app.full_home_url'));
        $addedData=[
            "authentication" => [
                "type" => $type,
                "basic" => [
                    "username" => $username,
                    "password" => $password,
                    ],
                ],
                'url' => url('/api/webhook'),
            ];

        $result=webhooksController::createAWebhook(config("app.api_username"),config("app.api_password"),$type,url('/api/webhook'),'https://finix.sandbox-payments-api.com',[],$addedData);
        var_dump($result);
        var_dump(url('/api/webhook'));
        // $type='BASIC';
        // $username=config("app.api_webhook_username");
        // $password=config("app.api_webhook_password");
        // $addedData=[
        //     "authentication" => [
        //         "type" => $type,
        //         "basic" => [
        //             "username" => $username,
        //             "password" => $password,
        //             ],
        //         ],
        //     ];
        // URL::forceRootUrl(config('app.full_home_url'));
        // webhooksController::createAWebhook(config("app.api_username"),config("app.api_password"),$type,url('/api/webhook/live'),'https://finix.live-payments-api.com',[],$addedData);

        return 0;
    }
}
