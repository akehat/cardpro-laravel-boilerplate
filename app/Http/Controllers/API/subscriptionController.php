<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class subscriptionController extends Controller
{
    public static function listSubscriptionSchedule(
        $username,
    $password,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchSubscriptionSchedule(
        $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createSubscriptionSchedule($username,
    $password,
    $line_item_type,
    $nickname,
    $interval_count,
    $hourly_interval,
    $subscription_type,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "line_item_type" => $line_item_type,
            "nickname" => $nickname,
            "fixed_time_interval_offset" => [
                "interval_count" => $interval_count,
                "hourly_interval" => $hourly_interval,
                ],
            "subscription_type" => $subscription_type,
            ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateSubscriptionSchedule($username,
    $password,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "tags" => $tags
            ];
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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


    public static function createSubscriptionAmount($username,
    $password,
    $id,
    $amount_type,
    $fee_amount,
    $fee_currency,
    $fee_label,
    $nickname,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "amount_type" => $amount_type,
            "fee_amount_data" => [
                "amount" => $fee_amount,
                "currency" => $fee_currency,
                "label" => $fee_label,
                ],
            "nickname" => $nickname,
            "tags" => $tags,
            ];
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateSubscriptionAmount($username,
    $password,
    $id,
    $amount_type,
    $fee_amount,
    $fee_currency,
    $fee_label,
    $nickname,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "amount_type" => $amount_type,
            "fee_amount_data" => [
                "amount" => $fee_amount,
                "currency" => $fee_currency,
                "label" => $fee_label,
                ],
            "nickname" => $nickname,
            "tags" => $tags,
            ];
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    //subscription amount

    public static function listSubscriptionAmounts(
        $username,
    $password,
    $sub_id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$sub_id/subscription_amounts/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
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

    public static function fetchSubscriptionAmount(
        $username,
    $password,
    $sub_id,
    $amount_id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$sub_id/subscription_amounts/$amount_id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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
    public static function deleteSubscriptionAmount(
        $username,
    $password,
    $sub_id,
    $amount_id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$sub_id/subscription_amounts/$amount_id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function listSubscriptionEnrollmentsOnASchedule(
        $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription/subscription_schedules/$id/subscription_enrollments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
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
    public static function createSubscriptionEnrollment($username,
    $password,
    $id,
    $merchant,
    $nickname,
    $started_at,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "merchant" => $merchant,
            "nickname" => $nickname,
            "started_at" => $started_at,
            "tags" => $tags
            ];
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_schedules/$id/subscription_enrollments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function updateSubscriptionEnrollment($username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            ];
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_enrollments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function listSubscriptionEnrollments(
        $username,
    $password,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_enrollments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchSubscriptionEnrollment(
        $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_enrollments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function deleteSubscriptionEnrollment(
        $username,
    $password,
    $id,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/subscription/subscription_enrollments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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
