<?php

namespace App\Http\Controllers\API;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
    public function webhookUpdateRoute(Request $request){
        Log::info($request);
        Log::info(collect($request->header())->transform(function ($item) {
            return $item[0];
        }));
        // if ($request->header('authorization')!==null) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        // // Extract the basic authentication credentials
        // $authHeader = $request->header('authorization');
        // list($type, $data) = explode(' ', $authHeader, 2);

        // // Check if the type is 'Basic'
        // if (strcasecmp($type, 'Basic') !== 0) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        // // Decode the base64-encoded credentials
        // $credentials = base64_decode($data);

        // // Extract the username and password
        // list($username, $password) = explode(':', $credentials, 2);
        $username=$request->header('php-auth-user');
        $password=$request->header('php-auth-pw');
        // Check if username and password match the expected values
        $expectedUsername = config('app.api_webhook_username');
        $expectedPassword = config('app.api_webhook_password');

        if ($username !== $expectedUsername || $password !== $expectedPassword) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $jsonData = $request->getContent();
        $eventData = json_decode($jsonData??[]);
        if(!empty($jsonData)){
            $modelsPath = app_path('Models');

            if (File::isDirectory($modelsPath)) {
                $files = File::allFiles($modelsPath);

                foreach ($files as $file) {
                    $modelClass = $this->getModelNamespace($file);
                    if(class_exists($modelClass) && isset($modelClass::$name) && isset($eventData->_embedded) && array_keys((array)$eventData->_embedded)[0]==$modelClass::$name){
                        foreach($eventData->_embedded->{$modelClass::$name} as $item){
                            $item=(object)$item;
                        if (method_exists($modelClass, 'updateFromId')) {
                            Log::info("Executing updateFromId on $modelClass");
                            try{
                            $modelClass::updateFromId($item->id);
                            }catch(Exception | Error $e){
                                Log::info($e->getMessage());
                            }
                        }
                        if (method_exists($modelClass, 'updateFromIds')) {
                            if($modelClass::$name == 'external_links' ){
                                Log::info("Executing updateFromId on $modelClass");
                                try{
                                $modelClass::updateFromIds($item->file_id,$item->file_id);
                                }catch(Exception | Error $e){
                                    Log::info($e->getMessage());
                                }
                            }
                        }
                        }
                    }
                }
            } else {
                Log::error("Models directory not found.");
            }
        }else{
            return response()->json(['message' => 'Empty Event Processed Successfully'], 200);

        }
            return response()->json(['message' => 'Event processed successfully'], 200);
    }
    public function webhookUpdateRouteLive(Request $request){
        Log::info($request);
        Log::info(collect($request->header())->transform(function ($item) {
            return $item[0];
        }));
        if ($request->header('authorization')!==null) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Extract the basic authentication credentials
        $authHeader = $request->header('authorization');
        list($type, $data) = explode(' ', $authHeader, 2);
        Log::info($authHeader);
        // Check if the type is 'Basic'
        if (strcasecmp($type, 'Basic') !== 0) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Decode the base64-encoded credentials
        $credentials = base64_decode($data);

        // Extract the username and password
        list($username, $password) = explode(':', $credentials, 2);

        // Check if username and password match the expected values
        $expectedUsername = config('app.api_webhook_username');
        $expectedPassword = config('app.api_webhook_password');

        if ($username !== $expectedUsername || $password !== $expectedPassword) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $jsonData = $request->getContent();
        $eventData = json_decode($jsonData);
            $modelsPath = app_path('Models');

            if (File::isDirectory($modelsPath)) {
                $files = File::allFiles($modelsPath);

                foreach ($files as $file) {
                    $modelClass = $this->getModelNamespace($file);
                    if(class_exists($modelClass) && isset($modelClass::$name) && array_keys((array)$eventData->_embedded)[0]==$modelClass::$name){
                        foreach($eventData->_embedded->{$modelClass::$name} as $item){
                            $item=(object)$item;
                        if (method_exists($modelClass, 'updateFromId_live')) {
                            Log::info("Executing updateFromId on $modelClass");
                            try{
                            $modelClass::updateFromId_live($item->id);
                            }catch(Exception | Error $e){
                                Log::info($e->getMessage());
                            }
                        }
                        if (method_exists($modelClass, 'updateFromIds_live')) {
                            if($modelClass::$name == 'external_links' ){
                                Log::info("Executing updateFromId on $modelClass");
                                try{
                                $modelClass::updateFromIds_live($item->file_id,$item->file_id);
                                }catch(Exception | Error $e){
                                    Log::info($e->getMessage());
                                }
                            }
                        }
                        }
                    }
                }
            } else {
                Log::error("Models directory not found.");
            }

            return response()->json(['message' => 'Event processed successfully'], 200);
    }
    protected function getModelNamespace($file)
    {
        $namespace = 'App\\Models';

        $class = pathinfo($file->getFilename(), PATHINFO_FILENAME);

        return $namespace . '\\' . $class;
    }
}
