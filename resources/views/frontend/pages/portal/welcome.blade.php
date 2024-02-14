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
            <li><a href="{{ url('portal/merchants') }}">Test Merchants</a></li>
            <li><a href="{{ url('portal/identities') }}">Test Identities</a></li>
            <li><a href="{{ url('portal/payments') }}">Test Payments</a></li>
            <li><a href="{{ url('portal/settlements') }}">Test Settlements</a></li>
            <li><a href="{{ url('portal/fee_profiles') }}">Test Fee Profiles</a></li>
            <li><a href="{{ url('portal/payment_instraments') }}">Test Payment Instruments</a></li>
            <li><a href="{{ url('portal/checkouts') }}">Test Checkouts</a></li>
            <li><a href="{{ url('portal/paymentLinks') }}">Test Payment Link</a></li>
            <li><a href="{{ url('portal/holds') }}">Test Holds</a></li>
            <li><a href="{{ url('portal/verifications') }}">Test Verifications</a></li>
            <li><a href="{{ url('portal/balanceTransfers') }}">Test Balance Transfers</a></li>
            <li><a href="{{ url('portal/compliances') }}">Test PCI Forms</a></li>
            <li><a href="{{ url('portal/disputes') }}">Test Disputes</a></li>
            <li><a href="{{ url('portal/subscriptionSchedules') }}">Test Subscription Schedules</a></li>
            <li><a href="{{ url('portal/subscriptionEnrollments') }}">Test Subscription Enrollment</a></li>
            <li><a href="{{ url('portal/liveSignup') }}">Live Signup</a></li>
            <li><a href="{{ url('portal/livePayment') }}">Live Payment</a></li>
            <li><a href="{{ url('portal/liveHold') }}">Live Hold</a></li>
            <li><a href="{{ url('portal/liveCheckout') }}">Live Checkout</a></li>
            <li><a href="{{ url('portal/live/merchants') }}">Live Merchants</a></li>
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
