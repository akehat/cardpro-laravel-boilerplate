<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
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
        }

        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
        }
        #navList a{
            color: blue!important;
            text-decoration: none;
        }
        #navList {
            position: absolute;
            top: 100px; /* Adjust as needed based on your layout */
            left: 0;
        }
        #navList a:visited{
            color: blue!important;
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
        "header": "Endpoint either live or sandbox",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'email' for the customer.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/cardwiz/customer -d '{\"apikey\":\"apikey\",\"email\":\"email@example.com\"}'",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Get Customer",
        "info": "Get a customer by id. GET Route",
        "parameters": " 'id' for the customer either the number or the long one.",
        "header": "Endpoint either live or sandbox. 'apikey' either user or merchant.",
        "query": "'id' for the customer",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/cardwiz/customers/2\"",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Get Customers",
        "info": "Get a customers by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint either live or sandbox. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/cardwiz/customers\"",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        },
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Search Customers",
        "info": "Search for a customers by 20. GET Route",
        "parameters": "'apikey' either user or merchant.",
        "header": "Endpoint either live or sandbox",
        "query": "page the page of the query like page=2 by 20,'search' for in the customer.",
        "data": "'apikey' either user or merchant. ",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
   {{url('')}}/customers/search?search=jhon",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Create Charge",
        "info": "create a charge for a customer. POST Route",
        "parameters": "'apikey' either user or merchant.\n'cardID' of the card. \n'amount' the amount of the charge. \n'currency' of the charge. \nIf a user key is used the 'merchant' must be provided.",
        "header": "Endpoint either live or sandbox",
        "query": "N/A",
        "data": "'apikey' either user or merchant. 'cardID' for in the card. 'currency' of the charge.",
        "exampleRequest": "curl -X POST -H \"Content-Type: application/json\"  {{url('')}}/cardwiz/charges -d '{\"apikey\":\"apikey\",\"cardID\":2,\"amount\":200,\"currency\":'USD'}'",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Get Charge",
        "info": "Get a charge by id. GET Route",
        "parameters": " 'id' for the charge either the number or the long one.",
        "header": "Endpoint either live or sandbox. 'apikey' either user or merchant.",
        "query": "'id' for the charge",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/cardwiz/charges/2\"",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Get Charges",
        "info": "Get a charge by 20.",
        "parameters": "'apikey' either user or merchant. GET Route",
        "header": "Endpoint either live or sandbox. 'apikey' either user or merchant.",
        "query": "page the page of the query like page=2 by 20",
        "data": "N/A",
        "exampleRequest": "curl -X GET \
  -H \"apikey: your_api_key_here\" \
  \"{{url('')}}/cardwiz/charges\"",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        },
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
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

                section.innerHTML = `
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

                    <h3>Example Request</h3>
                    <code>${route.exampleRequest}</code>

                    <h3>Example Response</h3>
                    <pre>${JSON.stringify(route.exampleResponse, null, 2)}</pre>
                `;

                mainContent.appendChild(section);
            });
        }

        loadData(data);
    </script>
</body>
</html>
