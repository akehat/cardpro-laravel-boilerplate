<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/themes/prism-tomorrow.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>

    <style>
        h2{
            color:rgb(4, 4, 128);
            font-size: 30px;
        }
.floatcontainer {
    margin-bottom:10%;
    display: flex;
    flex-wrap: wrap;
}

.floatcontainer > div {
    width: max(48%,400px);
}
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;

        }

        header {
            background-color: #333;
            color: white;
            padding: 1px;
            text-align: center;
            height: 98px;
        }

        .container {
            display: flex;
            overflow: hidden;
            height: calc(100vh - 100px);
        }

        nav {
            background-color: #f0f0f0;
            padding: 20px;
            width: 200px;
            overflow-y: auto;
            max-height: 100%;
            height: 100%;
        }

        nav ul {
    list-style-type: none;
    padding: 0;
}

nav ul li {
    margin-bottom: 10px;
    margin-left: 10px;
}

nav ul li a {
    color: blue;
    text-decoration: none;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #1319c0;
}
        main {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            max-height: calc(100vh - 100px);
            height: calc(100vh - 100px);
        }

        code {
            background-color: #f4f4f4;
            padding: 5px;
            border-radius: 3px;
            display: block;
            margin-bottom: 10px;
            overflow-x: scroll
        }

        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
        }
        #navList {
            position: absolute;
            top: 100px; /* Adjust as needed based on your layout */
            left: 0;
        }
        @media only screen and (max-width: 480px) {
        nav{
            width: min-content;
            max-width: min-content;
        }
        #navList {
            display: none;
            width: 50%;
            position: absolute;
            top: 100px; /* Adjust as needed based on your layout */
            left: 0;
            background-color: #f0f0f0;/* Your brand color */
        }

        #navList li {
            display: block;
            margin: 10px 0;
        }
        #sidenavButton{
            display: block!important;
        }
        #navList:hover {
            display: block;
        }
}
    </style>
</head>
<body>
    <header>
        <a href="{{ url('') }}" style="margin-left: 10px;position: absolute; left: 10px; color:white; top:30px; font-size:30px; text-decoration:none!important;">🔙 </a>
        <h1> API Documentation</h1>
    </header>

    <div class="container">
        <nav id="sidenav">
            <button id="sidenavButton" style="display: none">></button>
            <ul id="navList"></ul>
        </nav>

        <main id="mainContent">
        </main>
    </div>

    <script>
        // JavaScript to toggle the display of the navigation menu on hover for phones
        document.querySelector('#sidenav').addEventListener('mouseenter', function () {
    if (window.innerWidth <= 480) { // Check if screen size is phone
        document.querySelector('#navList').style.display = 'block';
        document.querySelector('#sidenav').style.width = '50%';
        document.querySelector('#sidenav').style.minWidth = '50%';
    }
});

document.querySelector('#sidenav').addEventListener('mouseleave', function () {
    if (window.innerWidth <= 480) { // Check if screen size is phone
        document.querySelector('#navList').style.display = 'none';
        document.querySelector('#sidenav').style.width = 'min-content';
        document.querySelector('#sidenav').style.minWidth = 'min-content';
    }
});

