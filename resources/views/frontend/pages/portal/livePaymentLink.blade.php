@extends('frontend.pages.portal.welcome')

@section('content')
    <style>
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

    <h1>Live Payment Link Form</h1>

    <form id="jsonForm" action="{{url('paylinkLive')}}" method="POST">
        {{ csrf_field() }}
        <select id="merchant" name="merchant"></select>
    </form>

    <script>
        function createForm(data, parent = '') {
            if(data==null)return;
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
            if(input.type != 'checkbox'){
            input.required = true;}
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
        const jsonData = `{
    "allowed_payment_methods": [
      "PAYMENT_CARD"
    ],
    "nickname": "string",
    "items": [
      {
        "image_details": {
          "primary_image_url": "https://google.com/image",
          "alternative_image_urls": [
            "https://google.com/image1",
            "https://google.com/image2"
          ]
        },
        "description": "sunglasses",
        "price_details": {
          "sale_amount": 4000,
          "currency": "USD",
          "price_type": "PROMOTIONAL",
          "regular_amount": 5000
        }
      }
    ],
    "amount_details": {
      "amount_type": "FIXED",
      "total_amount": 5418,
      "currency": "USD",
      "min_amount": null,
      "max_amount": null,
      "amount_breakdown": {
        "subtotal_amount": 3994,
        "shipping_amount": 995,
        "estimated_tax_amount": 429,
        "discount_amount": "1000",
        "tip_amount": "1000"
      }
    },
    "branding": {
      "brand_color": "#ff06b5",
      "accent_color": "#ff06b5",
      "logo": "https://www.example.com/success/123rw21w.svg",
      "icon": "https://www.example.com/success/123rw21w.svg"
    },
    "additional_details": {
      "collect_name": true,
      "collect_email": true,
      "collect_phone_number": true,
      "collect_billing_address": true,
      "collect_shipping_address": true,
      "success_return_url": "https://www.example.com/success/123rw21w.html",
      "cart_return_url": "https://www.example.com/my_cart.html",
      "expired_session_url": "https://example.com/error.html",
      "terms_of_service_url": "https://example.com/terms_of_service.html",
      "expiration_in_minutes": 10080
    }
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

        // const fillButton = document.createElement('input');
        // fillButton.type = 'button';
        // fillButton.innerText = 'Fill with placeholder values?';
        // fillButton.value = 'Fill with placeholder values?';
        // fillButton.onclick = function () {
        //     var matches = document.querySelectorAll("input[type=text],input[type=number]");
        //     matches.forEach((match) => {
        //         match.value = match.placeholder;
        //     });
        //     var matches = document.querySelectorAll("input[type=checkbox]");
        //     matches.forEach((match) => {
        //         if (match.placeholder == 'true') {
        //             match.checked = true;
        //         }
        //     });
        // };
        // form.appendChild(fillButton);
    </script>
@endsection
