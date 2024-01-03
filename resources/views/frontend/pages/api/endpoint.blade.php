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
        #navList a:visited{
            color: blue!important;
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ url('') }}" style="margin-left: 10px;position: absolute; left: 10px; color:white; top:30px; font-size:30px; text-decoration:none!important;">🔙 </a>
        <h1> API Documentation</h1>
    </header>

    <div class="container">
        <nav>
            <ul id="navList"></ul>
        </nav>

        <main id="mainContent">
        </main>
    </div>

    <script>
        var data = `[
    {
        "routeName": "Test Route 1",
        "info": "Information about Route 1 goes here...",
        "parameters": "Explain any parameters here...",
        "header": "Explain any header information here...",
        "query": "Explain any query parameters here...",
        "data": "Explain the expected data format here...",
        "exampleRequest": "curl -X GET -H \\"Content-Type: application/json\\" -H \\"Authorization: Bearer YOUR_TOKEN\\" https://api.example.com/route1?param1=value1&param2=value2",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    },
    {
        "routeName": "Test Route 2",
        "info": "Information about Route 1 goes here...",
        "parameters": "Explain any parameters here...",
        "header": "Explain any header information here...",
        "query": "Explain any query parameters here...",
        "data": "Explain the expected data format here...",
        "exampleRequest": "curl -X GET -H \\"Content-Type: application/json\\" -H \\"Authorization: Bearer YOUR_TOKEN\\" https://api.example.com/route1?param1=value1&param2=value2",
        "exampleResponse": {
            "status": "success",
            "data": {
                "key": "value"
            }
        }
    }
]`;

        data = JSON.parse(data);

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