var data = [
    {
        "routeName": "Create Customer",
        "info": "Create a customer to attach a card for payments. POST Route",
        "parameters": "'apikey' either user or merchant. 'email' for the customer.",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'email' for the customer.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/customers -d '{\"apikey\":\"apikey\",\"email\":\"email@example.com\"}'",
        "exampleResponse": `{
    "id": 77,
    "created_at": "2024-02-16T03:40:57.000000Z",
    "updated_at": "2024-02-16T03:40:57.000000Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
    "identity_roles": "[]",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "_links": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "finix_id": "ID9BBQfNDBnt5hUxvp3W1w6S",
    "finix_merchant_id": null,
    "customer_id": null,
    "isBuyer": 1,
    "isMerchant": 0
}`
    },
    {
        "routeName": "Get Customers",
        "info": "Get a customers by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/customers\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 74,
            "created_at": "2024-02-15T19:18:04.000000Z",
            "updated_at": "2024-02-15T19:18:04.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
            "identity_roles": "[]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDowzFBxyc6ZRUaR1Dag8idq",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 1,
            "isMerchant": 0
        },
        {
            "id": 75,
            "created_at": "2024-02-16T03:39:59.000000Z",
            "updated_at": "2024-02-16T03:39:59.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
            "identity_roles": "[]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDiUr4Jt2EkTuoUr7gZwC6ar",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 1,
            "isMerchant": 0
        },
        {
            "id": 76,
            "created_at": "2024-02-16T03:40:05.000000Z",
            "updated_at": "2024-02-16T03:40:05.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
            "identity_roles": "[]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDv6tyXgNNtJLH9x8GTWjK8H",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 1,
            "isMerchant": 0
        },
        {
            "id": 77,
            "created_at": "2024-02-16T03:40:57.000000Z",
            "updated_at": "2024-02-16T03:40:57.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
            "identity_roles": "[]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "finix_id": "ID9BBQfNDBnt5hUxvp3W1w6S",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 1,
            "isMerchant": 0
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers",
    "per_page": 20,
    "prev_page_url": null,
    "to": 4,
    "total": 4
}`,
    },
    {
        "routeName": "Get Customer",
        "info": "Get a customer by id. GET Route",
        "parameters": " 'id' for the customer either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the customer in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/customers/74\"",
        "exampleResponse": `{
    "id": 74,
    "created_at": "2024-02-15T19:18:04.000000Z",
    "updated_at": "2024-02-15T19:18:04.000000Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
    "identity_roles": "[]",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "_links": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "finix_id": "IDowzFBxyc6ZRUaR1Dag8idq",
    "finix_merchant_id": null,
    "customer_id": null,
    "isBuyer": 1,
    "isMerchant": 0
}`
    },

    {
        "routeName": "Search Customers",
        "info": "Search for a customers by 20. GET Route",
        "parameters": "'apikey' either user or merchant.",
        "header": "Endpoint",
        "query": "page the page of the query like page=2 by 20,'search' for in the customer.",
        "data": "'apikey' either user or merchant. ",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
   {{url('')}}/api/cardwiz/customers/search?search=ID9BBQfNDBnt5hUxvp3W1w6S",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 77,
            "created_at": "2024-02-16T03:40:57.000000Z",
            "updated_at": "2024-02-16T03:40:57.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":0,\"amex_mid\":null,\"annual_card_volume\":0,\"business_address\":null,\"business_name\":null,\"business_phone\":null,\"business_tax_id_provided\":false,\"business_type\":null,\"default_statement_descriptor\":null,\"discover_mid\":null,\"dob\":null,\"doing_business_as\":null,\"email\":\"email@example.com\",\"first_name\":null,\"has_accepted_credit_cards_previously\":false,\"incorporation_date\":null,\"last_name\":null,\"max_transaction_amount\":0,\"mcc\":null,\"ownership_type\":null,\"personal_address\":{\"line1\":null,\"line2\":null,\"city\":null,\"region\":null,\"postal_code\":null,\"country\":null},\"phone\":null,\"principal_percentage_ownership\":null,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":false,\"title\":null,\"url\":null}",
            "identity_roles": "[]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "finix_id": "ID9BBQfNDBnt5hUxvp3W1w6S",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 1,
            "isMerchant": 0
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers\/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers\/search?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers\/search?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/customers\/search",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}`
    },
    {
        "routeName": "Create Payment Way.",
        "info": "Create a card. POST Route",
        "parameters": "'apikey' either user or merchant.'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card. POST Route",
        "header": "Endpoint.",
        "parameters": "'apikey' either user or merchant.'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card.",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/payment_ways -d '{\"apikey\":\"apikey\",\"exp_month\":\"12\",\"exp_year\":\"2029\",\"name\":\"John Doe\",\"card_number\":\"5200828282828210\",\"cvv\":331,\"id\":74}'",
       "exampleResponse": `{
    "id": 56,
    "created_at": "2024-02-18T03:12:58.000000Z",
    "updated_at": "2024-02-18T03:12:58.000000Z",
    "finix_id": "PIbyXuLgXsmwR6QZAkUfJydg",
    "created_at_finix": "2024-02-18T03:12:58.39Z",
    "updated_at_finix": "2024-02-18T03:12:58.39Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "created_via": "API",
    "currency": "USD",
    "disabled_code": null,
    "disabled_message": null,
    "enabled": 1,
    "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
    "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
    "instrument_type": "PAYMENT_CARD",
    "address": null,
    "address_verification": "UNKNOWN",
    "bin": "520082",
    "brand": "MASTERCARD",
    "card_type": "DEBIT",
    "expiration_month": 12,
    "expiration_year": 2029,
    "issuer_country": "NON_USA",
    "last_four": "8210",
    "name": "John Doe",
    "security_code_verification": "UNKNOWN",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "type": "PAYMENT_CARD",
    "_links": null,
    "account_type": null,
    "bank_account_validation_check": null,
    "bank_code": null,
    "country": null,
    "institution_number": null,
    "masked_account_number": null,
    "transit_number": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`,
    },
    {
        "routeName": "Get Payment Ways",
        "info": "Get a charge by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/payment_ways\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 55,
            "created_at": "2024-02-18T03:12:49.000000Z",
            "updated_at": "2024-02-18T03:12:49.000000Z",
            "finix_id": "PIo75Ymokiz32HXQYo3n6wDZ",
            "created_at_finix": "2024-02-18T03:12:49.29Z",
            "updated_at_finix": "2024-02-18T03:12:49.29Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "created_via": "API",
            "currency": "USD",
            "disabled_code": null,
            "disabled_message": null,
            "enabled": 1,
            "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
            "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
            "instrument_type": "PAYMENT_CARD",
            "address": null,
            "address_verification": "UNKNOWN",
            "bin": "520082",
            "brand": "MASTERCARD",
            "card_type": "DEBIT",
            "expiration_month": 12,
            "expiration_year": 2029,
            "issuer_country": "NON_USA",
            "last_four": "8210",
            "name": "John Doe",
            "security_code_verification": "UNKNOWN",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "type": "PAYMENT_CARD",
            "_links": null,
            "account_type": null,
            "bank_account_validation_check": null,
            "bank_code": null,
            "country": null,
            "institution_number": null,
            "masked_account_number": null,
            "transit_number": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1
        },
        {
            "id": 56,
            "created_at": "2024-02-18T03:12:58.000000Z",
            "updated_at": "2024-02-18T03:12:58.000000Z",
            "finix_id": "PIbyXuLgXsmwR6QZAkUfJydg",
            "created_at_finix": "2024-02-18T03:12:58.39Z",
            "updated_at_finix": "2024-02-18T03:12:58.39Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "created_via": "API",
            "currency": "USD",
            "disabled_code": null,
            "disabled_message": null,
            "enabled": 1,
            "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
            "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
            "instrument_type": "PAYMENT_CARD",
            "address": null,
            "address_verification": "UNKNOWN",
            "bin": "520082",
            "brand": "MASTERCARD",
            "card_type": "DEBIT",
            "expiration_month": 12,
            "expiration_year": 2029,
            "issuer_country": "NON_USA",
            "last_four": "8210",
            "name": "John Doe",
            "security_code_verification": "UNKNOWN",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "type": "PAYMENT_CARD",
            "_links": null,
            "account_type": null,
            "bank_account_validation_check": null,
            "bank_code": null,
            "country": null,
            "institution_number": null,
            "masked_account_number": null,
            "transit_number": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}`
    },
    {
        "routeName": "Get Payment Way",
        "info": "Get a Payment Way by id. GET Route",
        "parameters": " 'id' for the Payment Way either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the Payment Way in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/payment_ways/56\"",
        "exampleResponse": `{
    "id": 56,
    "created_at": "2024-02-18T03:12:58.000000Z",
    "updated_at": "2024-02-18T03:12:58.000000Z",
    "finix_id": "PIbyXuLgXsmwR6QZAkUfJydg",
    "created_at_finix": "2024-02-18T03:12:58.39Z",
    "updated_at_finix": "2024-02-18T03:12:58.39Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "created_via": "API",
    "currency": "USD",
    "disabled_code": null,
    "disabled_message": null,
    "enabled": 1,
    "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
    "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
    "instrument_type": "PAYMENT_CARD",
    "address": null,
    "address_verification": "UNKNOWN",
    "bin": "520082",
    "brand": "MASTERCARD",
    "card_type": "DEBIT",
    "expiration_month": 12,
    "expiration_year": 2029,
    "issuer_country": "NON_USA",
    "last_four": "8210",
    "name": "John Doe",
    "security_code_verification": "UNKNOWN",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "type": "PAYMENT_CARD",
    "_links": null,
    "account_type": null,
    "bank_account_validation_check": null,
    "bank_code": null,
    "country": null,
    "institution_number": null,
    "masked_account_number": null,
    "transit_number": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`
    },
    {
        "routeName": "Search Payment Way",
        "info": "Search a Payment Ways by 20.",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/payment_ways/search?search=APZmjWMcUWgvxGcBV3V6FJ7\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 55,
            "created_at": "2024-02-18T03:12:49.000000Z",
            "updated_at": "2024-02-18T03:12:49.000000Z",
            "finix_id": "PIo75Ymokiz32HXQYo3n6wDZ",
            "created_at_finix": "2024-02-18T03:12:49.29Z",
            "updated_at_finix": "2024-02-18T03:12:49.29Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "created_via": "API",
            "currency": "USD",
            "disabled_code": null,
            "disabled_message": null,
            "enabled": 1,
            "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
            "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
            "instrument_type": "PAYMENT_CARD",
            "address": null,
            "address_verification": "UNKNOWN",
            "bin": "520082",
            "brand": "MASTERCARD",
            "card_type": "DEBIT",
            "expiration_month": 12,
            "expiration_year": 2029,
            "issuer_country": "NON_USA",
            "last_four": "8210",
            "name": "John Doe",
            "security_code_verification": "UNKNOWN",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "type": "PAYMENT_CARD",
            "_links": null,
            "account_type": null,
            "bank_account_validation_check": null,
            "bank_code": null,
            "country": null,
            "institution_number": null,
            "masked_account_number": null,
            "transit_number": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1
        },
        {
            "id": 56,
            "created_at": "2024-02-18T03:12:58.000000Z",
            "updated_at": "2024-02-18T03:12:58.000000Z",
            "finix_id": "PIbyXuLgXsmwR6QZAkUfJydg",
            "created_at_finix": "2024-02-18T03:12:58.39Z",
            "updated_at_finix": "2024-02-18T03:12:58.39Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "created_via": "API",
            "currency": "USD",
            "disabled_code": null,
            "disabled_message": null,
            "enabled": 1,
            "fingerprint": "FPRiCenDk2SoRng7WjQTr7RJY",
            "identity": "IDowzFBxyc6ZRUaR1Dag8idq",
            "instrument_type": "PAYMENT_CARD",
            "address": null,
            "address_verification": "UNKNOWN",
            "bin": "520082",
            "brand": "MASTERCARD",
            "card_type": "DEBIT",
            "expiration_month": 12,
            "expiration_year": 2029,
            "issuer_country": "NON_USA",
            "last_four": "8210",
            "name": "John Doe",
            "security_code_verification": "UNKNOWN",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "type": "PAYMENT_CARD",
            "_links": null,
            "account_type": null,
            "bank_account_validation_check": null,
            "bank_code": null,
            "country": null,
            "institution_number": null,
            "masked_account_number": null,
            "transit_number": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways\/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways\/search?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways\/search?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/payment_ways\/search",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}`,
    },
    {
        "routeName": "Create Charge",
        "info": "create a charge for a customer. POST Route",
        "parameters": "'apikey' either user or merchant.\n'cardID' of the card. \n'amount' the amount of the charge. \n'currency' of the charge. \nIf a user key is used the 'MerchantID' must be provided.",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'cardID' for in the card. 'currency' of the charge.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/charges -d '{\"apikey\":\"apikey\",\"cardID\":2,\"amount\":200,\"currency\":\"USD\"}'",
        "exampleResponse": `{
    "id": 30,
    "created_at": "2024-02-18T04:09:29.000000Z",
    "updated_at": "2024-02-18T04:09:29.000000Z",
    "finix_id": "TRh2kLF2dxdmrrNBGrm9fkx3",
    "created_at_finix": "2024-02-18T04:09:27.17Z",
    "updated_at_finix": "2024-02-18T04:09:28.83Z",
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "additional_purchase_data": null,
    "address_verification": null,
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "currency": "USD",
    "destination": null,
    "externally_funded": "UNKNOWN",
    "failure_code": null,
    "failure_message": null,
    "fee": 0,
    "idempotency_id": null,
    "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "parent_transfer": null,
    "parent_transfer_trace_id": null,
    "raw": null,
    "ready_to_settle_at": null,
    "receipt_last_printed_at": null,
    "security_code_verification": null,
    "source": "PIbyXuLgXsmwR6QZAkUfJydg",
    "split_transfers": "[]",
    "state": "SUCCEEDED",
    "statement_descriptor": "FLX*FINIX FLOWERS",
    "subtype": "API",
    "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
    "trace_id": "247e8476-0051-4c13-abeb-0e449bc4b4dd",
    "type": "DEBIT",
    "_links": null,
    "fee_type": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "merchant_id": null,
    "customer_id": null
}`
    },

    {
        "routeName": "Get Charges",
        "info": "Get a charge by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/charges\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 28,
            "created_at": "2024-02-18T04:05:51.000000Z",
            "updated_at": "2024-02-18T04:05:51.000000Z",
            "finix_id": "TRxADa5jzJ2GRRM5yejSvpPU",
            "created_at_finix": "2024-02-18T04:05:49.27Z",
            "updated_at_finix": "2024-02-18T04:05:51.07Z",
            "additional_buyer_charges": null,
            "additional_healthcare_data": null,
            "additional_purchase_data": null,
            "address_verification": null,
            "amount": 2000,
            "amount_requested": 2000,
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "currency": "USD",
            "destination": null,
            "externally_funded": "UNKNOWN",
            "failure_code": null,
            "failure_message": null,
            "fee": 0,
            "idempotency_id": null,
            "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
            "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "messages": "[]",
            "parent_transfer": null,
            "parent_transfer_trace_id": null,
            "raw": null,
            "ready_to_settle_at": null,
            "receipt_last_printed_at": null,
            "security_code_verification": null,
            "source": "PIbyXuLgXsmwR6QZAkUfJydg",
            "split_transfers": "[]",
            "state": "SUCCEEDED",
            "statement_descriptor": "FLX*FINIX FLOWERS",
            "subtype": "API",
            "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
            "trace_id": "16ea7b2f-4e0f-41b9-b125-836e019196fe",
            "type": "DEBIT",
            "_links": null,
            "fee_type": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "merchant_id": null,
            "customer_id": null
        },
        {
            "id": 29,
            "created_at": "2024-02-18T04:08:18.000000Z",
            "updated_at": "2024-02-18T04:08:18.000000Z",
            "finix_id": "TRbS8p7qMbTRRWcqMZ7tHpUC",
            "created_at_finix": "2024-02-18T04:08:17.08Z",
            "updated_at_finix": "2024-02-18T04:08:18.69Z",
            "additional_buyer_charges": null,
            "additional_healthcare_data": null,
            "additional_purchase_data": null,
            "address_verification": null,
            "amount": 2000,
            "amount_requested": 2000,
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "currency": "USD",
            "destination": null,
            "externally_funded": "UNKNOWN",
            "failure_code": null,
            "failure_message": null,
            "fee": 0,
            "idempotency_id": null,
            "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
            "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "messages": "[]",
            "parent_transfer": null,
            "parent_transfer_trace_id": null,
            "raw": null,
            "ready_to_settle_at": null,
            "receipt_last_printed_at": null,
            "security_code_verification": null,
            "source": "PIbyXuLgXsmwR6QZAkUfJydg",
            "split_transfers": "[]",
            "state": "SUCCEEDED",
            "statement_descriptor": "FLX*FINIX FLOWERS",
            "subtype": "API",
            "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
            "trace_id": "55d0b56d-ee6b-40a5-9263-d98a89142a2d",
            "type": "DEBIT",
            "_links": null,
            "fee_type": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "merchant_id": null,
            "customer_id": null
        },
        {
            "id": 30,
            "created_at": "2024-02-18T04:09:29.000000Z",
            "updated_at": "2024-02-18T04:09:29.000000Z",
            "finix_id": "TRh2kLF2dxdmrrNBGrm9fkx3",
            "created_at_finix": "2024-02-18T04:09:27.17Z",
            "updated_at_finix": "2024-02-18T04:09:28.83Z",
            "additional_buyer_charges": null,
            "additional_healthcare_data": null,
            "additional_purchase_data": null,
            "address_verification": null,
            "amount": 2000,
            "amount_requested": 2000,
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "currency": "USD",
            "destination": null,
            "externally_funded": "UNKNOWN",
            "failure_code": null,
            "failure_message": null,
            "fee": 0,
            "idempotency_id": null,
            "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
            "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "messages": "[]",
            "parent_transfer": null,
            "parent_transfer_trace_id": null,
            "raw": null,
            "ready_to_settle_at": null,
            "receipt_last_printed_at": null,
            "security_code_verification": null,
            "source": "PIbyXuLgXsmwR6QZAkUfJydg",
            "split_transfers": "[]",
            "state": "SUCCEEDED",
            "statement_descriptor": "FLX*FINIX FLOWERS",
            "subtype": "API",
            "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
            "trace_id": "247e8476-0051-4c13-abeb-0e449bc4b4dd",
            "type": "DEBIT",
            "_links": null,
            "fee_type": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "merchant_id": null,
            "customer_id": null
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges",
    "per_page": 20,
    "prev_page_url": null,
    "to": 3,
    "total": 3
}`
    },
    {
        "routeName": "Get Charge",
        "info": "Get a charge by id. GET Route",
        "parameters": " 'id' for the charge either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the charge in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/charges/30\"",
        "exampleResponse": `{
    "id": 30,
    "created_at": "2024-02-18T04:09:29.000000Z",
    "updated_at": "2024-02-18T04:09:29.000000Z",
    "finix_id": "TRh2kLF2dxdmrrNBGrm9fkx3",
    "created_at_finix": "2024-02-18T04:09:27.17Z",
    "updated_at_finix": "2024-02-18T04:09:28.83Z",
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "additional_purchase_data": null,
    "address_verification": null,
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "currency": "USD",
    "destination": null,
    "externally_funded": "UNKNOWN",
    "failure_code": null,
    "failure_message": null,
    "fee": 0,
    "idempotency_id": null,
    "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "parent_transfer": null,
    "parent_transfer_trace_id": null,
    "raw": null,
    "ready_to_settle_at": null,
    "receipt_last_printed_at": null,
    "security_code_verification": null,
    "source": "PIbyXuLgXsmwR6QZAkUfJydg",
    "split_transfers": "[]",
    "state": "SUCCEEDED",
    "statement_descriptor": "FLX*FINIX FLOWERS",
    "subtype": "API",
    "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
    "trace_id": "247e8476-0051-4c13-abeb-0e449bc4b4dd",
    "type": "DEBIT",
    "_links": null,
    "fee_type": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "merchant_id": null,
    "customer_id": null
}"
`
    },
    {
        "routeName": "Search Charges",
        "info": "Search a charge by 20.",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/charges/search?search=TRxADa5jzJ2GRRM5yejSvpPU\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 30,
            "created_at": "2024-02-18T04:09:29.000000Z",
            "updated_at": "2024-02-18T04:09:29.000000Z",
            "finix_id": "TRh2kLF2dxdmrrNBGrm9fkx3",
            "created_at_finix": "2024-02-18T04:09:27.17Z",
            "updated_at_finix": "2024-02-18T04:09:28.83Z",
            "additional_buyer_charges": null,
            "additional_healthcare_data": null,
            "additional_purchase_data": null,
            "address_verification": null,
            "amount": 2000,
            "amount_requested": 2000,
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "currency": "USD",
            "destination": null,
            "externally_funded": "UNKNOWN",
            "failure_code": null,
            "failure_message": null,
            "fee": 0,
            "idempotency_id": null,
            "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
            "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "messages": "[]",
            "parent_transfer": null,
            "parent_transfer_trace_id": null,
            "raw": null,
            "ready_to_settle_at": null,
            "receipt_last_printed_at": null,
            "security_code_verification": null,
            "source": "PIbyXuLgXsmwR6QZAkUfJydg",
            "split_transfers": "[]",
            "state": "SUCCEEDED",
            "statement_descriptor": "FLX*FINIX FLOWERS",
            "subtype": "API",
            "tags": "{\"userID\":\"userID_1\",\"apikeyID\":\"apikeyID_3\",\"api_userID\":\"api_userID_1\"}",
            "trace_id": "247e8476-0051-4c13-abeb-0e449bc4b4dd",
            "type": "DEBIT",
            "_links": null,
            "fee_type": null,
            "api_key": "3",
            "is_live": 0,
            "api_user": 1,
            "merchant_id": null,
            "customer_id": null
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges\/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges\/search?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges\/search?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/charges\/search",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}`,
    },
    {
        "routeName": "Create Refund",
        "info": "Refund a charge.   Post route",
        "parameters": "'apikey' either user or merchant.'amount' for the refund. POST Route",
        "header": "Endpoint.",
        "parameters": "'apikey' either user or merchant.\n'amount' for in the refund. 'id' for the charge",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'amount' for in the refund.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/refunds -d '{\"apikey\":\"apikey\",\"amount\":1000,\"id\":29}'",
       "exampleResponse": `{
    "id": 33,
    "created_at": "2024-02-18T23:40:11.000000Z",
    "updated_at": "2024-02-18T23:40:11.000000Z",
    "finix_id": "TR5vH9RefrwW5wFspgBSHAxP",
    "created_at_finix": "2024-02-18T23:40:10.94Z",
    "updated_at_finix": "2024-02-18T23:40:11.03Z",
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "additional_purchase_data": null,
    "address_verification": null,
    "amount": 1000,
    "amount_requested": 1000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "currency": "USD",
    "destination": "PIbyXuLgXsmwR6QZAkUfJydg",
    "externally_funded": "UNKNOWN",
    "failure_code": null,
    "failure_message": null,
    "fee": 0,
    "idempotency_id": null,
    "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "parent_transfer": "TRbS8p7qMbTRRWcqMZ7tHpUC",
    "parent_transfer_trace_id": null,
    "raw": null,
    "ready_to_settle_at": null,
    "receipt_last_printed_at": null,
    "security_code_verification": null,
    "source": null,
    "split_transfers": "[]",
    "state": "PENDING",
    "statement_descriptor": "FLX*FINIX FLOWERS",
    "subtype": "API",
    "tags": "{\"tags\":{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"refund\":\"made\"}}",
    "trace_id": "b547ff55-0b17-4708-8075-4e70a4436ab1",
    "type": "REVERSAL",
    "_links": null,
    "fee_type": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "merchant_id": null,
    "customer_id": null
}`

    },
    {
        "routeName": "Create Hold",
        "info": "create a hold for a customer. POST Route",
        "parameters": "'apikey' either user or merchant.\n'cardID' of the card. \n'amount' the amount of the hold. \n'currency' of the hold. \nIf a user key is used the 'merchant' must be provided.",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'cardID' for in the card. 'currency' of the hold.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/holds -d '{\"apikey\":\"apikey\",\"cardID\":55,\"amount\":2000,\"currency\":\"USD\"}'",
        "exampleResponse": `{
    "id": 3,
    "finix_id": "AU89QZLoYQBzeJAt2iysRr2H",
    "finix_created_at": "2024-02-18T23:54:22.54Z",
    "finix_updated_at": "2024-02-18T23:54:22.54Z",
    "3ds_redirect_url": null,
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "card_present_details": "[]",
    "currency": "USD",
    "device": null,
    "expires_at": "2024-02-25T23:54:22.54Z",
    "failure_code": null,
    "failure_message": null,
    "idempotency_id": null,
    "is_void": 0,
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "raw": "[]",
    "security_code_verification": "MATCHED",
    "source": "PIo75Ymokiz32HXQYo3n6wDZ",
    "state": "SUCCEEDED",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "trace_id": "f889b060-5f9a-47fe-b719-b43eb2e1c3d8",
    "transfer": null,
    "void_state": "UNATTEMPTED",
    "created_at": "2024-02-18T23:54:23.000000Z",
    "updated_at": "2024-02-18T23:54:23.000000Z",
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`
    },
    {
        "routeName": "Get Holds",
        "info": "Get a holds by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/holds\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "finix_id": "AU89QZLoYQBzeJAt2iysRr2H",
            "finix_created_at": "2024-02-18T23:54:22.54Z",
            "finix_updated_at": "2024-02-18T23:54:22.54Z",
            "3ds_redirect_url": null,
            "additional_buyer_charges": null,
            "additional_healthcare_data": null,
            "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
            "amount": 2000,
            "amount_requested": 2000,
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_present_details": "[]",
            "currency": "USD",
            "device": null,
            "expires_at": "2024-02-25T23:54:22.54Z",
            "failure_code": null,
            "failure_message": null,
            "idempotency_id": null,
            "is_void": 0,
            "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "messages": "[]",
            "raw": "[]",
            "security_code_verification": "MATCHED",
            "source": "PIo75Ymokiz32HXQYo3n6wDZ",
            "state": "SUCCEEDED",
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
            "trace_id": "f889b060-5f9a-47fe-b719-b43eb2e1c3d8",
            "transfer": null,
            "void_state": "UNATTEMPTED",
            "created_at": "2024-02-18T23:54:23.000000Z",
            "updated_at": "2024-02-18T23:54:23.000000Z",
            "api_key": "3",
            "is_live": 0,
            "api_user": 1
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/holds?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/holds?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/holds?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/holds",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}`
    },
    {
        "routeName": "Get Hold",
        "info": "Get a Hold by id. GET Route",
        "parameters": " 'id' for the Hold either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the Hold in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/holds/3\"",
        "exampleResponse": `{
    "id": 3,
    "finix_id": "AU89QZLoYQBzeJAt2iysRr2H",
    "finix_created_at": "2024-02-18T23:54:22.54Z",
    "finix_updated_at": "2024-02-18T23:54:22.54Z",
    "3ds_redirect_url": null,
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "card_present_details": "[]",
    "currency": "USD",
    "device": null,
    "expires_at": "2024-02-25T23:54:22.54Z",
    "failure_code": null,
    "failure_message": null,
    "idempotency_id": null,
    "is_void": 0,
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "raw": "[]",
    "security_code_verification": "MATCHED",
    "source": "PIo75Ymokiz32HXQYo3n6wDZ",
    "state": "SUCCEEDED",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "trace_id": "f889b060-5f9a-47fe-b719-b43eb2e1c3d8",
    "transfer": null,
    "void_state": "UNATTEMPTED",
    "created_at": "2024-02-18T23:54:23.000000Z",
    "updated_at": "2024-02-18T23:54:23.000000Z",
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`
    },
    {
        "routeName": "Search Hold",
        "info": "Search a Holds by 20.",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/holds/search?search=AU89QZLoYQBzeJAt2iysRr2H0\"",
        "exampleResponse": `{
    "id": 3,
    "finix_id": "AU89QZLoYQBzeJAt2iysRr2H",
    "finix_created_at": "2024-02-18T23:54:22.54Z",
    "finix_updated_at": "2024-02-18T23:54:22.54Z",
    "3ds_redirect_url": null,
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "card_present_details": "[]",
    "currency": "USD",
    "device": null,
    "expires_at": "2024-02-25T23:54:22.54Z",
    "failure_code": null,
    "failure_message": null,
    "idempotency_id": null,
    "is_void": 0,
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "raw": "[]",
    "security_code_verification": "MATCHED",
    "source": "PIo75Ymokiz32HXQYo3n6wDZ",
    "state": "SUCCEEDED",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "trace_id": "f889b060-5f9a-47fe-b719-b43eb2e1c3d8",
    "transfer": null,
    "void_state": "UNATTEMPTED",
    "created_at": "2024-02-18T23:54:23.000000Z",
    "updated_at": "2024-02-18T23:54:23.000000Z",
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`
    },
    {
        "routeName": "Capture Hold",
        "info": "Capture a hold. POST Route",
        "parameters": "'apikey' either user or merchant.\n'id' for the hold. \n'amount' the amount of the hold.",
        "header": "Endpoint",
        "query": "'id' for the hold in the url",
        "data": "'apikey' either user or merchant. for the hold. 'amount' of the hold.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/holds/3/capture -d '{\"apikey\":\"apikey\",\"amount\":200}'",
        "exampleResponse": `{
    "id": 35,
    "created_at": "2024-02-19T00:34:06.000000Z",
    "updated_at": "2024-02-19T00:34:06.000000Z",
    "finix_id": "AU89QZLoYQBzeJAt2iysRr2H",
    "created_at_finix": "2024-02-18T23:54:22.54Z",
    "updated_at_finix": "2024-02-19T00:34:06.35Z",
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "additional_purchase_data": null,
    "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "currency": "USD",
    "destination": null,
    "externally_funded": null,
    "failure_code": null,
    "failure_message": null,
    "fee": null,
    "idempotency_id": null,
    "merchant": "MUaXkxZqRbtt641fvcSRrZx2",
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "parent_transfer": null,
    "parent_transfer_trace_id": null,
    "raw": null,
    "ready_to_settle_at": null,
    "receipt_last_printed_at": null,
    "security_code_verification": "MATCHED",
    "source": "PIo75Ymokiz32HXQYo3n6wDZ",
    "split_transfers": "[]",
    "state": "SUCCEEDED",
    "statement_descriptor": null,
    "subtype": null,
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "trace_id": "f889b060-5f9a-47fe-b719-b43eb2e1c3d8",
    "type": null,
    "_links": null,
    "fee_type": null,
    "api_key": "3",
    "is_live": 0,
    "api_user": 1,
    "merchant_id": null,
    "customer_id": null
}`
    },
    {
        "routeName": "Release Hold",
        "info": "Release a hold. POST Route",
        "parameters": "'apikey' either user or merchant.\n'id' for the hold.",
        "header": "Endpoint",
        "query": "'id' for the hold in the url",
        "data": "'apikey' either user or merchant.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/holds/6/release -d '{\"apikey\":\"apikey\"}'",
        "exampleResponse": `{
    "id": 6,
    "finix_id": "AUfrMt9RPBk9zXLyp9ALjsTe",
    "finix_created_at": "2024-02-19T00:59:33.77Z",
    "finix_updated_at": "2024-02-19T00:59:50.16Z",
    "3ds_redirect_url": null,
    "additional_buyer_charges": null,
    "additional_healthcare_data": null,
    "address_verification": "POSTAL_CODE_AND_STREET_MATCH",
    "amount": 2000,
    "amount_requested": 2000,
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "card_present_details": "[]",
    "currency": "USD",
    "device": null,
    "expires_at": "2024-02-26T00:59:33.77Z",
    "failure_code": null,
    "failure_message": null,
    "idempotency_id": null,
    "is_void": 1,
    "merchant_identity": "IDewwm9KSQ7Ngttkg5myWYK6",
    "messages": "[]",
    "raw": "null",
    "security_code_verification": "MATCHED",
    "source": "PIo75Ymokiz32HXQYo3n6wDZ",
    "state": "SUCCEEDED",
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_3\",\"userID\":\"userID_1\"}",
    "trace_id": "d92070c3-017d-46b6-ba1f-8dbcb16f1811",
    "transfer": null,
    "void_state": "PENDING",
    "created_at": "2024-02-19T00:59:34.000000Z",
    "updated_at": "2024-02-19T00:59:50.000000Z",
    "api_key": "3",
    "is_live": 0,
    "api_user": 1
}`
    },
];

