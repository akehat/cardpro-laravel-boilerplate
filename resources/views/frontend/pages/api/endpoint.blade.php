<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{appName()}} | API Documentation </title>
    <link rel="icon"  href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/themes/prism-tomorrow.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>
    <link href="
https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css
" rel="stylesheet">

    <style>

        h2{
            color:rgb(4, 4, 128);
            font-size: 30px;
        }
        h5{
            font-size: 18px;
            color: #1319c0;
        }
.post{
    color:blue;
}
.get{
    color:darkblue;
}
.floatHolder {
    margin-bottom:10%;
    display: flex;
    flex-wrap: wrap;
}

.floatHolder > div {
    width: max(48%,400px);
}
.jsonHolder, .curlHolder{
    padding: 10px;
    margin-bottom: 15px;
    background: rgb(242, 240, 243);
    border-radius: 10px;
    box-shadow: 5px 5px 10px black;
    border:1px solid lightblue;
    max-width: 81vw;
}
.paramHolder{
    padding: 10px;
    margin-bottom: 15px;
    margin-right: 15px;
    background: rgb(242, 240, 243);
    border-radius: 10px;
    box-shadow: 5px 5px 10px black;
    border:1px solid lightblue;
}
p{
    white-space: pre-wrap;
}
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;

        }

        header {
            background-color: #1e325b;
            color: white;
            padding: 1px;
            text-align: center;
            height: 62px;
        }

        .Holder {
            display: flex;
            overflow: hidden;
            height: calc(100vh - 65px);
        }
        nav {
    background-color: #1e325b; /* Dark blue background color */
    border-right: 1px solid #000; /* Black border */
    padding: 20px;

    width: 300px;
    overflow-y: auto;
    max-height: 100%;
    height: 100%;
    color: #fff; /* White text color */
    font-weight: bold; /* Thicker font */
}

/* Customizing scrollbar */
nav::-webkit-scrollbar {
    width: 6px; /* Width of the scrollbar */
}

nav::-webkit-scrollbar-track {
    background: #2b2b2b; /* Track color */
}

nav::-webkit-scrollbar-thumb {
    background: #888; /* Thumb color */
    border-radius: 6px; /* Round corners */
}

nav::-webkit-scrollbar-thumb:hover {
    background: #666; /* Hover color */
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
    color: #fff; /* White text color */
    text-decoration: none;
    transition: color 0.3s ease;
    font-weight: normal; /* Normal font weight */
    line-height: 22px;
}

nav ul li a:hover {
    color: #b3b3b3; /* Light text color on hover */
}


        main {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            max-height: calc(100vh - 65px);
            height: calc(100vh - 65px);
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
            margin: 3px;
            border-radius: 5px;
            white-space: pre-wrap;
            max-height: 500px;
            overflow-y: scroll;
        }
        #navList {
            position: relative;
            top: 10px; /* Adjust as needed based on your layout */
            left: 0;
            padding-bottom: 300px;
        }
        @media only screen and (max-width: 480px) {
        nav{
            width: min-content;
            max-width: min-content;
        }
        #navList {
            display: none;
            /* width: 50%; */
            position: relative;
            top: 0px; /* Adjust as needed based on your layout */
            left: 0;
            /* background-color: #f0f0f0;Your brand color */
        }

        #navList li {
            display: block;
            margin: 10px 0;
        }
        #sidenavButton:not(.hidden){
            display: block!important;
            color:white;
        }
        #navList:hover {
            display: block;
        }


}
#navList a.active {
    color: #ffd700; /* Yellow color */
}
.logo-link {
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    text-decoration: none;
    margin: auto;
    margin-top: 7px
}
.no-link{
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
}
.logo-link img {
    margin-right: 10px; /* Adjust as needed */
}
.logo-link span {
    margin-right: 10px; /* Adjust as needed */
}
section:last-of-type{
    padding-bottom: 550px;
}
    </style>
</head>
<body>
    <header>
        <h4 class="logo-link">
            <a href="{{url('')}}" id="logoLink" class="no-link">
                <img src="{{ asset('img/logo-white.png') }}" alt="Card Wiz Pro" height="40">
                <span>{{appName()}}</span>
            </a>
            <span> </span>API Documentation
        </h4>

    </header>

    <div class="Holder">
        <nav id="sidenav">
            <span id="sidenavButton" style="display: none">></span>
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
        document.querySelector('#sidenav').style.width = '70%';
        document.querySelector('#sidenav').style.minWidth = '70%';
        document.querySelector('#sidenav').style.position = 'absolute';
        document.querySelector('#sidenavButton').classList.add("hidden");;
    }
});

