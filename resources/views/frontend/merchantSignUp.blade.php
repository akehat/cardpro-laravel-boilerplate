<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON to HTML Form</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Merchant Information Form</h1>

    <form id="jsonForm" action="{{url('signup')}}" method="POST">{{ csrf_field() }}</form>

    <script>
        function createForm(data, parent = '') {
            var keys = Object.keys(data);
            var values = Object.values(data);
            for (let i = 0; i < values.length; i++) {
                var value = values[i];
                var key = parent + keys[i];
                if (typeof value == 'object') {
                    createForm(value, key + '_');
                } else {
                    fillForm(key, value);
                }
            }
        }

        function fillForm(key, value) {
            const form = document.getElementById('jsonForm');
            const div = document.createElement('div');
            const label = document.createElement('label');
            label.style = "text-transform: capitalize; font-size:20px;";
            label.innerText = key.replaceAll("_", " ");
            const input = document.createElement('input');
            var add=true;
            if(typeof value ==='number'){
                input.type = 'number';
            }else{
                if(value==true || value==false ||value.toLowerCase() == "true" || value.toLowerCase() == "false"){
                    input.type = 'checkbox';
                    input.value="true";
                    add=false;
                }else{
                    input.type = 'text';
                }
            }
            input.required=true;
            input.name = key;
            input.id = key;
            label.for = key;
            input.placeholder = value;
            div.appendChild(label);
            div.appendChild(document.createElement('br'));
            div.appendChild(input);
            form.appendChild(div);
        }

        

        // Example JSON data
        const jsonData = "{\n        \"additional_underwriting_data\": {\n          \"annual_ach_volume\": 200000,\n          \"average_ach_transfer_amount\": 200000,\n          \"average_card_transfer_amount\": 200000,\n          \"business_description\": \"SB3 vegan cafe\",\n          \"card_volume_distribution\": {\n            \"card_present_percentage\": 30,\n            \"mail_order_telephone_order_percentage\": 10,\n            \"ecommerce_percentage\": 60\n          },\n          \"credit_check_allowed\": true,\n          \"credit_check_ip_address\": \"42.1.1.113\",\n          \"credit_check_timestamp\": \"2021-04-28T16:42:55Z\",\n          \"credit_check_user_agent\": \"Mozilla 5.0(Macintosh; IntelMac OS X 10 _14_6)\",\n          \"merchant_agreement_accepted\": true,\n          \"merchant_agreement_ip_address\": \"42.1.1.113\",\n          \"merchant_agreement_timestamp\": \"2021-04-28T16:42:55Z\",\n          \"merchant_agreement_user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6)\",\n          \"refund_policy\": \"MERCHANDISE_EXCHANGE_ONLY\",\n          \"volume_distribution_by_business_type\": {\n            \"other_volume_percentage\": 0,\n            \"consumer_to_consumer_volume_percentage\": 0,\n            \"business_to_consumer_volume_percentage\": 0,\n            \"business_to_business_volume_percentage\": 100,\n            \"person_to_person_volume_percentage\": 0\n          }\n        },\n        \"entity\": {\n          \"annual_card_volume\": 12000000,\n          \"business_address\": {\n            \"city\": \"San Mateo\",\n            \"country\": \"USA\",\n            \"region\": \"CA\",\n            \"line2\": \"Apartment 8\",\n            \"line1\": \"741 Douglass St\",\n            \"postal_code\": \"94114\"\n          },\n          \"business_name\": \"Finix Flowers\",\n          \"business_phone\": \"+1 (408) 756-4497\",\n          \"business_tax_id\": \"123456789\",\n          \"business_type\": \"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\n          \"default_statement_descriptor\": \"Finix Flowers\",\n          \"dob\": {\n            \"year\": 1978,\n            \"day\": 27,\n            \"month\": 6\n          },\n          \"doing_business_as\": \"Finix Flowers\",\n          \"email\": \"user@example.org\",\n          \"first_name\": \"John\",\n          \"has_accepted_credit_cards_previously\": true,\n          \"incorporation_date\": {\n            \"year\": 1978,\n            \"day\": 27,\n            \"month\": 6\n          },\n          \"last_name\": \"Smith\",\n          \"max_transaction_amount\": 1200000,\n          \"ach_max_transaction_amount\": 1000000,\n          \"mcc\": \"4900\",\n          \"ownership_type\": \"PRIVATE\",\n          \"personal_address\": {\n            \"city\": \"San Mateo\",\n            \"country\": \"USA\",\n            \"region\": \"CA\",\n            \"line2\": \"Apartment 7\",\n            \"line1\": \"741 Douglass St\",\n            \"postal_code\": \"94114\"\n          },\n          \"phone\": \"14158885080\",\n          \"principal_percentage_ownership\": 50,\n          \"tax_id\": \"123456789\",\n          \"title\": \"CEO\",\n          \"url\": \"https://www.finix.com\"\n        },\n        \"tags\": {\n          \"Studio Rating\": \"4.7\"\n        }}";
        var data = JSON.parse(jsonData);
        createForm(data);
        // Added submit button
        const form = document.getElementById('jsonForm');
        const submitButton = document.createElement('input');
        submitButton.type = 'submit';
        submitButton.value = 'Submit';
        form.appendChild(submitButton);
        const fillButton = document.createElement('input');
        fillButton.type = 'button';
        fillButton.innerText = 'fill with placeholder values';
        fillButton.value = 'fill with placeholder values';
        fillButton.onclick=function(){
            var matches = document.querySelectorAll("input[type=text],input[type=number]");
            matches.forEach((match) => {
               match.value=match.placeholder;
            });
            var matches = document.querySelectorAll("input[type=checkbox]");
            matches.forEach((match) => {
                if(match.placeholder=='true'){
                    match.checked=true;
                }
            });
        };
        form.appendChild(fillButton);
    </script>
</body>
</html>