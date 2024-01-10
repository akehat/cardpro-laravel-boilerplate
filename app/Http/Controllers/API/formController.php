<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class formController extends Controller
{
   //"{\n    \"merchant_id\": \"MUucec6fHeaWo3VHYoSkUySM\",\n    \"payment_frequency\": \"ONE_TIME\",\n    \"is_multiple_use\": false,\n    \"allowed_payment_methods\": [\n      \"PAYMENT_CARD\"\n    ],\n    \"nickname\": \"string\",\n    \"items\": [\n      {\n        \"image_details\": {\n          \"primary_image_url\": \"https://google.com/image\",\n          \"alternative_image_urls\": [\n            \"https://google.com/image1\",\n            \"https://google.com/image2\"\n          ]\n        },\n        \"description\": \"sunglasses\",\n        \"price_details\": {\n          \"sale_amount\": 4000,\n          \"currency\": \"USD\",\n          \"price_type\": \"PROMOTIONAL\",\n          \"regular_amount\": 5000\n        },\n        \"quantity\": \"1\"\n      }\n    ],\n    \"buyer\": {\n      \"identity_id\": \"IDpYDM7J9n57q849o9E9yNrG\",\n      \"first_name\": \"Oscar\",\n      \"last_name\": \"Barillas\",\n      \"email_address\": null,\n      \"shipping_address\": null,\n      \"billing_address\": null,\n      \"phone_number\": null\n    },\n    \"amount_details\": {\n      \"amount_type\": \"FIXED\",\n      \"total_amount\": 5418,\n      \"currency\": \"USD\",\n      \"min_amount\": null,\n      \"max_amount\": null,\n      \"amount_breakdown\": {\n        \"subtotal_amount\": 3994,\n        \"shipping_amount\": 995,\n        \"estimated_tax_amount\": 429,\n        \"discount_amount\": \"1000\",\n        \"tip_amount\": \"1000\"\n      }\n    },\n    \"branding\": {\n      \"brand_color\": \"#ff06b5\",\n      \"accent_color\": \"#ff06b5\",\n      \"logo\": \"https://www.example.com/success/123rw21w.svg\",\n      \"icon\": \"https://www.example.com/success/123rw21w.svg\"\n    },\n    \"additional_details\": {\n      \"collect_name\": true,\n      \"collect_email\": true,\n      \"collect_phone_number\": true,\n      \"collect_billing_address\": true,\n      \"collect_shipping_address\": true,\n      \"success_return_url\": \"https://www.example.com/success/123rw21w.html\",\n      \"cart_return_url\": \"https://www.example.com/my_cart.html\",\n      \"expired_session_url\": \"https://example.com/error.html\",\n      \"terms_of_service_url\": \"https://example.com/terms_of_service.html\",\n      \"expiration_in_minutes\": 10080\n    }\n  }"
    public static function createCheckoutForm(
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
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/checkout_forms".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listCheckoutForm(
        $username,
        $password,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/checkout_forms".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchCheckoutForm(
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
    //pci complience
    public static function fetchPCIForm(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/compliance_forms/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function completePCIForm(
        $username,
        $password,
        $id,
        $ip_address,
        $name,
        $signed_at,
        $title,
        $user_agent,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $pci_saq_a = [
            "ip_address" => $ip_address,
            "name" => $name,
            "signed_at" => $signed_at,
            "title" => $title,
            "user_agent" => $user_agent,
        ];
        $data = [
            "pci_saq_a" => $pci_saq_a,
        ];
        $jsonData = json_encode(array_merge($data,$addedData), JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/compliance_forms/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function listPCIforms(
    $username,
    $password,
    $all=false,
    $completed_forms=true,
    $endpoint='https://finix.sandbox-payments-api.com',
    $addedQuery=[]
    ){
        $state=$completed_forms==false?"INCOMPLETE":"COMPLETE";
        $param=$all==false?("?state=$state".(!empty($addedQuery)?http_build_query($addedQuery):"")):
        (!empty($addedQuery)?"?". http_build_query($addedQuery):"");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/compliance_forms$param");
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
    //onboarding forms
    public static function createOnboardingForm(
        $username,
        $password,
            $title,
            $first_name,
            $last_name,
            $email,
            $business_name,
            $business_type,
            $doing_business_as,
            $phone,
            $business_phone,
                $city,
                $country,
                $line1,
                $postal_code,
                $region,
                $business_city,
                $business_country,
                $business_line1,
                $business_postal_code,
                $business_region,
                $dob_day,
                $dob_month,
                $dob_year,
                $incorporation_day,
                $incorporation_month,
                $incorporation_year,
            $mcc,
            $url,
            $ownership_type,
            $default_statement_descriptor,
            $max_transaction_amount,
            $annual_card_volume,
            $principal_percentage_ownership,
            $tax_id,
            $business_tax_id,
            $has_accepted_credit_cards_previously,
            $refund_policy,
                $card_ecommerce_percentage,
                $card_card_present_percentage,
                $card_mail_order_telephone_order_percentage,
            $average_ach_transfer_amount,
            $average_card_transfer_amount,
            $annual_ach_volume,
            $business_description,
                $other_volume_percentage,
                $person_to_person_volume_percentage,
                $business_to_business_volume_percentage,
                $business_to_consumer_volume_percentage,
                $consumer_to_consumer_volume_percentage,
                $associated_title,
                $associated_first_name,
                $associated_last_name,
                $associated_email,
                $associated_phone,
                    $associated_personal_city,
                    $associated_personal_country,
                    $associated_personal_line1,
                    $associated_personal_postal_code,
                    $associated_personal_region,
                    $associated_dob_day,
                    $associated_dob_month,
                    $associated_dob_year,
                $associated_principal_percentage_ownership,
                $associated_tax_id,
            $payment_name,
            $payment_bank_code,
            $payment_account_number,
            $payment_account_type,
            $payment_type,
        $entity_max_transaction_amount,
            $processor,
        $return_url,
        $expired_session_url,
        $terms_of_service_url,
        $fee_details_url,
        $expiration_in_minutes,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
                // Define variables
        $onboarding_data = [
            "entity" => [
                "title" => $title,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "business_name" => $business_name,
                "business_type" => $business_type,
                "doing_business_as" => $doing_business_as,
                "phone" => $phone,
                "business_phone" => $business_phone,
                "personal_address" => [
                    "city" => $city,
                    "country" => $country,
                    "line1" => $line1,
                    "postal_code" => $postal_code,
                    "region" => $region
                ],
                "business_address" => [
                    "city" => $business_city,
                    "country" => $business_country,
                    "line1" => $business_line1,
                    "postal_code" => $business_postal_code,
                    "region" => $business_region,
                ],
                "dob" => [
                    "day" => $dob_day,
                    "month" => $dob_month,
                    "year" => $dob_year
                ],
                "incorporation_date" => [
                    "day" => $incorporation_day,
                    "month" => $incorporation_month,
                    "year" => $incorporation_year,
                ],
                "mcc" => $mcc,
                "url" => $url,
                "ownership_type" => $ownership_type,
                "default_statement_descriptor" => $default_statement_descriptor,
                "max_transaction_amount" => $entity_max_transaction_amount,
                "annual_card_volume" => $annual_card_volume,
                "principal_percentage_ownership" => $principal_percentage_ownership,
                "tax_id" => $tax_id,
                "business_tax_id" => $business_tax_id,
                "has_accepted_credit_cards_previously" => $has_accepted_credit_cards_previously
            ],
            "additional_underwriting_data" => [
                "refund_policy" => $refund_policy,
                "card_volume_distribution" => [
                    "ecommerce_percentage" => $card_ecommerce_percentage,
                    "card_present_percentage" => $card_card_present_percentage,
                    "mail_order_telephone_order_percentage" => $card_mail_order_telephone_order_percentage,
                ],
                "average_ach_transfer_amount" => $average_ach_transfer_amount,
                "average_card_transfer_amount" => $average_card_transfer_amount,
                "annual_ach_volume" => $annual_ach_volume,
                "business_description" => $business_description,
                "volume_distribution_by_business_type" => [
                    "other_volume_percentage" => $other_volume_percentage,
                    "person_to_person_volume_percentage" => $person_to_person_volume_percentage,
                    "business_to_business_volume_percentage" => $business_to_business_volume_percentage,
                    "business_to_consumer_volume_percentage" => $business_to_consumer_volume_percentage,
                    "consumer_to_consumer_volume_percentage" => $consumer_to_consumer_volume_percentage
                ]
            ],
            "associated_entities" => [
                [
                    "title" => $associated_title,
                    "first_name" => $associated_first_name,
                    "last_name" => $associated_last_name,
                    "email" => $associated_email,
                    "phone" => $associated_phone,
                    "personal_address" => [
                        "city" => $associated_personal_city,
                        "country" => $associated_personal_country,
                        "line1" => $associated_personal_line1,
                        "postal_code" => $associated_personal_postal_code,
                        "region" => $associated_personal_region
                    ],
                    "dob" => [
                        "day" => $associated_dob_day,
                        "month" => $associated_dob_month,
                        "year" => $associated_dob_year,
                    ],
                    "principal_percentage_ownership" => $associated_principal_percentage_ownership,
                    "tax_id" => $associated_tax_id
                ]
            ],
            "payment_instruments" => [
                "name" => $payment_name,
                "bank_code" => $payment_bank_code,
                "account_number" => $payment_account_number,
                "account_type" => $payment_account_type,
                "type" => $payment_type,
            ],
            "max_transaction_amount" => $max_transaction_amount
        ];

        $merchant_processors = [
            [
                "processor" => $processor
            ]
        ];

        $onboarding_link_details = [
            "return_url" => $return_url,
            "expired_session_url" => $expired_session_url,
            "terms_of_service_url" => $terms_of_service_url,
            "fee_details_url" => $fee_details_url,
            "expiration_in_minutes" => $expiration_in_minutes,
        ];

        // Create array
        $data = [
            "onboarding_data" => $onboarding_data,
            "merchant_processors" => $merchant_processors,
            "onboarding_link_details" => $onboarding_link_details
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData), JSON_PRETTY_PRINT);



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/onboarding_forms".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    public static function fetchOnBoardingForm(
        $username,
        $password,
        $id,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[]
    ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/onboarding_forms/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
    //external link for th made onboarding from.
    public static function createOnBoardingLink(
        $username,
        $password,
        $id,
        $expiration_in_minutes,
        $expired_session_url,
        $fee_details_url,
        $return_url,
        $terms_of_service_url,
        $endpoint='https://finix.sandbox-payments-api.com',
        $addedQuery=[],
        $addedData=[]
    ){
        $data = [
            "expiration_in_minutes" => $expiration_in_minutes,
            "expired_session_url" => $expired_session_url,
            "fee_details_url" => $fee_details_url,
            "return_url" => $return_url,
            "terms_of_service_url" => $terms_of_service_url
        ];

        // Encode the array to JSON
        $jsonData = json_encode(array_merge($data,$addedData), JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$endpoint/onboarding_forms/$id".(!empty($addedQuery)?"?". http_build_query($addedQuery):""));
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
}
