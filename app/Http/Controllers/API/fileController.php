<?php

namespace App\Http\Controllers\API;

use CURLFile;
use Illuminate\Http\Request;

class fileController extends Controller
{
    public static function createFileString($filePath){
        return file_get_contents($filePath);
    }

static $fileTypes=['DRIVERS_LICENSE_FRONT',
"DRIVERS_LICENSE_BACK",
"IDENTIFICATION_CARD_FRONT",
"IDENTIFICATION_CARD_BACK",
"BANK_STATEMENT",
"TAX_DOCUMENT",
"BUSINESS_REGISTRATION",
"BUSINESS_ADDRESS_VERIFICATION",
"OTHER",
"PCI_DOCUMENT",
"PASSPORT",];
    public static function createFile(
        $username,
        $password,
        $display_name,
        $linked_to,//The resource ID that you want linked to the File (e.g. Merchant ID)
        $tags,
        $type,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "display_name" => $display_name,
            "linked_to" => $linked_to,
            "tags" => $tags,
            "type" => $type
        ];
        $data=array_merge($data,$addedData);
        // Encode the array to JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listAllFiles(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchAfile(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function listAllexternalLinks(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id/external_links".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    static $externalLinkTypes=["UPLOAD","DOWNLOAD","VIEW"];
    public static function createExternalLink(
        $username,
        $password,
        $duration,
        $type,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "duration" => $duration,
            "type" => $type
        ];
        $data=array_merge($data,$addedData);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id/external_links".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function uploadDirectly(
        $username,
        $password,
        $filePath,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id/upload".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data',
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile($filePath),
        ]);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function downloadFile(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id/download".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchExternalFile(
        $username,
        $password,
        $id,
        $externalLinkID,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/files/$id/external_links/$externalLinkID".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //not sure but updates info about customers
    public static function createInstramentUpdate(
        $username,
        $password,
        $merchant,
        $idempotency_id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $requestData = [
            'merchant' => $merchant,
            'idempotency_id' => $idempotency_id,
        ];
        $data = [
            'request' => $requestData,
        ];
        $jsonData = json_encode(array_merge($data,$addedData), JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/instrument_updates".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data',
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
    public static function downloadInstramentUpdates(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/instrument_updates/$id/download".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchInstramentUpdate(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/instrument_updates/$id/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
        return [$response,$httpcode];;
    }
}