// Now you can access data like this:
console.log(data[0].routeName); // Output: Create Customer
console.log(data[0].info); // Output: Create a customer to attach a card for payments.
console.log(data[0].exampleRequest); // Output: curl -X GET -H "Content-Type: application/json"  {{url('')}}/createCustomer -d '{"apikey":"apikey","email":"email@example.com"}'


        // data = JSON.parse(data);

        function loadData(data) {
            const navList = document.getElementById('navList');
            const mainContent = document.getElementById('mainContent');

            // Populate side navigation
            data.forEach(route => {
                const listItem = document.createElement('li');
                const link = document.createElement('a');
                link.href = `#${route.routeName.toLowerCase().replace(/\s+/g, '-')}`;
                link.textContent = route.routeName;
                listItem.appendChild(link);
                navList.appendChild(listItem);
            });

            // Populate main content
            data.forEach(route => {
                const section = document.createElement('section');
                section.id = route.routeName.toLowerCase().replace(/\s+/g, '-');
                route.exampleRequest = route.exampleRequest
    .split('{').join('{\n')
    .split(',').join(',\n')
    .split('-d').join('\n-d')
    .split('}').join('\n}');
                section.innerHTML = `
                <div class="floatcontainer">
                    <div>
                        <h2>${route.routeName}</h2>
                        <p>${route.info}</p>

                        <h3>Parameters</h3>
                        <p>${route.parameters}</p>

                        <h3>Header</h3>
                        <p>${route.header}</p>

                        <h3>Query</h3>
                        <p>${route.query}</p>

                        <h3>Data</h3>
                        <p>${route.data}</p>
                    </div>

                    <div>
                        <h3>Example Request</h3>
                        <code class="language-curl">${route.exampleRequest}</code>

                        <h3>Example Response Http Code: 201</h3>
                        <pre class="language-json">${route.exampleResponse}</pre>
                    </div>
                </div>
                `;

                mainContent.appendChild(section);
            });
        }

        loadData(data);

    </script>

</body>
</html>
