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
    color: #062451;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    color: #062451;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 18px;
    color: #062451;
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="checkbox"] {
    margin-bottom: 0;
    width: auto;
    margin-right: 5px;
}

input[type="submit"],
input[type="button"] {
    background-color: #062451;
    color: #fff;
    cursor: pointer;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    border-radius: 4px;
}

input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: #45a049;
}

/* Styling for placeholder values fill button */
input[type="button"] {
    margin-top: 10px;
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
            //div.appendChild(document.createElement('br'));
            div.appendChild(input);
            form.appendChild(div);
        }



        // Example JSON data
        const jsonData = "{\n              \"entity\": {\n          \"annual_card_volume\": 12000000,\n          \"business_address\": {\n            \"city\": \"San Mateo\",\n            \"country\": \"USA\",\n            \"region\": \"CA\",\n            \"line2\": \"Apartment 8\",\n            \"line1\": \"741 Douglass St\",\n            \"postal_code\": \"94114\"\n          },\n          \"business_name\": \"Finix Flowers\",\n          \"business_phone\": \"+1 (408) 756-4497\",\n          \"business_tax_id\": \"123456789\",\n          \"business_type\": \"INDIVIDUAL_SOLE_PROPRIETORSHIP\",\n          \"default_statement_descriptor\": \"Finix Flowers\",\n          \"dob\": {\n            \"year\": 1978,\n            \"day\": 27,\n            \"month\": 6\n          },\n          \"doing_business_as\": \"Finix Flowers\",\n          \"email\": \"user@example.org\",\n          \"first_name\": \"John\",\n          \"has_accepted_credit_cards_previously\": true,\n          \"incorporation_date\": {\n            \"year\": 1978,\n            \"day\": 27,\n            \"month\": 6\n          },\n          \"last_name\": \"Smith\",\n          \"max_transaction_amount\": 1200000,\n          \"ach_max_transaction_amount\": 1000000,\n          \"mcc\": \"4900\",\n          \"ownership_type\": \"PRIVATE\",\n          \"personal_address\": {\n            \"city\": \"San Mateo\",\n            \"country\": \"USA\",\n            \"region\": \"CA\",\n            \"line2\": \"Apartment 7\",\n            \"line1\": \"741 Douglass St\",\n            \"postal_code\": \"94114\"\n          },\n          \"phone\": \"14158885080\",\n          \"principal_percentage_ownership\": 50,\n          \"tax_id\": \"123456789\",\n          \"title\": \"CEO\",\n          \"url\": \"https://www.finix.com\"\n        }, \"bank\": { \"account_number\": \"123123123\", \"account_type\": \"SAVINGS\", \"bank_code\": \"123123123\" ,\"name\": \"John Smith\",\"type\": \"BANK_ACCOUNT\"} }";
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
        fillButton.innerText = 'Fill with placeholder values?';
        fillButton.value = 'Fill with placeholder values?';
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
