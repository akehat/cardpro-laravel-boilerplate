<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #sidebar {
            background-color: #333;
            color: white;
            padding: 20px;
            width: 150px;
            height:95vh;
                }
        #sidebar a {
            color: white;
        }

        #content {
            flex: 1;
            height:100vh;
            max-height:calc(100vh - 200px);;
            padding: 100px;

            width: calc(100vw - 250px);
            overflow-y: auto;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="{{ url('portal/testSignup') }}">Test Signup</a></li>
            <li><a href="{{ url('portal/testPayment') }}">Test Payment</a></li>
            <li><a href="{{ url('portal/merchants') }}">Merchants</a></li>
            <li><a href="{{ url('portal/identities') }}">Identities</a></li>
            <li><a href="{{ url('portal/apiusers') }}">API Users</a></li>
            <li><a href="{{ url('portal/payments') }}">Payments</a></li>
            <li><a href="{{ url('portal/settlements') }}">Settlements</a></li>
            <li><a href="{{ url('portal/fee_profiles') }}">Fee Profiles</a></li>
            <li><a href="{{ url('portal/payment_instraments') }}">Payment Instruments</a></li>

            <!-- Add more routes as needed -->
        </ul>
    </div>
    <div id="content">
    @yield("content")
    </div>
</body>
</html>
