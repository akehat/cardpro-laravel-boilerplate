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
            overflow-y:scroll;
                }
        #sidebar a {
            color: white;
            font-size: 17px;
            font-weight: bold;
            padding: 3px;
        }
        #sidebar ul {
            padding: 0px
        }
        #sidebar li {
            margin-top: 5px
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
            {{-- @if(Auth::user()->hasID) --}}
            {{-- <li><a href="{{ url('portal/testFee') }}">Test Fee Form</a></li> --}}
            <li><a href="{{ url('portal/testPayment') }}">Test Payment</a></li>
            <li><a href="{{ url('portal/testHold') }}">Test Hold</a></li>
            <li><a href="{{ url('portal/testCheckout') }}">Test Checkout</a></li>
            <li><a href="{{ url('portal/keys') }}">Keys</a></li>
            <li><a href="{{ url('portal/merchants') }}">Merchants</a></li>
            <li><a href="{{ url('portal/identities') }}">Identities</a></li>
            <li><a href="{{ url('portal/apiusers') }}">API Users</a></li>
            <li><a href="{{ url('portal/payments') }}">Payments</a></li>
            <li><a href="{{ url('portal/settlements') }}">Settlements</a></li>
            <li><a href="{{ url('portal/fee_profiles') }}">Fee Profiles</a></li>
            <li><a href="{{ url('portal/payment_instraments') }}">Payment Instruments</a></li>
            <li><a href="{{ url('portal/checkouts') }}">Checkouts</a></li>
            <li><a href="{{ url('portal/paymentLinks') }}">Payment Link</a></li>
            <li><a href="{{ url('portal/holds') }}">Holds</a></li>
            <li><a href="{{ url('portal/verifications') }}">Verifications</a></li>
            <li><a href="{{ url('portal/balanceTransfers') }}">Balance Transfers</a></li>
            <li><a href="{{ url('portal/compliances') }}">PCI Forms</a></li>
            <li><a href="{{ url('portal/disputes') }}">Disputes</a></li>
            <li><a href="{{ url('portal/subscriptionSchedules') }}">Subscription Schedules</a></li>
            <li><a href="{{ url('portal/subscriptionEnrollments') }}">Subscription Enrollment</a></li>
            <li><a href="{{ url('portal/live/merchants') }}"> Live Merchants</a></li>
            <li><a href="{{ url('portal/live/identities') }}"> Live Identities</a></li>
            <li><a href="{{ url('portal/live/apiusers') }}"> Live API Users</a></li>
            <li><a href="{{ url('portal/live/payments') }}"> Live Payments</a></li>
            <li><a href="{{ url('portal/live/settlements') }}"> Live Settlements</a></li>
            <li><a href="{{ url('portal/live/fee_profiles') }}"> Live Fee Profiles</a></li>
            <li><a href="{{ url('portal/live/payment_instraments') }}"> Live Payment Instruments</a></li>
            <li><a href="{{ url('portal/live/checkouts') }}"> Live Checkouts</a></li>
            <li><a href="{{ url('portal/live/paymentLinks') }}"> Live Payment Link</a></li>
            <li><a href="{{ url('portal/live/holds') }}">Live Holds</a></li>
            <li><a href="{{ url('portal/live/verifications') }}"> Live Verifications</a></li>
            <li><a href="{{ url('portal/live/balanceTransfers') }}"> Live Balance Transfers</a></li>
            <li><a href="{{ url('portal/live/compliances') }}"> Live PCI Forms</a></li>
            <li><a href="{{ url('portal/live/disputes') }}"> Live Disputes</a></li>
            <li><a href="{{ url('portal/live/subscriptionSchedules') }}"> Live Subscription Schedules</a></li>
            <li><a href="{{ url('portal/live/subscriptionEnrollments') }}"> Live Subscription Enrollment</a></li>
            {{-- @endif --}}

            <!-- Add more routes as needed -->
        </ul>
    </div>
    <div id="content">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    @yield("content")
    </div>
</body>
</html>
