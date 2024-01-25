<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class payfacController extends Controller
{
    // public static function createIdentityBuyer($username,
    // $password,
    // $city,
    // $country,
    // $region,
    // $line2,
    // $line1,
    // $postal_code,
    // $email,
    // $first_name,
    // $last_name,
    // $phone,
    // $tags,
    // $endpoint='https://finix.sandbox-payments-api.com',
    // $addedQuery=[],
    // $addedData=[]
    // ){
    //     // Define your data as an associative array
    //     $data = [
    //         "entity" => [
    //         "phone" => $phone,
    //         "first_name" => $first_name,
    //         "last_name" => $last_name,
    //         "email" => $email,
    //         "personal_address" => [
    //             "city" => $city,
    //             "country" => $country,
    //             "region" => $region,
    //             "line2" => $line2,
    //             "line1" => $line1,
    //             "postal_code" => $postal_code,
    //             ]
    //         ],
    //         "tags" => [
    //             $tags,
    //         ]
    //     ];

    //     // Encode the array to JSON
    //     $jsonData = json_encode(array_merge($data,$addedData));
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Accept: application/hal+json',
    //         'Content-Type: application/json',
    //         'Finix-Version: 2022-02-01',
    //     ]);
    //     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //     curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //     $response = curl_exec($ch);
    //     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);
    //     return [$response,$httpcode];
    // }
    public static function listApplicationProfiles(
        $username,
    $password,

    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/application_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function fetchApplicationProfile(
        $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/application_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }

public static function updateApplicationProfile(
    $username,
    $password,
    $id,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[
        "tags"=>$tags
    ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/application_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
//apllications
public static function listApplications(
    $username,
$password,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/applications".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchApplication(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/applications/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function updateApplications(
    $username,
    $password,
    $id,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[
        "tags"=>$tags
    ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/applications/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function createBalanceTransfer(
    $username,
    $password,
    $amount,
    $currency,
    $description,
    $destination,
    $processor_type,
    $source,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[
        "amount" => $amount,
        "currency" => $currency,
        "description" => $description,
        "destination" => $destination,
        "processor_type" => $processor_type,
        "source" => $source,
        "tags" => $tags,
        ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/balance_transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function listBalanceTransfers(
    $username,
$password,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/balance_transfers/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchBalanceTransfers(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/balance_transfers/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
//merchant profiles
public static function listMerchantProfiles(
    $username,
$password,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/merchant_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchMerchantProfile(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/merchant_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function updateMerchantProfile(
    $username,
    $password,
    $id,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[
        "tags" => $tags,
        ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/merchant_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
//payout profiles
public static function listPayoutProfiles(
    $username,
$password,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payout_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchPayoutProfile(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payout_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}

public static function updatePayoutProfile(
    $username,
    $password,
    $id,
    $type,
    $frequency,
    $submission_delay_days,
    $payment_instrument_id,
    $rail,
    $fees_frequency,
    $fees_day_of_month,
    $fees_submission_delay_days,
    $fees_payment_instrument_id,
    $fees_rail,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[
        "type" => $type,
        "gross" => [
            "payouts" => [
                "frequency" => $frequency,
                "submission_delay_days" => $submission_delay_days,
                "payment_instrument_id" => $payment_instrument_id,
                "rail" => $rail,
                ],
            "fees" => [
                "frequency" => $fees_frequency,
                "day_of_month" => $fees_day_of_month,
                "submission_delay_days" => $fees_submission_delay_days,
                "payment_instrument_id" => $fees_payment_instrument_id,
                "rail" => $fees_rail,
                ],
            ],
        ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payout_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function updatePayoutProfileWithAddedData(
    $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
){
    $data=[];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payout_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchPayoutProfileByMerchant(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id/payout_profile".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
//verifications
public static function listMerchantVerification(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id/verifications".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function listPaymentInstramentsVerification(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id/verifications".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function listVerifications(
    $username,
$password,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/verifications".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
public static function fetchVerifications(
    $username,
$password,
$id,
$endpoint='https://finix.sandbox-payments-api.com',
$addedQuery=[]
){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/verifications/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$response,$httpcode];
}
}
