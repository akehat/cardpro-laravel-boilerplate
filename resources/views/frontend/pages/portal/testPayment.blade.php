@extends('frontend.pages.portal.welcome')

@section('content')
    <style>
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

    <h1>Test Payment Form</h1>

    <form id="jsonForm" action="{{url('paymentTest')}}" method="POST">
        {{ csrf_field() }}
        <select id="merchant" name="merchant"></select>
    </form>

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

        function getMerchantData(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);
            for (let i = 0; i < values.length; i++) {
                var value = values[i];
                if (typeof value === 'object' && !Array.isArray(value)) {
                    getMerchantData(value);
                } else if (Array.isArray(value)) {
                    arrayToSelect2(value);
                }
            }
        }

        function arrayToSelect2(array) {
            var container = document.getElementById("merchant");
            array.forEach(obj => {
                var option = document.createElement('option');
                option.value = obj["finix_id"];
                option.text = "merchant ID: " + obj["id"] + " merchant Identity:" + obj["identity"];
                container.appendChild(option);
            });
        }

        function fillForm(key, value) {
            const form = document.getElementById('jsonForm');
            const div = document.createElement('div');
            const label = document.createElement('label');
            label.style = "text-transform: capitalize; font-size:20px;";
            label.innerText = key.replaceAll("_", " ");
            const input = document.createElement('input');
            var add = true;
            if (typeof value === 'number') {
                input.type = 'number';
            } else {
                if (value == true || value == false || value.toLowerCase() == "true" || value.toLowerCase() == "false") {
                    input.type = 'checkbox';
                    input.value = "true";
                    add = false;
                } else {
                    input.type = 'text';
                }
            }
            input.required = true;
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
        const jsonData = `{
            "email": "john.doe@example.com",
            "name": "John Doe",
            "card_number": "5200828282828210",
            "cvv": "022",
            "exp_month": "12",
            "exp_year": "2029",
            "amount_in_cents": "2000",
            "currency": "USD"
        }`;

        // Example merchant data (replace with your actual merchant data)
        const merchantDataJson = `{!! $merchantJson !!}`;
        const merchantData = JSON.parse(merchantDataJson);
        getMerchantData(merchantData);

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
        fillButton.innerText = 'Fill with placeholder values';
        fillButton.value = 'Fill with placeholder values';
        fillButton.onclick = function () {
            var matches = document.querySelectorAll("input[type=text],input[type=number]");
            matches.forEach((match) => {
                match.value = match.placeholder;
            });
            var matches = document.querySelectorAll("input[type=checkbox]");
            matches.forEach((match) => {
                if (match.placeholder == 'true') {
                    match.checked = true;
                }
            });
        };
        form.appendChild(fillButton);
    </script>
@endsection
