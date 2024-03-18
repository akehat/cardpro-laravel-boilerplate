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
    <h1>Fee Profile Information Form</h1>

    <form id="jsonForm" action="{{url('feeLive')}}" method="POST">{{ csrf_field() }}</form>

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
            if( input.type != 'checkbox'){
            input.required=true;
            }
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
    "ach_basis_points": 300,
    "ach_fixed_fee": 30,
    "basis_points": 200,
    "card_cross_border_basis_points": 300,
    "card_cross_border_fixed_fee": 400,
    "charge_interchange": false,
    "fixed_fee": 100
  }`;
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
        // fillButton.onclick=function(){
        //     var matches = document.querySelectorAll("input[type=text],input[type=number]");
        //     matches.forEach((match) => {
        //        match.value=match.placeholder;
        //     });
        //     var matches = document.querySelectorAll("input[type=checkbox]");
        //     matches.forEach((match) => {
        //         if(match.placeholder=='true'){
        //             match.checked=true;
        //         }
        //     });
        // };
        // form.appendChild(fillButton);
    </script>
@endsection
