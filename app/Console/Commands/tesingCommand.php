<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\finixUsersController;
use App\Http\Controllers\API\payfacController;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiUser;
use App\Models\applications;
use App\Models\Email;
use App\Models\finix_payments;
use App\Models\identities;
use App\Models\payment_ways;
use App\Models\settlements;
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
//         $id=merchantsController::createIdentityMerchantMinReq(config("app.api_username"),config("app.api_password"),
//         12000000,
// "San Mateo",
// "USA",
// "CA",
// "Apartment 8",
// "741 Douglass St",
// "94114",
// "Finix Flowers",
// "+1 (408) 756-4497",
// "123456789",
// "INDIVIDUAL_SOLE_PROPRIETORSHIP",
// "Finix Flowers",
// 1978,
// 27,
// 6,
// "Finix Flowers",
// "user@example.org",
// "John",
// true,
// 1978,
// 27,
// 6,
// "Smith",
// 1200000,
// 1000000,
// "4900",
// "PRIVATE",
// "San Mateo",
// "USA",
// "CA",
// "Apartment 7",
// "741 Douglass St",
// "94114",
// "14158885080",
// "50",
// "123456789",
// "CEO",
// "https://www.finix.com");
//         var_dump($id[0]);
//         $id=json_decode($id[0],true)['id'];
//         merchantsController::createBankAccount(config("app.api_username"),config("app.api_password"),
//         "123123123","BUSINESS_SAVINGS","123123123",$id,"John Smith","BANK_ACCOUNT");
//         $merchant=merchantsController::createAMerchantMinReq(config("app.api_username"),config("app.api_password"),$id,merchantsController::$processors[0]);
//         var_dump($merchant[0]);
        // $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),"byersolomon@mail.com");
        // var_dump($id[0]);
        // $id=json_decode($id[0],true)['id'];
        // $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
        // 12,2029,$id,"John Smith","5200828282828210","022","PAYMENT_CARD");
        // var_dump($card[0]);
        // $card=json_decode($card[0],true)['id'];
        // // $merchant=json_decode($merchant[0],true)['id'];
        // $payment=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),"MUtq8ZsxgcqW7W3uBDSFypek","USD",2000,$card);
        // var_dump($payment[0]);
        // $ids=json_decode(merchantsController::listIdentities(config("app.api_username"),config("app.api_password"))[0],true);
        // $ids=array_filter($ids,function($var){return $var["business_name"] == "Finix Flowers";});
        // $app=json_decode(payfacController::listApplications(config("app.api_username"),config("app.api_password"))[0],true)["_embedded"]["applications"];
        // $new_user=finixUsersController::createAUser(config("app.api_username"),config("app.api_password"),$app[0]["id"]);

        // $update=finixUsersController::updateAuser(
        // config("app.api_username"),config("app.api_password"),
        // "US4yMeXtk92bgb1wcZQECRQz",
        // null,'https://finix.sandbox-payments-api.com',[],["role"=>"ROLE_MERCHANT"]);
        // var_dump($update[0]);
        // $result=finixUsersController::updateAuser(config("app.api_username"),config("app.api_password"),"US8ee88MDeR4hw4SzjaVpSWm",['updateing'=>"test"],'https://finix.sandbox-payments-api.com',[],["role"=>"merchant"]);
        // $result= merchantsController::listSettlements(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',['tags.key'=>'refund']);
        // var_dump(json_decode(payfacController::listApplications(config("app.api_username"),config("app.api_password"))[0])->_embedded->applications[0]->id);
        // $email= Email::create([
        //     'type' => 'Test Type',
        //     'from_name' => 'Test Sender',
        //     'from_email' => 'test.sender@example.com',
        //     'to_email' => 'byersolomon@gmail.com', // Replace with the desired email
        //     'content' => 'Test Content',
        //     'title' => 'Test Title',
        // ]);
        // $email->save();
        // $email->refresh();        identities::runUpdate();
        // var_dump(finix_payments::updateFromId('TRn1iw1UvQXhQh6oBkCzrnJC'));
//         $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/customers');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"apikey\":\"Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0\",\"email\":\"email@example.com\"}");

// $headers = array();
// $headers[] = 'Content-Type: application/json';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);
// var_dump($result);
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/customers/74');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);
// var_dump($result);
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/customers');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);
// var_dump($result);
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/customers');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/payment_ways');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
// ]);
// curl_setopt($ch, CURLOPT_POSTFIELDS, '{"apikey":"Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0","exp_month":"12","exp_year":"2029","name":"John Doe","card_number":"5200828282828210","cvv":331,"id":74}');

// $response = curl_exec($ch);

// curl_close($ch);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/payment_ways');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0',
// ]);

// $response = curl_exec($ch);

// curl_close($ch);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/payment_ways/56');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0',
// ]);

// $response = curl_exec($ch);

// curl_close($ch);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/payment_ways/search?search=APZmjWMcUWgvxGcBV3V6FJ7');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0',
// ]);

// $response = curl_exec($ch);

// curl_close($ch);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/charges');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
// ]);
// curl_setopt($ch, CURLOPT_POSTFIELDS, '{"apikey":"Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0","cardID":56,"amount":2000,"currency":"USD"}');

// $response = curl_exec($ch);

// curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/cardwiz/charges/search?search=TRh2kLF2dxdmrrNBGrm9fkx3');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: Api_key16Aqajyt5mcPqIqaAA5a4lCyPIM7n9BWz0',
]);

$response = curl_exec($ch);

curl_close($ch);
var_dump($response);
        return 0;
    }
}


