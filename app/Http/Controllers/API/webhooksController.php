<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class webhooksController extends Controller
{
    public static function createAWebhook(
        $username,
        $password,
        $authenticationType, 
        $url,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]){
        $data = [
            'authentication' => [
                'type' => $authenticationType,
            ],
            'url' => $url,
        ];
        $data=array_merge($data,$addedData);
        // Encode the array to JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/webhooks".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/hal+json',
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
    public static function listWebhooks(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/webhooks".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchWebhooks(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/webhooks/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function updateWebhook(
        $username,
        $password,
        $id,
        $enabled,
        $url,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            'enabled' => $enabled,
            'url' => $url,
        ];
        $data=array_merge($data,$addedData);
        // Encode the array to JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/webhooks/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/hal+json',
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
    // public static function createADevice(
    //     $username,
    //     $password,
    //     $id,
    //     $allowDebit,
    //     $bypassDeviceOnCapture,
    //     $promptSignature,
    //     $description,
    //     $model,
    //     $name,
    //     $endpoint='https://finix.sandbox-payments-api.com',
    //     $addedQuery=[],
    //     $addedData=[]
    // ){
    //     // Create array
    //     $data = [
    //         "configuration" => [
    //             "allow_debit" => $allowDebit,
    //             "bypass_device_on_capture" => $bypassDeviceOnCapture,
    //             "prompt_signature" => $promptSignature
    //         ],
    //         "description" => $description,
    //         "model" => $model,
    //         "name" => $name
    //     ];
    //     $data=array_merge($data,$addedData);
    //     // Encode the array to JSON
    //     $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id/devices".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
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
}
