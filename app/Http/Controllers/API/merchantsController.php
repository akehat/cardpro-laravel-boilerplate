<?php

namespace App\Http\Controllers\API;

use CURLFile;
use Illuminate\Http\Request;

class merchantsController extends Controller
{
    //identities for making someone to payto
    //sample data
    // -d '{
    //     "additional_underwriting_data": {
    //       "annual_ach_volume": 200000,
    //       "average_ach_transfer_amount": 200000,
    //       "average_card_transfer_amount": 200000,
    //       "business_description": "SB3 vegan cafe",
    //       "card_volume_distribution": {
    //         "card_present_percentage": 30,
    //         "mail_order_telephone_order_percentage": 10,
    //         "ecommerce_percentage": 60
    //       },
    //       "credit_check_allowed": true,
    //       "credit_check_ip_address": "42.1.1.113",
    //       "credit_check_timestamp": "2021-04-28T16:42:55Z",
    //       "credit_check_user_agent": "Mozilla 5.0(Macintosh; IntelMac OS X 10 _14_6)",
    //       "merchant_agreement_accepted": true,
    //       "merchant_agreement_ip_address": "42.1.1.113",
    //       "merchant_agreement_timestamp": "2021-04-28T16:42:55Z",
    //       "merchant_agreement_user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6)",
    //       "refund_policy": "MERCHANDISE_EXCHANGE_ONLY",
    //       "volume_distribution_by_business_type": {
    //         "other_volume_percentage": 0,
    //         "consumer_to_consumer_volume_percentage": 0,
    //         "business_to_consumer_volume_percentage": 0,
    //         "business_to_business_volume_percentage": 100,
    //         "person_to_person_volume_percentage": 0
    //       }
    //     },
    //     "entity": {
    //       "annual_card_volume": 12000000,
    //       "business_address": {
    //         "city": "San Mateo",
    //         "country": "USA",
    //         "region": "CA",
    //         "line2": "Apartment 8",
    //         "line1": "741 Douglass St",
    //         "postal_code": "94114"
    //       },
    //       "business_name": "Finix Flowers",
    //       "business_phone": "+1 (408) 756-4497",
    //       "business_tax_id": "123456789",
    //       "business_type": "INDIVIDUAL_SOLE_PROPRIETORSHIP",
    //       "default_statement_descriptor": "Finix Flowers",
    //       "dob": {
    //         "year": 1978,
    //         "day": 27,
    //         "month": 6
    //       },
    //       "doing_business_as": "Finix Flowers",
    //       "email": "user@example.org",
    //       "first_name": "John",
    //       "has_accepted_credit_cards_previously": true,
    //       "incorporation_date": {
    //         "year": 1978,
    //         "day": 27,
    //         "month": 6
    //       },
    //       "last_name": "Smith",
    //       "max_transaction_amount": 1200000,
    //       "ach_max_transaction_amount": 1000000,
    //       "mcc": "4900",
    //       "ownership_type": "PRIVATE",
    //       "personal_address": {
    //         "city": "San Mateo",
    //         "country": "USA",
    //         "region": "CA",
    //         "line2": "Apartment 7",
    //         "line1": "741 Douglass St",
    //         "postal_code": "94114"
    //       },
    //       "phone": "14158885080",
    //       "principal_percentage_ownership": 50,
    //       "tax_id": "123456789",
    //       "title": "CEO",
    //       "url": "https://www.finix.com"
    //     },
    //     "tags": {
    //       "Studio Rating": "4.7"
    //     }'
    public static function createIdentityMerchant($username,
    $password,
    $annual_ach_volume,
    $average_ach_transfer_amount,
    $average_card_transfer_amount,
    $business_description,
    $card_present_percentage,
    $mail_order_telephone_order_percentage,
    $ecommerce_percentage,
    $credit_check_allowed,
    $credit_check_ip_address,
    $credit_check_timestamp,
    $credit_check_user_agent,
    $merchant_agreement_accepted,
    $merchant_agreement_ip_address,
    $merchant_agreement_timestamp,
    $merchant_agreement_user_agent,
    $refund_policy,
    $other_volume_percentage,
    $consumer_to_consumer_volume_percentage,
    $business_to_consumer_volume_percentage,
    $business_to_business_volume_percentage,
    $person_to_person_volume_percentage,
    $annual_card_volume,
    $city,
    $country,
    $region,
    $line2,
    $line1,
    $postal_code,
    $business_name,
    $business_phone,
    $business_tax_id,
    $business_type,
    $default_statement_descriptor,
    $year,
    $day,
    $month,
    $doing_business_as,
    $email,
    $first_name,
    $has_accepted_credit_cards_previously,
    $dob_year,
    $dob_day,
    $dob_month,
    $last_name,
    $max_transaction_amount,
    $ach_max_transaction_amount,
    $mcc,
    $ownership_type,
    $business_city,
    $business_country,
    $business_region,
    $business_line2,
    $business_line1,
    $business_postal_code,
    $phone,
    $principal_percentage_ownership,
    $tax_id,
    $title,
    $url,
    $tags,//assosiated array eg "Studio Rating": "4.7"
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            'additional_underwriting_data' => [
                'annual_ach_volume' => $annual_ach_volume,
                'average_ach_transfer_amount' => $average_ach_transfer_amount,
                'average_card_transfer_amount' => $average_card_transfer_amount,
                'business_description' => $business_description,
                'card_volume_distribution' => [
                    'card_present_percentage' => $card_present_percentage,
                    'mail_order_telephone_order_percentage' => $mail_order_telephone_order_percentage,
                    'ecommerce_percentage' => $ecommerce_percentage,
                ],
                'credit_check_allowed' => $credit_check_allowed,
                'credit_check_ip_address' => $credit_check_ip_address,
                'credit_check_timestamp' => $credit_check_timestamp,
                'credit_check_user_agent' => $credit_check_user_agent,
                'merchant_agreement_accepted' => $merchant_agreement_accepted,
                'merchant_agreement_ip_address' => $merchant_agreement_ip_address,
                'merchant_agreement_timestamp' => $merchant_agreement_timestamp,
                'merchant_agreement_user_agent' => $merchant_agreement_user_agent,
                'refund_policy' => $refund_policy,
                'volume_distribution_by_business_type' => [
                    'other_volume_percentage' => $other_volume_percentage,
                    'consumer_to_consumer_volume_percentage' => $consumer_to_consumer_volume_percentage,
                    'business_to_consumer_volume_percentage' => $business_to_consumer_volume_percentage,
                    'business_to_business_volume_percentage' => $business_to_business_volume_percentage,
                    'person_to_person_volume_percentage' => $person_to_person_volume_percentage,
                ],
            ],
            'entity' => [
                'annual_card_volume' => $annual_card_volume,
                'business_address' => [
                    'city' => $business_city,
                    'country' => $business_country,
                    'region' => $business_region,
                    'line2' => $business_line2,
                    'line1' => $business_line1,
                    'postal_code' => $business_postal_code,
                ],
                'business_name' => $business_name,
                'business_phone' => $business_phone,
                'business_tax_id' => $business_tax_id,
                'business_type' => $business_type,
                'default_statement_descriptor' => $default_statement_descriptor,
                'dob' => [
                    'year' => $dob_year,
                    'day' => $dob_day,
                    'month' => $dob_month,
                ],
                'doing_business_as' => $doing_business_as,
                'email' => $email,
                'first_name' => $first_name,
                'has_accepted_credit_cards_previously' => $has_accepted_credit_cards_previously,
                'incorporation_date' => [
                    'year' => $year,
                    'day' => $day,
                    'month' => $month,
                ],
                'last_name' => $last_name,
                'max_transaction_amount' => $max_transaction_amount,
                'ach_max_transaction_amount' => $ach_max_transaction_amount,
                'mcc' => $mcc,
                'ownership_type' => $ownership_type,
                'personal_address' => [
                    'city' => $city,
                    'country' => $country,
                    'region' => $region,
                    'line2' => $line2,
                    'line1' => $line1,
                    'postal_code' => $postal_code,
                ],
                'phone' => $phone,
                'principal_percentage_ownership' => $principal_percentage_ownership,
                'tax_id' => $tax_id,
                'title' => $title,
                'url' => $url,
            ],
            'tags' => $tags,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createIdentityMerchantMinReq($username,
    $password,
    $annual_card_volume,
    $city,
    $country,
    $region,
    $line2,
    $line1,
    $postal_code,
    $business_name,
    $business_phone,
    $business_tax_id,
    $business_type,
    $default_statement_descriptor,
    $year,
    $day,
    $month,
    $doing_business_as,
    $email,
    $first_name,
    $has_accepted_credit_cards_previously,
    $dob_year,
    $dob_day,
    $dob_month,
    $last_name,
    $max_transaction_amount,
    $ach_max_transaction_amount,
    $mcc,
    $ownership_type,
    $business_city,
    $business_country,
    $business_region,
    $business_line2,
    $business_line1,
    $business_postal_code,
    $phone,
    $principal_percentage_ownership,
    $tax_id,
    $title,
    $url,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            'additional_underwriting_data'=>null,
            'entity' => [
                'annual_card_volume' => $annual_card_volume,
                'business_address' => [
                    'city' => $business_city,
                    'country' => $business_country,
                    'region' => $business_region,
                    'line2' => $business_line2,
                    'line1' => $business_line1,
                    'postal_code' => $business_postal_code,
                ],
                'business_name' => $business_name,
                'business_phone' => $business_phone,
                'business_tax_id' => $business_tax_id,
                'business_type' => $business_type,
                'default_statement_descriptor' => $default_statement_descriptor,
                'dob' => [
                    'year' => $dob_year,
                    'day' => $dob_day,
                    'month' => $dob_month,
                ],
                'doing_business_as' => $doing_business_as,
                'email' => $email,
                'first_name' => $first_name,
                'has_accepted_credit_cards_previously' => $has_accepted_credit_cards_previously,
                'incorporation_date' => [
                    'year' => $year,
                    'day' => $day,
                    'month' => $month,
                ],
                'last_name' => $last_name,
                'max_transaction_amount' => $max_transaction_amount,
                'ach_max_transaction_amount' => $ach_max_transaction_amount,
                'mcc' => $mcc,
                'ownership_type' => $ownership_type,
                'personal_address' => [
                    'city' => $city,
                    'country' => $country,
                    'region' => $region,
                    'line2' => $line2,
                    'line1' => $line1,
                    'postal_code' => $postal_code,
                ],
                'phone' => $phone,
                'principal_percentage_ownership' => $principal_percentage_ownership,
                'tax_id' => $tax_id,
                'title' => $title,
                'url' => $url
            ],
            'tags'=>null
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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


    public static function createIdentityBuyer($username,
    $password,
    $city,
    $country,
    $region,
    $line2,
    $line1,
    $postal_code,
    $email,
    $first_name,
    $last_name,
    $phone,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "entity" => [
            "phone" => $phone,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "personal_address" => [
                "city" => $city,
                "country" => $country,
                "region" => $region,
                "line2" => $line2,
                "line1" => $line1,
                "postal_code" => $postal_code,
                ]
            ],
            "tags" => [
                $tags,
            ]
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function createIdentityBuyerMinReq($username,
    $password,
    $email,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "entity" => [
                "email"=>$email
            ],
            "tags" => null
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createIdentityBuyerWithAddedInfo($username,
    $password,
    $email,
    $addedInfo,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        // Define your data as an associative array
        $data = [
            "entity" => [
                "email"=>$email
            ],
            "tags" => null
        ];
        $data["entity"]  = array_merge($data["entity"],$addedInfo);
        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listIdentities($username,$password, $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchIDIdentity($username,$password,$id, $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateWithIDIdentity($id,
        $username,
        $password,
        $email,
        $first_name,
        $last_name,
        $phone,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
        ){
            $data = [
                'entity' => [
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                ]
            ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateWithIDIdentityMinReq($id,
    $username,
    $password,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        $data = [
            ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    // "\n{\n    \"entity\": {\n        \"first_name\": \"John\", \n        \"last_name\": \"Smith\", \n        \"title\": \"Founder\", \n        \"dob\": {\n            \"month\": 1, \n            \"day\": 1, \n            \"year\": 2013\n        }, \n        \"principal_percentage_ownership\": 25, \n        \"phone\": \"14158885080\", \n        \"personal_address\": {\n            \"city\": \"San Francisco\", \n            \"region\": \"CA\", \n            \"postal_code\": \"90650\", \n            \"line1\": \"123 Main Street\", \n            \"country\": \"USA\"\n        }, \n        \"email\": \"john.smith@company1.com\", \n        \"tax_id\": \"123456789\"\n    }\n}"
    public static function createAssociatedIdentity(
        $username,
        $password,
        $id,
        $personal_city,
        $personal_region,
        $personal_postal_code,
        $personal_line1,
        $personal_country,
        $first_name,
        $last_name,
        $title,
        $dob_month,
        $dob_day,
        $dob_year,
        $principal_percentage_ownership,
        $phone,
        $personal_address,
        $email,
        $tax_id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
        )
    {
    $personal_address = [
        'city' => $personal_city,
        'region' => $personal_region,
        'postal_code' => $personal_postal_code,
        'line1' => $personal_line1,
        'country' => $personal_country,
    ];
    $data = [
        'entity' => [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'title' => $title,
            'dob' => [
                'month' => $dob_month,
                'day' => $dob_day,
                'year' => $dob_year,
            ],
            'principal_percentage_ownership' => $principal_percentage_ownership,
            'phone' => $phone,
            'personal_address' => $personal_address,
            'email' => $email,
            'tax_id' => $tax_id
        ],
    ];
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id/associated_identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Finix-Version: 2022-02-01';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    return [$response,$httpcode];

    }
    public static function listAssosiatedIdentities(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id/associated_identities".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Finix-Version: 2022-02-01',
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Finix-Version: 2022-02-01';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    return [$response,$httpcode];
    }
    //merchant for making someone to pay from
    static $processors=["DUMMY_V1",
    "FINIX_V1",
    "LITLE_V1",
    "MASTERCARD_V1",
    "NMI_V1",
    "VANTIV_V1",
    "VISA_V1"];
    public static function createAMerchant(
        $username,
        $password,
        $id,
        $tag_array,//assosiated array key => value
        $processor,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "processor" => $processor,
            "tags" => $tag_array,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id/merchants".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createAMerchantMinReq(
        $username,
        $password,
        $id,
        $processor,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "processor" => $processor,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/identities/$id/merchants".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listMerchants(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchMerchant(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateAMerchant(
        $username,
        $password,
        $processing_enabled,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "processing_enabled" => $processing_enabled,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $headers = array();
        $headers[] = 'Accept: application/hal+json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Finix-Version: 2022-02-01';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function updateAMerchantMinReq(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $headers = array();
        $headers[] = 'Accept: application/hal+json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Finix-Version: 2022-02-01';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function updateMerchantEnableTwoThirdCharges(
        $username,
        $password,
        $level_two_level_three_data_enabled,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "level_two_level_three_data_enabled" => $level_two_level_three_data_enabled,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $headers = array();
        $headers[] = 'Accept: application/hal+json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Finix-Version: 2022-02-01';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function updateMerchantEnablePartialAutherization(
        $username,
        $password,
        $default_partial_authorization_enabled,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "default_partial_authorization_enabled" => $default_partial_authorization_enabled,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $headers = array();
        $headers[] = 'Accept: application/hal+json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Finix-Version: 2022-02-01';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function updateMerchantEnableBuyerCharges(
        $username,
        $password,
        $convenience_charges_enabled,
        $rent_surcharges_enabled,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "convenience_charges_enabled" => $convenience_charges_enabled,
            "rent_surcharges_enabled" => $rent_surcharges_enabled,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $headers = array();
        $headers[] = 'Accept: application/hal+json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Finix-Version: 2022-02-01';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function reverifyMerchant(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/merchants/$id/verifications".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/hal+json',
            'Content-Type: application/json',
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    //payment instraments for paying with eg a card
    public static function createPaymentInstrament(
        $username,
        $password,
        $city,
        $country,
        $line1,
        $postal_code,
        $region,
        $expiration_month,
        $expiration_year,
        $identity,
        $name,
        $number,
        $security_code,
        $type,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
    $address = [
        'city' => $city,
        'country' => $country,
        'line1' => $line1,
        'postal_code' => $postal_code,
        'region' => $region,
    ];
    $data = [
        'address' => $address,
        'expiration_month' => $expiration_month,
        'expiration_year' => $expiration_year,
        'identity' => $identity,
        'name' => $name,
        'number' => $number,
        'security_code' => $security_code,
        'type' => $type,
    ];

    // Encode the array to JSON
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createPaymentInstramentMinReq(
        $username,
        $password,
        $expiration_month,
        $expiration_year,
        $identity,
        $name,
        $number,
        $security_code,
        $type,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
    $data = [
        'expiration_month' => $expiration_month,
        'expiration_year' => $expiration_year,
        'identity' => $identity,
        'name' => $name,
        'number' => $number,
        'security_code' => $security_code,
        'type' => $type,
    ];

    // Encode the array to JSON
    $jsonData = json_encode(array_merge($data,$addedData));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createBankAccount(
        $username,
        $password,
        $account_number,
        $account_type,
        $bank_code,
        $identity,
        $name,
        $type,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data=[
            "account_number" => $account_number,
            "account_type" => $account_type,
            "bank_code" => $bank_code,
            "identity" => $identity,
            "name" => $name,
            "type" => $type,
        ];
            $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createPaymentCardFromToken(
        $username,
        $password,
        $token,
        $type,
        $identity,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data=[
            "token" => $token,
            "type" => $type,
            "identity" => $identity,
        ];
            $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function listPaymentInstraments(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchPaymentInstrament(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updatePaymentInstrament(
        $username,
        $password,
        $id,
        $merchant,
        $verify_payment_card,
        $city,
        $region,
        $postal_code,
        $line1,
        $line2,
        $country,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $address = [
            'city' => $city,
            'region' => $region,
            'postal_code' => $postal_code,
            'line1' => $line1,
            'line2' => $line2,
            'country' => $country,
        ];

        $data = [
            'address' => $address,
            'merchant' => $merchant,
            'verify_payment_card' => $verify_payment_card,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function disablePaymentInstrament(
        $username,
        $password,
        $id,
        $enabled,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "enabled" => $enabled,
            "tags" => $tags,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function bankValidationPaymentInstrament(
        $username,
        $password,
        $id,
        $attempt_bank_account_validation_check,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "attempt_bank_account_validation_check" =>$attempt_bank_account_validation_check
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateTagsPaymentInstrament(
        $username,
        $password,
        $id,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "tags" => $tags
            ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function verifyPaymentInstrament(
        $username,
        $password,
        $id,
        $merchant,
        $security_code,
        $verify_payment_card,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            'merchant' => $merchant,
            'security_code' => $security_code,
            'verify_payment_card' => $verify_payment_card,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function verifyPaymentInstramentAddress(
        $username,
        $password,
        $id,
        $city,
        $country,
        $line1,
        $postal_code,
        $region,
        $merchant,
        $verify_payment_card,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "address" => [
                "city" => $city,
                "country" => $country,
                "line1" => $line1,
                "postal_code" => $postal_code,
                "region" => $region
            ],
            "merchant" => $merchant,
            "verify_payment_card" => $verify_payment_card,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function verifyPaymentInstramentPushToCard(
        $username,
        $password,
        $id,
        $processor,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "processor" => $processor,
            "tags" => $tags
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_instruments/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createApplePaySession(
        $username,
        $password,
        $display_name,
        $domain,
        $merchant_identity,
        $validation_url,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "display_name" => $display_name,
            "domain" => $domain,
            "merchant_identity" => $merchant_identity,
            "validation_url" => $validation_url,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/apple_pay_sessions".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createApplePaySessionMinReq(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/apple_pay_sessions".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //make a payment with the identity merchant and payment_instrament also will need fraud_id stopper.
    public static function makePayment(
        $username,
        $password,
        $merchant,
        $currency,
        $amount,
        $source,
        $fraud_session_id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "merchant" => $merchant,
            "currency" => $currency,
            "amount" => $amount,
            "source" => $source,
            "fraud_session_id" => $fraud_session_id,//from the js in https://finix.com/docs/guides/payments/risk/fraud-detection/
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function makePaymentMinReq(
        $username,
        $password,
        $merchant,
        $currency,
        $amount,
        $source,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "merchant" => $merchant,
            "currency" => $currency,
            "amount" => $amount,
            "source" => $source
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listPayments(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchPayment(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updatePayment(
        $username,
        $password,
        $id,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "tags" => $tags
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //refunds
    public static function createRefund(
        $username,
        $password,
        $id,
        $tags,
        $refund_amount,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "refund_amount" => $refund_amount,
            "tags" => $tags
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id/reversals".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createRefundCardPresent(
        $username,
        $password,
        $id,
        $device,
        $refund_amount,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "device" => $device,
            "refund_amount" => $refund_amount,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id/reversals".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createRefundSwipedCard(
        $username,
        $password,
        $id,
        $amount,
    $currency,
    $device,
    $operation_key,
    $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "amount" => $amount,
            "currency" => $currency,
            "device" => $device,
            "operation_key" => $operation_key,
            "tags" => $tags
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id/reversals".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createRefundSplitTransactions(
        $username,
        $password,
        $id,
        $refund_amount,
        $amounts,
        $merchants,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $transactions=[];
        for ($i = 0; $i < count($merchants); $i++) {
            $transactions[] = [$merchants[$i],$amounts[$i]];
        }
        $data = [
            "refund_amount" => $refund_amount,
            "split_transfers" => $transactions,
            "tags" => $tags,
            ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id/reversals".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listRefundsOnPayment(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/transfers/$id/reversals".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //fees to be applied to the merchant
    public static function createFeeProfile(
        $username,
        $password,
        $ach_basis_points,
        $ach_fixed_fee,
        $application,
        $basis_points,
        $card_cross_border_basis_points,
        $card_cross_border_fixed_fee,
        $charge_interchange,
        $fixed_fee,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "ach_basis_points" => $ach_basis_points,
            "ach_fixed_fee" => $ach_fixed_fee,
            "application" => $application,
            "basis_points" => $basis_points,
            "card_cross_border_basis_points" => $card_cross_border_basis_points,
            "card_cross_border_fixed_fee" => $card_cross_border_fixed_fee,
            "charge_interchange" => $charge_interchange,
            "fixed_fee" => $fixed_fee,
            "tags" => $tags,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/fee_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
        return [$response,$httpcode];;
    }
    public static function createFeeProfileMinReq(
        $username,
        $password,
        $application,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "application" => $application,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/fee_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
        return [$response,$httpcode];;
    }
    public static function listFeeProfile(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/fee_profiles".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchFeeProfile(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/fee_profiles/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createHold(
    $username,
    $password,
    $amount,
    $currency,
    $merchant,
    $source,
    $tags,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[],
    $addedData=[]
    ){
        $data = [
            "amount" => $amount,
            "currency" => $currency,
            "merchant" => $merchant,
            "source" => $source,
            "tags" => $tags,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createHoldMinReq(
        $username,
        $password,
        $amount,
        $currency,
        $merchant,
        $source,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
        ){
            $data = [
                "amount" => $amount,
                "currency" => $currency,
                "merchant" => $merchant,
                "source" => $source,
            ];

            // Encode the array to JSON
            $jsonData = json_encode(array_merge($data,$addedData));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
        public static function createHold3DSecure(
            $username,
            $password,
            $cardholder_authentication,
            $electronic_commerce_indicator,
            $transaction_id,
            $amount,
            $currency,
            $merchant,
            $source,
            $tags,
            $endpoint='https://finix.sandbox-payments-api.com',
            $addedQuery=[],
            $addedData=[]
            ){
                $data = [
                    "3d_secure_authentication" => [
                    "cardholder_authentication" => $cardholder_authentication,
                    "electronic_commerce_indicator" => $electronic_commerce_indicator,
                    "transaction_id" => $transaction_id,
                    ],
                    "amount" => $amount,
                    "currency" => $currency,
                    "merchant" => $merchant,
                    "source" => $source,
                    "tags" => $tags
                    ];

                // Encode the array to JSON
                $jsonData = json_encode(array_merge($data,$addedData));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
            public static function createHoldWithCvv(
                $username,
                $password,
                $amount,
                $currency,
                $merchant,
                $security_code,
                $source,
                $endpoint='https://finix.sandbox-payments-api.com',
                $addedQuery=[],
                $addedData=[]
                ){
                    $data = [
                        "amount" => $amount,
                        "currency" => $currency,
                        "merchant" => $merchant,
                        "security_code" => $security_code,
                        "source" => $source,
                    ];

                    // Encode the array to JSON
                    $jsonData = json_encode(array_merge($data,$addedData));
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
                public static function createHoldWithBuyerCharges(
                    $username,
                    $password,
                    $convenience_amount,
                    $amount,
                    $currency,
                    $merchant,
                    $source,
                    $test,
                    $endpoint='https://finix.sandbox-payments-api.com',
                    $addedQuery=[],
                    $addedData=[]
                    ){
                        $data = [
                            "additional_buyer_charges" => [
                            "convenience_amount" => $convenience_amount,
                            ],
                            "amount" => $amount,
                            "currency" => $currency,
                            "merchant" => $merchant,
                            "source" => $source,
                            "tags" => [
                            "test" => $test,
                            ],
                        ];

                        // Encode the array to JSON
                        $jsonData = json_encode(array_merge($data,$addedData));
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

                        public static function createHoldWithHSAorFSA(
                            $username,
                            $password,
                            $amount,
                            $currency,
                            $hsa_fsa_payment,
                            $merchant,
                            $source,
                            $tags,
                            $endpoint='https://finix.sandbox-payments-api.com',
                            $addedQuery=[],
                            $addedData=[]
                            ){
                                $data = [
                                    "amount" => $amount,
                                    "currency" => $currency,
                                    "hsa_fsa_payment" => $hsa_fsa_payment,
                                    "merchant" => $merchant,
                                    "source" => $source,
                                    "tags" => $tags
                                    ];

                                // Encode the array to JSON
                                $jsonData = json_encode(array_merge($data,$addedData));
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
                            public static function createHoldWithLevel2Processing(
                                $username,
                                $password,
                                $customer_reference_number,
                                $sales_tax,
                                $amount,
                                $currency,
                                $merchant,
                                $source,
                                $tags,
                                $endpoint='https://finix.sandbox-payments-api.com',
                                $addedQuery=[],
                                $addedData=[]
                                ){
                                    $data = [
                                        "additional_purchase_data" => [
                                        "customer_reference_number" => $customer_reference_number,
                                        "sales_tax" => $sales_tax,
                                        ],
                                        "amount" => $amount,
                                        "currency" => $currency,
                                        "merchant" => $merchant,
                                        "source" => $source,
                                        "tags" => $tags
                                        ];

                                    // Encode the array to JSON
                                    $jsonData = json_encode(array_merge($data,$addedData));
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
                                public static function createHoldWithPartialAutherization(
                                    $username,
                                    $password,
                                    $amount,
                                    $currency,
                                    $merchant,
                                    $partial_authorization,
                                    $source,
                                    $tags,
                                    $endpoint='https://finix.sandbox-payments-api.com',
                                    $addedQuery=[],
                                    $addedData=[]
                                    ){
                                        $data = [
                                            "amount" => $amount,
                                            "currency" => $currency,
                                            "merchant" => $merchant,
                                            "partial_authorization" => $partial_authorization,
                                            "source" => $source,
                                            "tags" => $tags
                                        ];

                                        // Encode the array to JSON
                                        $jsonData = json_encode(array_merge($data,$addedData));
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
                                    public static function createHoldWithEmvCard(
                                        $username,
                                        $password,
                                        $amount,
                                        $currency,
                                        $device,
                                        $operation_key,
                                        $tags,
                                        $endpoint='https://finix.sandbox-payments-api.com',
                                        $addedQuery=[],
                                        $addedData=[]
                                        ){
                                            $data = [
                                                "amount" => $amount,
                                                "currency" => $currency,
                                                "device" => $device,
                                                "operation_key" => $operation_key,
                                                "tags" => $tags
                                                ];

                                            // Encode the array to JSON
                                            $jsonData = json_encode(array_merge($data,$addedData));
                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
                                        public static function createHoldWithNonEmvCard(
                                            $username,
                                            $password,
                                            $amount,
                                            $currency,
                                            $device,
                                            $operation_key,
                                            $tags,
                                            $endpoint='https://finix.sandbox-payments-api.com',
                                            $addedQuery=[],
                                            $addedData=[]
                                            ){
                                                $data = [
                                                    "amount" => $amount,
                                                    "currency" => $currency,
                                                    "device" => $device,
                                                    "operation_key" => $operation_key,
                                                    "tags" => $tags
                                                    ];

                                                // Encode the array to JSON
                                                $jsonData = json_encode(array_merge($data,$addedData));
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listHolds(
    $username,
    $password,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchHold(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function captureHold(
        $username,
        $password,
        $id,
        $capture_amount,
        $fee,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "capture_amount" => $capture_amount,
            "fee" => $fee,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function releaseHold(
        $username,
        $password,
        $id,
        $void_me,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "void_me" => $void_me,
        ];
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/authorizations/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //disputes
    public static function listDisputes(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchDispute(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateDispute(
        $username,
        $password,
        $id,
        $tags,//assoc array key => value
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "tags" => $tags,
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function uploadFileToProveDispute(
        $username,
        $password,
        $id,
        $filePath,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/evidence".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data',
            'Finix-Version: 2022-02-01',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile($filePath),
        ]);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function listEvidenceAboutDispute(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/evidence".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchEvidenceAboutDispute(
        $username,
        $password,
        $id,
        $evidenceID,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/evidence/$evidenceID".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function updateEvidenceAboutDispute(
        $username,
        $password,
        $id,
        $evidenceID,
        $tags,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        // Create array
        $data = [
            "tags" => $tags
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/evidence/$evidenceID".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchDisputeAdjustmentTransfer(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/adjustment_transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function submitDisputeEvidence(
        $username,
        $password,
        $id,
        $note,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "note" => $note
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/submit".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response,$httpcode];
    }
    public static function acceptADispute(
        $username,
        $password,
        $id,
        $note,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "note" => $note
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/accept".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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

    public static function downloadDisputeEvidence(
        $username,
        $password,
        $id,
        $evidenceID,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/disputes/$id/evidence/$evidenceID/download".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //payment links
    public static function listPymentLink(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_links".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createPaymentLink(
        $username,
        $password,
        $amount_type,
        $total_amount,
        $currency,
        $min_amount,
        $max_amount,
        $subtotal_amount,
        $shipping_amount,
        $estimated_tax_amount,
        $discount_amount,
        $tip_amount,
        $brand_color,
        $accent_color,
        $logo,
        $icon,
        $collect_name,
        $collect_email,
        $collect_phone_number,
        $collect_billing_address,
        $collect_shipping_address,
        $success_return_url,
        $cart_return_url,
        $expired_session_url,
        $terms_of_service_url,
        $expiration_in_minutes,
        $merchant_id,
        $payment_frequency,
        $is_multiple_use,
        $allowed_payment_methods,
        $nickname,
        $image_details,
        $description,
        $price_details,
        $quantity,
        $buyer,
        $amount_details,
        $branding,
        $additional_details,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $amount_details = [
            "amount_type" => $amount_type,
            "total_amount" => $total_amount,
            "currency" => $currency,
            "min_amount" => $min_amount,
            "max_amount" => $max_amount,
            "amount_breakdown" => [
                "subtotal_amount" => $subtotal_amount,
                "shipping_amount" => $shipping_amount,
                "estimated_tax_amount" => $estimated_tax_amount,
                "discount_amount" => $discount_amount,
                "tip_amount" => $tip_amount
            ]
        ];

        // Branding details
        $branding = [
            "brand_color" => $brand_color,
            "accent_color" => $accent_color,
            "logo" => $logo,
            "icon" => $icon
        ];

        // Additional details
        $additional_details = [
            "collect_name" => $collect_name,
            "collect_email" => $collect_email,
            "collect_phone_number" => $collect_phone_number,
            "collect_billing_address" => $collect_billing_address,
            "collect_shipping_address" => $collect_shipping_address,
            "success_return_url" => $success_return_url,
            "cart_return_url" => $cart_return_url,
            "expired_session_url" => $expired_session_url,
            "terms_of_service_url" => $terms_of_service_url,
            "expiration_in_minutes" => $expiration_in_minutes
        ];

        // Create array
        $data = [
            "merchant_id" => $merchant_id,
            "payment_frequency" => $payment_frequency,
            "is_multiple_use" => $is_multiple_use,
            "allowed_payment_methods" => $allowed_payment_methods,
            "nickname" => $nickname,
            "items" => [
                [
                    "image_details" => $image_details,
                    "description" => $description,
                    "price_details" => $price_details,
                    "quantity" => $quantity
                ]
            ],
            "buyer" => $buyer,
            "amount_details" => $amount_details,
            "branding" => $branding,
            "additional_details" => $additional_details
        ];
        $data=array_merge($data,$addedData);
        $jsonData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_links".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function createPaymentLinkMinReq(
        $username,
        $password,
        $merchant_id,
        $payment_frequency,
        $allowed_payment_methods,
        $nickname,
        $image_details,
        $description,
        $price_details,
        $quantity,
        $amount_type,
        $total_amount,
        $currency,
        $subtotal_amount,
        $shipping_amount,
        $estimated_tax_amount,
        $discount_amount,
        $tip_amount,
        $brand_color,
        $accent_color,
        $logo,
        $icon,
        $collect_name,
        $collect_email,
        $collect_phone_number,
        $collect_billing_address,
        $collect_shipping_address,
        $success_return_url,
        $cart_return_url,
        $expired_session_url,
        $terms_of_service_url,
        $expiration_in_minutes,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        // Create array
        $data = [
            "merchant_id" => $merchant_id,
            "payment_frequency" => $payment_frequency,
            "allowed_payment_methods" => [$allowed_payment_methods],
            "nickname" => $nickname,
            "items" => [
                [
                    "image_details" => $image_details,
                    "description" => $description,
                    "price_details" => $price_details,
                    "quantity" => $quantity
                ]
            ],
            "amount_details" => [
                "amount_type" => $amount_type,
                "total_amount" => $total_amount,
                "currency" => $currency,
                "amount_breakdown" => [
                    "subtotal_amount" => $subtotal_amount,
                    "shipping_amount" => $shipping_amount,
                    "estimated_tax_amount" => $estimated_tax_amount,
                    "discount_amount" => $discount_amount,
                    "tip_amount" => $tip_amount,
                    ],
                ],
                "branding" => [
                    "brand_color" => $brand_color,
                    "accent_color" => $accent_color,
                    "logo" => $logo,
                    "icon" => $icon,
                    ],
                    "additional_details" => [
                        "collect_name" => $collect_name,
                        "collect_email" => $collect_email,
                        "collect_phone_number" => $collect_phone_number,
                        "collect_billing_address" => $collect_billing_address,
                        "collect_shipping_address" => $collect_shipping_address,
                        "success_return_url" => $success_return_url,
                        "cart_return_url" => $cart_return_url,
                        "expired_session_url" => $expired_session_url,
                        "terms_of_service_url" => $terms_of_service_url,
                        "expiration_in_minutes" => $expiration_in_minutes,
                        ],
        ];
        $data=array_merge($data,$addedData);
        $jsonData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_links".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchPaymentLink(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/payment_links/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //settlements
    public static function listSettlements(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchSettlement(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function closeSettlement(
        $username,
        $password,
        $action,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "action" => $action
        ];
        $data=array_merge($data,$addedData);
        $jsonData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listSettlementsFuncingTransfers(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/$id/funding_transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function deleteSettlementTransfer(
        $username,
        $password,
        $id,
        $transfer,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData
    ){
        $data = [
            "transfers" => [
                $transfer
            ]
        ];
        $data=array_merge($data,$addedData);
        $jsonData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/$id//transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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
    public static function listTransfersInSettlement(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/settlements/$id/transfers".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //split payments
    public static function fetchSplitTransfer(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
        ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/split_transfers/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchSplitTransferFees(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
        ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/split_transfers/$id/fees".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