document.querySelector('#sidenav').addEventListener('mouseleave', function () {
    if (window.innerWidth <= 480) { // Check if screen size is phone
        document.querySelector('#navList').style.display = 'none';
        document.querySelector('#sidenav').style.width = 'min-content';
        document.querySelector('#sidenav').style.minWidth = 'min-content';
        document.querySelector('#sidenav').style.position = 'relative';
        document.querySelector('#sidenavButton').classList.remove("hidden");;
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
        "info": "Get a customers by 20. GET Route",
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
        "routeName": "Create Payment Way",
        "info": "Create a card. POST Route",
        "parameters": "'apikey' either user or merchant.'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card. 'descriptor' for the charge if wanted, none will use default of merchant. POST Route",
        "header": "Endpoint.",
        "parameters": "'apikey' either user or merchant.'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card.",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'exp_month' for the card. 'exp_year' for the card.'name' for the card. 'card_number' for the card. 'cvv' for the card. 'id' for the customer to add the card. 'descriptor' for the charge if wanted, none will use default of merchant.",
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
        "info": "Get a charge by 20. GET Route",
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
        "routeName": "Search Payment Ways",
        "info": "Search a Payment Ways by 20. GET Route",
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
        "info": "Get a charge by 20. GET Route",
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
        "info": "Search a charge by 20. GET Route",
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
        "info": "Refund a charge. POST Route",
        "parameters": "'apikey' either user or merchant.'amount' for the refund. POST Route",
        "header": "Endpoint.",
        "parameters": "'apikey' either user or merchant.\n'amount' for in the refund. 'id' for the charge",
        "header": "Endpoint",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'amount' for in the refund.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/refunds -d '{\"apikey\":\"apikey\",\"amount\":1000.\"id\":29}'",
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
        "info": "Get a holds by 20. GET Route",
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
        "info": "Search a Holds by 20. GET Route",
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
     {
        "routeName": "Create Merchant Identity",
        "info": "Create a Merchant Identity to be used to make a new merchant. POST Route",
        "parameters": "'apikey' either user or merchant.'annual_card_volume': The total annual volume of card transactions processed by the business.'business_address_city': The city where the business is located.'business_address_country': The country where the business is located.'business_address_region': The region (state, province, etc) where the business is located.'business_address_line2': Additional address line (if applicable) for the business location.'business_address_line1': The primary address line for the business location.'business_address_postal_code': The postal code of the business location.'business_name': The legal name of the business.'business_phone': The phone number of the business.'business_tax_id': The tax identification number (TIN) or other business identifier.'business_type': The type or category of the business (eg, retail, service, etc).'default_statement_descriptor': The default statement descriptor to appear on customers' credit card statements.'dob_year': The birth year of the individual applicant or representative of the business.'dob_day': The birth day of the individual applicant or representative of the business.'dob_month': The birth month of the individual applicant or representative of the business.'doing_business_as': The trade name or \"doing business as\" (DBA) name of the business, if different from the legal name.'email': The email address of the individual applicant or representative of the business.'first_name': The first name of the individual applicant or representative of the business.'has_accepted_credit_cards_previously': Indicates whether the business has previously accepted credit cards (optional).'incorporation_date_year': The year the business was incorporated or established.'incorporation_date_day': The day of the month the business was incorporated or established.'incorporation_date_month': The month the business was incorporated or established.'last_name': The last name of the individual applicant or representative of the business.'max_transaction_amount': The maximum transaction amount allowed for the business.'ach_max_transaction_amount': The maximum transaction amount allowed for Automated Clearing House (ACH) payments.'mcc': The Merchant Category Code (MCC) that represents the type of business.'ownership_type': The type of ownership structure of the business (eg, sole proprietorship, partnership, corporation).'personal_address_city': The city of the individual applicant's personal address.'personal_address_country': The country of the individual applicant's personal address.'personal_address_region': The region (state, province, etc) of the individual applicant's personal address.'personal_address_line2': Additional address line (if applicable) for the individual applicant's personal address. personal_address_line1': The primary address line for the individual applicant's personal address.'personal_address_postal_code': The postal code of the individual applicant's personal address.'phone': The phone number of the individual applicant or representative of the business.'principal_percentage_ownership': The percentage of ownership held by the principal individual or entity.'tax_id': The personal tax identification number (TIN) or social security number (SSN) of the individual applicant.'title': The title or role of the individual applicant or representative of the business.'url': The website URL of the business.",
        "header": "Endpoint",
        "query": "",
        "data": "'apikey' either user or merchant.'annual_card_volume': The total annual volume of card transactions processed by the business.'business_address_city': The city where the business is located.'business_address_country': The country where the business is located.'business_address_region': The region (state, province, etc) where the business is located.'business_address_line2': Additional address line (if applicable) for the business location.'business_address_line1': The primary address line for the business location.'business_address_postal_code': The postal code of the business location.'business_name': The legal name of the business.'business_phone': The phone number of the business.'business_tax_id': The tax identification number (TIN) or other business identifier.'business_type': The type or category of the business (eg, retail, service, etc).'default_statement_descriptor': The default statement descriptor to appear on customers' credit card statements.'dob_year': The birth year of the individual applicant or representative of the business.'dob_day': The birth day of the individual applicant or representative of the business.'dob_month': The birth month of the individual applicant or representative of the business.'doing_business_as': The trade name or \"doing business as\" (DBA) name of the business, if different from the legal name.'email': The email address of the individual applicant or representative of the business.'first_name': The first name of the individual applicant or representative of the business.'has_accepted_credit_cards_previously': Indicates whether the business has previously accepted credit cards (optional).'incorporation_date_year': The year the business was incorporated or established.'incorporation_date_day': The day of the month the business was incorporated or established.'incorporation_date_month': The month the business was incorporated or established.'last_name': The last name of the individual applicant or representative of the business.'max_transaction_amount': The maximum transaction amount allowed for the business.'ach_max_transaction_amount': The maximum transaction amount allowed for Automated Clearing House (ACH) payments.'mcc': The Merchant Category Code (MCC) that represents the type of business.'ownership_type': The type of ownership structure of the business (eg, sole proprietorship, partnership, corporation).'personal_address_city': The city of the individual applicant's personal address.'personal_address_country': The country of the individual applicant's personal address.'personal_address_region': The region (state, province, etc) of the individual applicant's personal address.'personal_address_line2': Additional address line (if applicable) for the individual applicant's personal address. personal_address_line1': The primary address line for the individual applicant's personal address.'personal_address_postal_code': The postal code of the individual applicant's personal address.'phone': The phone number of the individual applicant or representative of the business.'principal_percentage_ownership': The percentage of ownership held by the principal individual or entity.'tax_id': The personal tax identification number (TIN) or social security number (SSN) of the individual applicant.'title': The title or role of the individual applicant or representative of the business.'url': The website URL of the business.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/merchants/identity -d '{\"apikey\":\"apikey\",\"annual_card_volume\": 12000000,\"business_address_city\":\"San Mateo\",\"business_address_country\":\"USA\",\"business_address_region\":\"CA\",\"business_address_line2\":\"Apartment 8\",\"business_address_line1\":\"741 Douglass St\",\"business_address_postal_code\":\"94114\",\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id\":\"123456789\",\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"dob_year\": 1978,\"dob_day\": 27,\"dob_month\": 6,\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\": true,\"incorporation_date_year\": 1978,\"incorporation_date_day\": 27,\"incorporation_date_month\": 6,\"last_name\":\"Smith\",\"max_transaction_amount\": 1200000,\"ach_max_transaction_amount\": 1000000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address_city\":\"San Mateo\",\"personal_address_country\":\"USA\",\"personal_address_region\":\"CA\",\"personal_address_line2\":\"Apartment 7\",\"personal_address_line1\":\"741 Douglass St\",\"personal_address_postal_code\":\"94114\",\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"tax_id\":\"123456789\",\"title\":\"CEO\",\"url\":\"https://www.finix.com\"}'",
        "exampleResponse": `{
    "id": 84,
    "created_at": "2024-03-26T22:52:12.000000Z",
    "updated_at": "2024-03-26T22:52:12.000000Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
    "identity_roles": "[\"SELLER\"]",
    "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
    "_links": null,
    "api_key": null,
    "is_live": 0,
    "api_user": 1,
    "finix_id": "ID5kQmeLzHM7XZg9gxp7TLsq",
    "finix_merchant_id": null,
    "customer_id": null,
    "isBuyer": 0,
    "isMerchant": 1
}`},
    {
        "routeName": "Get Merchants Identities",
        "info": "Get a holds by 20. GET Route",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/identity\"",
        "exampleResponse":`{
    "current_page": 1,
    "data": [
        {
            "id": 73,
            "created_at": "2024-02-12T00:46:02.000000Z",
            "updated_at": "2024-02-12T00:46:02.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
            "identity_roles": "[\"SELLER\"]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": null,
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDewwm9KSQ7Ngttkg5myWYK6",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 0,
            "isMerchant": 1
        },
        {
            "id": 81,
            "created_at": "2024-02-25T03:50:24.000000Z",
            "updated_at": "2024-02-25T03:50:24.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
            "identity_roles": "[\"SELLER\"]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": null,
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDgKs2u1rhAi18yX8pHV84sV",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 0,
            "isMerchant": 1
        },
        {
            "id": 82,
            "created_at": "2024-02-25T05:15:13.000000Z",
            "updated_at": "2024-02-25T05:15:13.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
            "identity_roles": "[\"SELLER\"]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": null,
            "is_live": 0,
            "api_user": 1,
            "finix_id": "IDugk6mVWXm9XTgrQB2JPcTF",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 0,
            "isMerchant": 1
        },
        {
            "id": 84,
            "created_at": "2024-03-26T22:52:12.000000Z",
            "updated_at": "2024-03-26T22:52:12.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
            "identity_roles": "[\"SELLER\"]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": null,
            "is_live": 0,
            "api_user": 1,
            "finix_id": "ID5kQmeLzHM7XZg9gxp7TLsq",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 0,
            "isMerchant": 1
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity?page=1",
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
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity",
    "per_page": 20,
    "prev_page_url": null,
    "to": 4,
    "total": 4
}`
    },
    {
        "routeName": "Get Merchant Identity",
        "info": "Get a Merchant Identity by id. GET Route",
        "parameters": " 'id' for the Merchant Identity either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the Merchant Identity in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/identity/84\"",
        "exampleResponse": `{
    "id": 84,
    "created_at": "2024-03-26T22:52:12.000000Z",
    "updated_at": "2024-03-26T22:52:12.000000Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
    "identity_roles": "[\"SELLER\"]",
    "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
    "_links": null,
    "api_key": null,
    "is_live": 0,
    "api_user": 1,
    "finix_id": "ID5kQmeLzHM7XZg9gxp7TLsq",
    "finix_merchant_id": null,
    "customer_id": null,
    "isBuyer": 0,
    "isMerchant": 1
}`
    },
    {
        "routeName": "Search Merchants Identities",
        "info": "Search merchants identities by 20. GET Route",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/identity/search?search=ID5kQmeLzHM7XZg9gxp7TLsq\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 84,
            "created_at": "2024-03-26T22:52:12.000000Z",
            "updated_at": "2024-03-26T22:52:12.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "entity": "{\"ach_max_transaction_amount\":1000000,\"amex_mid\":null,\"annual_card_volume\":12000000,\"business_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 7\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"business_name\":\"Finix Flowers\",\"business_phone\":\"+1 (408) 756-4497\",\"business_tax_id_provided\":true,\"business_type\":\"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\"default_statement_descriptor\":\"Finix Flowers\",\"discover_mid\":null,\"dob\":{\"day\":27,\"month\":6,\"year\":1978},\"doing_business_as\":\"Finix Flowers\",\"email\":\"user@example.org\",\"first_name\":\"John\",\"has_accepted_credit_cards_previously\":true,\"incorporation_date\":{\"day\":27,\"month\":6,\"year\":1978},\"last_name\":\"Smith\",\"max_transaction_amount\":1200000,\"mcc\":\"4900\",\"ownership_type\":\"PRIVATE\",\"personal_address\":{\"line1\":\"741 Douglass St\",\"line2\":\"Apartment 8\",\"city\":\"San Mateo\",\"region\":\"CA\",\"postal_code\":\"94114\",\"country\":\"USA\"},\"phone\":\"14158885080\",\"principal_percentage_ownership\":50,\"short_business_name\":null,\"tax_authority\":null,\"tax_id_provided\":true,\"title\":\"CEO\",\"url\":\"https:\\\/\\\/www.finix.com\"}",
            "identity_roles": "[\"SELLER\"]",
            "tags": "{\"api_userID\":\"api_userID_1\",\"userID\":\"userID_1\"}",
            "_links": null,
            "api_key": null,
            "is_live": 0,
            "api_user": 1,
            "finix_id": "ID5kQmeLzHM7XZg9gxp7TLsq",
            "finix_merchant_id": null,
            "customer_id": null,
            "isBuyer": 0,
            "isMerchant": 1
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity\/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity\/search?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity\/search?page=1",
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
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/identity\/search",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}`
    },
     {
        "routeName": "Create Merchant Bank",
        "info": "Create a Merchant. POST Route",
        "parameters": "'apikey' either user or merchant.'account_number' The account number. 'account_type' => PERSONAL_CHECKING, PERSONAL_SAVINGS, BUSINESS_CHECKING, BUSINESS_SAVINGS, SAVINGS, CHECKING: The account type must be provided.'bank_code' The bank code.'identity' A merchant id must be provided, indicating the account holder's identity.'name' The name field, if provided. 'type' => BANK_ACCOUNT: The type must be provided, and must be equal to BANK_ACCOUNT.",
        "header": "Endpoint",
        "query": "",
        "data": "'apikey' either user or merchant.'account_number' The account number. 'account_type' => PERSONAL_CHECKING, PERSONAL_SAVINGS, BUSINESS_CHECKING, BUSINESS_SAVINGS: The account type must be provided.'bank_code' The bank code.'identity' An identity must be provided, indicating the account holder's identity.'name' The name field, if provided. 'type' => BANK_ACCOUNT: The type must be provided, and must be equal to BANK_ACCOUNT.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/merchant/bank_accounts -d '{\"apikey\":\"apikey\",\"account_number\":\"123123123\",\"account_type\":\"SAVINGS\",\"bank_code\":\"123123123\",\"name\":\"John Smith\",\"identity\":2,\"type\":\"BANK_ACCOUNT\"}'",
        "exampleResponse": `{
    "id": 62,
    "created_at": "2024-03-26T23:32:07.000000Z",
    "updated_at": "2024-03-26T23:32:07.000000Z",
    "finix_id": "PI7cbt26Y2yWEfAAK7Hq8ZHb",
    "created_at_finix": "2024-03-26 23:32:07",
    "updated_at_finix": "2024-03-26 23:32:07",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "created_via": "API",
    "currency": "USD",
    "disabled_code": null,
    "disabled_message": null,
    "enabled": 1,
    "fingerprint": "FPRd5moHxL3Ltuvk4cczxetCg",
    "identity": "ID5kQmeLzHM7XZg9gxp7TLsq",
    "instrument_type": "BANK_ACCOUNT",
    "address": null,
    "address_verification": null,
    "bin": null,
    "brand": null,
    "card_type": null,
    "expiration_month": null,
    "expiration_year": null,
    "issuer_country": null,
    "last_four": null,
    "name": "John Smith",
    "security_code_verification": null,
    "tags": "{\"api_userID\":\"api_userID_\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
    "type": "BANK_ACCOUNT",
    "_links": null,
    "account_type": "SAVINGS",
    "bank_account_validation_check": "NOT_ATTEMPTED",
    "bank_code": "123123123",
    "country": "USA",
    "institution_number": null,
    "masked_account_number": "XXXXX3123",
    "transit_number": null,
    "api_key": "0",
    "is_live": 0,
    "api_user": null
}`}
    ,
     {
        "routeName": "Create Merchant",
        "info": "Create a Merchant. POST Route",
        "parameters": "'apikey' either user or merchant.'id' for the merchant identity turning into a merchant. 'amount' the amount of the hold.'first_name' of the PCI holder. 'last_name' of the PCI holder. 'PCI_title' of the PCI holder. 'browser' of the PCI holder.",
        "header": "Endpoint",
        "query": "",
        "data": "'apikey' either user or merchant. 'id' for the merchant identity turning into a merchant. 'amount' the amount of the hold.'first_name' of the PCI holder. 'last_name' of the PCI holder. 'PCI_title' of the PCI holder. 'browser' of the PCI holder.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/merchants -d '{\"apikey\":\"apikey\",\"first_name\":\"Jhon\",\"last_name\":\"Doe\",\"PCI_title\":\"CTO\",\"id\":2,\"browser\":\"Mozilla 5.0(Macintosh; IntelMac OS X 10 _14_6)\"}'",
        "exampleResponse": `{
    "worked": true,
    "responce": "{\n  \"id\" : \"MUckwFvQF5EoMmw1esvxfXmt\",\n  \"created_at\" : \"2024-03-27T00:27:47.03Z\",\n  \"updated_at\" : \"2024-03-27T00:27:47.03Z\",\n  \"application\" : \"APZmjWMcUWgvxGcBV3V6FJ7\",\n  \"card_cvv_required\" : false,\n  \"card_expiration_date_required\" : true,\n  \"convenience_charges_enabled\" : false,\n  \"country\" : \"USA\",\n  \"creating_transfer_from_report_enabled\" : false,\n  \"currencies\" : [ \"USD\" ],\n  \"default_partial_authorization_enabled\" : false,\n  \"disbursements_ach_pull_enabled\" : false,\n  \"disbursements_ach_push_enabled\" : false,\n  \"disbursements_card_pull_enabled\" : false,\n  \"disbursements_card_push_enabled\" : false,\n  \"fee_ready_to_settle_upon\" : \"PROCESSOR_WINDOW\",\n  \"gateway\" : null,\n  \"gross_settlement_enabled\" : false,\n  \"identity\" : \"IDdwT39A4jE6hMsJvg6MgRS1\",\n  \"level_two_level_three_data_enabled\" : false,\n  \"mcc\" : \"4900\",\n  \"merchant_name\" : \"Finix Flowers\",\n  \"merchant_profile\" : \"MPbnEdag4VJYvNVV8ub6GSRk\",\n  \"mid\" : null,\n  \"onboarding_state\" : \"PROVISIONING\",\n  \"processing_enabled\" : false,\n  \"processor\" : \"DUMMY_V1\",\n  \"processor_details\" : { },\n  \"ready_to_settle_upon\" : \"PROCESSOR_WINDOW\",\n  \"rent_surcharges_enabled\" : false,\n  \"settlement_enabled\" : false,\n  \"settlement_funding_identifier\" : \"UNSET\",\n  \"surcharges_enabled\" : false,\n  \"tags\" : {\n    \"api_userID\" : \"api_userID_1\",\n    \"apikeyID\" : \"apikeyID_\",\n    \"userID\" : \"userID_1\"\n  },\n  \"verification\" : \"VIuuDu8ayCEaTXEdQbjMNNAF\",\n  \"_links\" : {\n    \"self\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/merchants\/MUckwFvQF5EoMmw1esvxfXmt\"\n    },\n    \"identity\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/identities\/IDdwT39A4jE6hMsJvg6MgRS1\"\n    },\n    \"verifications\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/merchants\/MUckwFvQF5EoMmw1esvxfXmt\/verifications\"\n    },\n    \"merchant_profile\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/merchant_profiles\/MPbnEdag4VJYvNVV8ub6GSRk\"\n    },\n    \"application\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/applications\/APZmjWMcUWgvxGcBV3V6FJ7\"\n    },\n    \"verification\" : {\n      \"href\" : \"https:\/\/finix.sandbox-payments-api.com\/verifications\/VIuuDu8ayCEaTXEdQbjMNNAF\"\n    }\n  }\n}",
    "ref": {
        "id": 20,
        "created_at": "2024-03-27T00:27:47.000000Z",
        "updated_at": "2024-03-27T00:27:47.000000Z",
        "application": "APZmjWMcUWgvxGcBV3V6FJ7",
        "card_cvv_required": 0,
        "card_expiration_date_required": 1,
        "convenience_charges_enabled": 0,
        "country": "USA",
        "creating_transfer_from_report_enabled": 0,
        "currencies": "[\"USD\"]",
        "default_partial_authorization_enabled": 0,
        "disbursements_ach_pull_enabled": 0,
        "disbursements_ach_push_enabled": 0,
        "disbursements_card_pull_enabled": 0,
        "disbursements_card_push_enabled": 0,
        "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
        "gateway": null,
        "gross_settlement_enabled": 0,
        "identity": "IDdwT39A4jE6hMsJvg6MgRS1",
        "level_two_level_three_data_enabled": null,
        "mcc": 4900,
        "merchant_name": "Finix Flowers",
        "merchant_profile": "MPbnEdag4VJYvNVV8ub6GSRk",
        "mid": null,
        "onboarding_state": "PROVISIONING",
        "processing_enabled": 0,
        "processor": "DUMMY_V1",
        "processor_details": "{}",
        "ready_to_settle_upon": "PROCESSOR_WINDOW",
        "rent_surcharges_enabled": 0,
        "settlement_enabled": 0,
        "settlement_funding_identifier": "UNSET",
        "surcharges_enabled": 0,
        "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_\",\"userID\":\"userID_1\"}",
        "verification": "VIuuDu8ayCEaTXEdQbjMNNAF",
        "_links": null,
        "api_key": "7",
        "total": null,
        "currency": null,
        "is_live": 0,
        "api_user": 1,
        "payments_count": null,
        "finix_id": "MUckwFvQF5EoMmw1esvxfXmt"
    },
    "key": {
        "id": 7,
        "live": 0,
        "api_key": "Api_key20Ow2mdsJo32c1LLPpMt0tm9nLcs50iune",
        "created_at": "2024-03-27T00:27:47.000000Z",
        "updated_at": "2024-03-27T00:27:47.000000Z",
        "api_user": 1,
        "merchant_id": 20,
        "bank_id": null,
        "balance": 0,
        "currency": null,
        "identity": "MUckwFvQF5EoMmw1esvxfXmt",
        "userID": 1
    }
}`
    },
    {
        "routeName": "Get Merchants",
        "info": "Get a merchants by 20. GET Route",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants\"",
        "exampleResponse":`{
    "current_page": 1,
    "data": [
        {
            "id": 14,
            "created_at": "2024-02-06T18:56:03.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDkN19CvRX2ZAAaUrsJbtTX8",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MPj3B2fKoktN8yrJZkvnVUo",
            "mid": "FNXuf1F4GbdCvn9nXVGiVSwLz",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXuf1F4GbdCvn9nXVGiVSwLz\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VI9cAzbxJSTqbMQy2fbkNz16",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MU38kdcaiHyjeitZ38QeuLmm"
        },
        {
            "id": 15,
            "created_at": "2024-02-06T18:56:46.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDfgc7Rr7n2DkMQhoSKdcZDv",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MPqzmW4RWonwt5QAhXnaJT21",
            "mid": "FNXoQq6RcWNAfqdE6HzwhAYed",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXoQq6RcWNAfqdE6HzwhAYed\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VIvTYMzjVjWDpSTrBuhbACuV",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MU9sCJqzqeQqjCHJyjttMdAN"
        },
        {
            "id": 16,
            "created_at": "2024-02-12T00:46:03.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDewwm9KSQ7Ngttkg5myWYK6",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MPjnCbuGPmei2Pt3oNQ2ugM4",
            "mid": "FNXo6WRXGSsBuw1sKMApptg72",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXo6WRXGSsBuw1sKMApptg72\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VIk82Y8BfKDrCJX4uerCRsFL",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MUaXkxZqRbtt641fvcSRrZx2"
        },
        {
            "id": 17,
            "created_at": "2024-02-25T03:50:25.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDgKs2u1rhAi18yX8pHV84sV",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MPuittMSAjyY5ASZYhB7udpj",
            "mid": "FNXbQVxyZkGkVaFs6ktvUZq2n",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXbQVxyZkGkVaFs6ktvUZq2n\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VIceomZVuNLnxU4rRz6vD45s",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MUjD6t558tLPmZ4Qom1Mbwyc"
        },
        {
            "id": 18,
            "created_at": "2024-02-25T05:15:14.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDugk6mVWXm9XTgrQB2JPcTF",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MP2mqmYGkftegRbqzqroabn8",
            "mid": "FNXmaYdGBhNJKwAiNUk64G32T",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXmaYdGBhNJKwAiNUk64G32T\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VI5mib5wWKhh889A2wGTUB4s",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MUh6o9SVp55pk9LfPRbGTMz4"
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants?page=1",
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
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants",
    "per_page": 20,
    "prev_page_url": null,
    "to": 5,
    "total": 5
}`
    },
    {
        "routeName": "Get Merchant",
        "info": "Get a merchant by id. GET Route",
        "parameters": " 'id' for the merchant either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the merchant in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/18\"",
        "exampleResponse": `{
    "id": 18,
    "created_at": "2024-02-25T05:15:14.000000Z",
    "updated_at": "2024-02-26T03:12:39.000000Z",
    "application": "APZmjWMcUWgvxGcBV3V6FJ7",
    "card_cvv_required": 0,
    "card_expiration_date_required": 1,
    "convenience_charges_enabled": 0,
    "country": "USA",
    "creating_transfer_from_report_enabled": 0,
    "currencies": "[\"USD\"]",
    "default_partial_authorization_enabled": 0,
    "disbursements_ach_pull_enabled": 0,
    "disbursements_ach_push_enabled": 0,
    "disbursements_card_pull_enabled": 0,
    "disbursements_card_push_enabled": 0,
    "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
    "gateway": null,
    "gross_settlement_enabled": 0,
    "identity": "IDugk6mVWXm9XTgrQB2JPcTF",
    "level_two_level_three_data_enabled": 0,
    "mcc": 4900,
    "merchant_name": "Finix Flowers",
    "merchant_profile": "MP2mqmYGkftegRbqzqroabn8",
    "mid": "FNXmaYdGBhNJKwAiNUk64G32T",
    "onboarding_state": "APPROVED",
    "processing_enabled": 1,
    "processor": "DUMMY_V1",
    "processor_details": "{\"mid\":\"FNXmaYdGBhNJKwAiNUk64G32T\",\"api_key\":\"secretValue\"}",
    "ready_to_settle_upon": "PROCESSOR_WINDOW",
    "rent_surcharges_enabled": 0,
    "settlement_enabled": 1,
    "settlement_funding_identifier": "UNSET",
    "surcharges_enabled": 0,
    "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
    "verification": "VI5mib5wWKhh889A2wGTUB4s",
    "_links": null,
    "api_key": "0",
    "total": null,
    "currency": null,
    "is_live": 0,
    "api_user": 1,
    "payments_count": null,
    "finix_id": "MUh6o9SVp55pk9LfPRbGTMz4"
}`
    },
    {
        "routeName": "Search Merchant",
        "info": "Search a merchants by 20. GET Route",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/search?search=MUh6o9SVp55pk9LfPRbGTMz4\"",
        "exampleResponse": `{
    "current_page": 1,
    "data": [
        {
            "id": 18,
            "created_at": "2024-02-25T05:15:14.000000Z",
            "updated_at": "2024-02-26T03:12:39.000000Z",
            "application": "APZmjWMcUWgvxGcBV3V6FJ7",
            "card_cvv_required": 0,
            "card_expiration_date_required": 1,
            "convenience_charges_enabled": 0,
            "country": "USA",
            "creating_transfer_from_report_enabled": 0,
            "currencies": "[\"USD\"]",
            "default_partial_authorization_enabled": 0,
            "disbursements_ach_pull_enabled": 0,
            "disbursements_ach_push_enabled": 0,
            "disbursements_card_pull_enabled": 0,
            "disbursements_card_push_enabled": 0,
            "fee_ready_to_settle_upon": "PROCESSOR_WINDOW",
            "gateway": null,
            "gross_settlement_enabled": 0,
            "identity": "IDugk6mVWXm9XTgrQB2JPcTF",
            "level_two_level_three_data_enabled": 0,
            "mcc": 4900,
            "merchant_name": "Finix Flowers",
            "merchant_profile": "MP2mqmYGkftegRbqzqroabn8",
            "mid": "FNXmaYdGBhNJKwAiNUk64G32T",
            "onboarding_state": "APPROVED",
            "processing_enabled": 1,
            "processor": "DUMMY_V1",
            "processor_details": "{\"mid\":\"FNXmaYdGBhNJKwAiNUk64G32T\",\"api_key\":\"secretValue\"}",
            "ready_to_settle_upon": "PROCESSOR_WINDOW",
            "rent_surcharges_enabled": 0,
            "settlement_enabled": 1,
            "settlement_funding_identifier": "UNSET",
            "surcharges_enabled": 0,
            "tags": "{\"api_userID\":\"api_userID_1\",\"apikeyID\":\"apikeyID_0\",\"userID\":\"userID_1\"}",
            "verification": "VI5mib5wWKhh889A2wGTUB4s",
            "_links": null,
            "api_key": "0",
            "total": null,
            "currency": null,
            "is_live": 0,
            "api_user": 1,
            "payments_count": null,
            "finix_id": "MUh6o9SVp55pk9LfPRbGTMz4"
        }
    ],
    "first_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/search?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/search?page=1",
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
    "path": "http:\/\/127.0.0.1:8000\/api\/cardwiz\/merchants\/search",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}`
    },
    {
        "routeName": "Get Merchants Totals",
        "info": "Get a holds by 20. GET Route",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/totals\"",
        "exampleResponse":``
    },
    {
        "routeName": "Get Merchant Total",
        "info": "Get a Merchant Identity by id. GET Route",
        "parameters": " 'id' for the Merchant either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the Merchant Identity in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/totals/3\"",
        "exampleResponse": ``
    },
    {
        "routeName": "Search Merchants Totals",
        "info": "Search merchants identities by 20. GET Route",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/merchants/totals/search?search=AU89QZLoYQBzeJAt2iysRr2H0\"",
        "exampleResponse": ``
    }, {
        "routeName": "Fill PCI Form",
        "info": "Fill  a PCI form. POST Route",
        "parameters": "'apikey' either user or merchant.'id' The id for the pci Agreement. 'first_name' The first name for the pci Agreement. 'Last_name' The last name for the pci Agreement.'PCI_title' The title for the pci Agreement. 'browser' of the PCI holder.",
        "header": "Endpoint",
        "query": "",
        "data":"'apikey' either user or merchant.'id' The id for the pci Agreement. 'first_name' The first name for the pci Agreement. 'Last_name' The last name for the pci Agreement.'PCI_title' The title for the pci Agreement. 'browser' of the PCI holder.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/ap/cardwiz/merchants/pcis/fill -d '{\"apikey\":\"apikey\",\"first_name\":\"123123123\",\"account_type\":\"Jhon\",\"Last_name\":\"Doe\",\"PCI_title\":\"CTO\",\"id\":2,\"browser\":\"Mozilla 5.0(Macintosh; IntelMac OS X 10 _14_6)\"}'",
        "exampleResponse": ``}
    ,
    {
        "routeName": "Get PCIs",
        "info": "Get a PCI forms by 20. GET Route",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/pcis\"",
        "exampleResponse":``
    },
    {
        "routeName": "Get PCI",
        "info": "Get a PCI by id. GET Route",
        "parameters": " 'id' for the merchant either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the PCI in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/pcis/3\"",
        "exampleResponse": ``
    },
    {
        "routeName": "Search PCIs",
        "info": "Search a merchants by 20. GET Route",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/pcis/search?search=AU89QZLoYQBzeJAt2iysRr2H0\"",
        "exampleResponse": ``
    },

    {
        "routeName": "Update Dispute",
        "info": "Update a Dispute. POST Route",
        "parameters": "'apikey' either user or merchant.'id' for the dispute. 'file' the file to update the dispute with or 'note' to update the dispute with.",
        "header": "Endpoint. 'id' for the dispute.",
        "query": "",
        "data": "'apikey' either user or merchant. 'file' the file to update the dispute with or 'note' to update the dispute with.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/disputes/2 -d '{\"apikey\":\"apikey\"}' -F 'file=@filename' \nor\n curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/disputes/2 -d '{\"apikey\":\"apikey\",\"note\":\"this is a note\"}'",
        "exampleResponse": ``
    },
     {
        "routeName": "Accept Dispute",
        "info": "Accept a Dispute. POST Route",
        "parameters": "'apikey' either user or merchant.'id' for the dispute. 'note' to update the dispute with.",
        "header": "Endpoint. 'id' for the dispute.",
        "query": "",
        "data": "'apikey' either user or merchant. 'note' to update the dispute with.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/api/cardwiz/disputes/2/accept -d '{\"apikey\":\"apikey\",\"note\":\"this is a note\"}'",
        "exampleResponse": ``
    },
    {
        "routeName": "Get Disputes",
        "info": "Get a holds by 20. GET Route",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/disputes\"",
        "exampleResponse":``
    },
    {
        "routeName": "Get Dispute",
        "info": "Get a Hold by id. GET Route",
        "parameters": " 'id' for the Hold either the number or the long one.",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "'id' for the Hold in the url",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/disputes/3\"",
        "exampleResponse": ``
    },
    {
        "routeName": "Search Disputes",
        "info": "Search a Holds by 20. GET Route",
        "parameters": "'apikey' either user or merchant.'search' what to search for. GET Route",
        "header": "Endpoint. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20. 'search' what to search for.",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/api/cardwiz/disputes/search?search=AU89QZLoYQBzeJAt2iysRr2H0\"",
        "exampleResponse": ``
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
                link.id = `link-to-${route.routeName.toLowerCase().replace(/\s+/g, '-')}`;
                link.textContent = '🌐 '+route.routeName;
                listItem.appendChild(link);
                navList.appendChild(listItem);
            });

            // Populate main content
            data.forEach(route => {
                const section = document.createElement('section');
                section.id = route.routeName.toLowerCase().replace(/\s+/g, '-');
                route.exampleRequest = route.exampleRequest

    .split('-H').join('-H \n')
    .split(' "http').join('\\\n"http')
    .split(' http').join('\\\nhttp')
    .split('-d').join('\\\n-d')
    .split('}').join('\\\n}')
    .replace(/  +/g, ' ')
    .replace(/\n\s/g, "\\\n")
    .split('{').join('{\\\n    ')
    .split(',').join(',\\\n    ')
    .replace(/,\\{1,1}\n/g, ",\n")
    .replace(/{\\{1,1}\n/g, "{\n")
    .replace(/"\\{1,1}/g, '"')
    .replace(/([1-9])\\/g, '$1')
    // .replace('curl',"CURL");
    route.parameters=route.parameters.split('.').join('.\n').replace(/\n\s*/g, "\n").replace(/('[^'\" ]*')/g, "<b>$1</b>");
    route.data=route.data.split('.').join('.\n').replace(/\n\s*/g, "\n").replace(/('[^'\" ]*')/g, "<b>$1</b>");
    route.query=route.query.split('.').join('.\n').replace(/\n\s*/g, "\n").replace(/('[^'\" ]*')/g, "<b>$1</b>");
    route.header=route.header.split('.').join('.\n').replace(/\n\s*/g, "\n").replace(/('[^'\" ]*')/g, "<b>$1</b>");
    route.info=route.info.replace(/(POST Route)/g, "<b class='post'>$1</b>").replace(/(GET Route)/g, "<b class='get'>$1</b>");

                section.innerHTML = `
                <div class="floatHolder">
                    <div>
                        <h2>${route.routeName}</h2>
                        <p>${route.info}</p>
                        <div class="paramHolder">
                            <h5>Parameters</h5>
                            <p>${route.parameters}</p>
                            <h5>Header</h3>
                            <p>${route.header}</p>

                            <h5>Query</h3>
                            <p>${route.query}</p>

                            <h5>Data</h3>
                            <p>${route.data}</p>
                        </div>
                    </div>

                    <div>
                        <div class="curlHolder">
                            <h4 class="h5"><b>Example Request</b>
                            <button class="copyBtn" data-toggle="tooltip" title="Copied!">
                                <i class="fa fa-copy"></i>
                            </button></h4>
                            <code class="language-curl">${route.exampleRequest}</code>

                        </div>
                        <div class="jsonHolder">
                            <h4  class="h5"><b>Example Response Http Code: 201</b></h4>
                            <pre class="language-json">${route.exampleResponse}</pre>
                        </div>
                    </div>
                </div>
                `;
                function copyToClipboard(text) {
                    // alert(text);
                    const tempTextArea = document.createElement('textarea');
                        tempTextArea.value = text;
                        document.body.appendChild(tempTextArea);
                        tempTextArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempTextArea);
                }

                mainContent.appendChild(section);
                const copyBtn = section.querySelector('.copyBtn');
                // const exampleRequestCode = section.querySelector('.exampleRequest code');

                copyBtn.addEventListener('click', function(){
                    copyToClipboard(route.exampleRequest);
                    $(this).tooltip('show');
                    // Reset tooltip after 2 seconds
                    setTimeout(() => {
                        $(this).tooltip('hide');
                    }, 2000);
                });
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({trigger:'manual'})
            })
        }

        loadData(data);
       // Add scroll event listener to update URL based on scrolled section and highlight active link
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('section');
            const mainContent = document.querySelector('#mainContent');
            const navLinks = document.querySelectorAll('#navList a');

            function setActiveLink() {
                let fromTop = mainContent.scrollTop + 85;

                sections.forEach(section => {
                    if (section.offsetTop <= fromTop && section.offsetTop + section.offsetHeight > fromTop) {
                        let id = section.id;
                        // Reset style for all nav links
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                        });
                        // Set style for active nav link
                        const activeLink = document.querySelector(`#link-to-${id}`);
                        if (activeLink) {
                            activeLink.classList.add('active');
                        }
                        window.history.replaceState({}, '', '#' + id);
                    }
                });
            }

            setActiveLink();

            mainContent.addEventListener('scroll', setActiveLink);
        });

    </script>

</body>
</html>
