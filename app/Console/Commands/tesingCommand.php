<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Console\Command;

class tesingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:api';

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
        $id=merchantsController::createIdentityMerchantMinReq(config("app.api_username"),config("app.api_password"),
        12000000,
"San Mateo",
"USA",
"CA",
"Apartment 8",
"741 Douglass St",
"94114",
"Finix Flowers",
"+1 (408) 756-4497",
"123456789",
"INDIVIDUAL_SOLE_PROPRIETORSHIP",
"Finix Flowers",
1978,
27,
6,
"Finix Flowers",
"user@example.org",
"John",
true,
1978,
27,
6,
"Smith",
1200000,
1000000,
"4900",
"PRIVATE",
"San Mateo",
"USA",
"CA",
"Apartment 7",
"741 Douglass St",
"94114",
"14158885080",
"50",
"123456789",
"CEO",
"https://www.finix.com");
        var_dump($id[0]);
        $id=json_decode($id[0],true)['id'];
        merchantsController::createBankAccount(config("app.api_username"),config("app.api_password"),
        "123123123","SAVINGS","123123123",$id,"John Smith","BANK_ACCOUNT");
        $merchant=merchantsController::createAMerchantMinReq(config("app.api_username"),config("app.api_password"),$id,merchantsController::$processors[0]);
        var_dump($merchant[0]);
        $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),"byersolomon@mail.com");
        var_dump($id[0]);
        $id=json_decode($id[0],true)['id'];
        $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
        12,2029,$id,"John Smith","5200828282828210","022","PAYMENT_CARD");
        var_dump($card[0]);
        $card=json_decode($card[0],true)['id'];
        $merchant=json_decode($merchant[0],true)['id'];
        $payment=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),$merchant,"USD",2000,$card);
        var_dump($payment[0]);
        return 0;
    }
}
