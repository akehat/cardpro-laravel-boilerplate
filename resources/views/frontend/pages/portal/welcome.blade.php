<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #sidebar {
            background-color: #062451;
            color: white;
            padding: 0px;
            padding-left: 15px;
            padding-top: 15px;
            width: 200px;
            height: calc(100vh - 15px);
            overflow-y: hidden;
        }

        #sidebar h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        #sidebar ul {
    list-style: none;
    padding: 0;
    /* padding-left: 15px; */
    margin: 0;
    height: 90vh;
    overflow-y: auto; /* Use auto instead of scroll to hide scrollbar when not needed */
    scrollbar-width: thin; /* For Firefox */
}

/* For WebKit browsers */
#sidebar ul::-webkit-scrollbar {
    width: 6px; /* Set the width of the scrollbar */
}

#sidebar ul::-webkit-scrollbar-track {
    background: #f1f1f1; /* Set the background color of the scrollbar track */
}

#sidebar ul::-webkit-scrollbar-thumb {
    background: #888; /* Set the color of the scrollbar thumb */
}

#sidebar ul::-webkit-scrollbar-thumb:hover {
    background: #555; /* Set the color of the scrollbar thumb on hover */
}

        #sidebar li {
            margin-bottom: 10px;
        }

        #sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        #sidebar a i {
            margin-right: 10px;
        }

        #content {
            flex: 1;
            height: calc(100vh - 20px);
            padding: 10px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="{{ url('portal/testSignup') }}"><i class="fas fa-user-plus"></i>Test Signup</a></li>
            {{-- @if(Auth::user()->hasID) --}}
            {{-- <li><a href="{{ url('portal/testFee') }}">Test Fee Form</a></li> --}}
            <li><a href="{{ url('portal/testPayment') }}"><i class="fas fa-money-bill-wave"></i> Test Payment</a></li>
            <li><a href="{{ url('portal/testHold') }}"><i class="fas fa-hand-holding-usd"></i>Test Hold</a></li>
            <li><a href="{{ url('portal/testCheckout') }}"><i class="fas fa-shopping-cart"></i>Test Checkout</a></li>
            <li><a href="{{ url('portal/testPaylink') }}"><i class="fas fa-shopping-cart"></i>Test Paylink</a></li>
            @if (auth()->user()->isAdmin())
                <li><a href="{{ url('portal/testFee') }}"><i class="fas fa-shopping-cart"></i>Test Fee Profile</a></li>
            @endif
            <li><a href="{{ url('portal/keys') }}"><i class="fas fa-key"></i> Keys</a></li>
<li><a href="{{ url('portal/merchants') }}"><i class="fas fa-store-alt"></i> Test Merchants</a></li>
<li><a href="{{ url('portal/identities') }}"><i class="fas fa-id-card"></i> Test Identities</a></li>
<li><a href="{{ url('portal/payments') }}"><i class="fas fa-money-check"></i> Test Payments</a></li>
<li><a href="{{ url('portal/settlements') }}"><i class="fas fa-hand-holding-usd"></i> Test Settlements</a></li>
<li><a href="{{ url('portal/fee_profiles') }}"><i class="fas fa-file-invoice-dollar"></i> Test Fee Profiles</a></li>
<li><a href="{{ url('portal/payment_instraments') }}"><i class="fas fa-credit-card"></i> Test Payment Instruments</a></li>
<li><a href="{{ url('portal/checkouts') }}"><i class="fas fa-shopping-cart"></i> Test Checkouts</a></li>
<li><a href="{{ url('portal/paymentLinks') }}"><i class="fas fa-link"></i> Test Payment Link</a></li>
<li><a href="{{ url('portal/holds') }}"><i class="fas fa-hand-holding"></i> Test Holds</a></li>
<li><a href="{{ url('portal/verifications') }}"><i class="fas fa-check-circle"></i> Test Verifications</a></li>
<li><a href="{{ url('portal/balanceTransfers') }}"><i class="fas fa-exchange-alt"></i> Test Balance Transfers</a></li>
<li><a href="{{ url('portal/compliances') }}"><i class="fas fa-file-signature"></i> Test PCI Forms</a></li>
<li><a href="{{ url('portal/disputes') }}"><i class="fas fa-exclamation-triangle"></i> Test Disputes</a></li>
{{-- <li><a href="{{ url('portal/subscriptionSchedules') }}"><i class="fas fa-calendar-alt"></i> Test Subscription Schedules</a></li>
<li><a href="{{ url('portal/subscriptionEnrollments') }}"><i class="fas fa-user-plus"></i> Test Subscription Enrollment</a></li>  --}}
<li><a href="{{ url('portal/liveSignup') }}"><i class="fas fa-user-plus"></i> Live Signup</a></li>
<li><a href="{{ url('portal/livePayment') }}"><i class="fas fa-money-bill-wave"></i> Live Payment</a></li>
<li><a href="{{ url('portal/liveHold') }}"><i class="fas fa-hand-holding-usd"></i> Live Hold</a></li>
<li><a href="{{ url('portal/liveCheckout') }}"><i class="fas fa-shopping-cart"></i> Live Checkout</a></li>
<li><a href="{{ url('portal/live/merchants') }}"><i class="fas fa-store-alt"></i> Live Merchants</a></li>
<li><a href="{{ url('portal/live/identities') }}"><i class="fas fa-id-card"></i> Live Identities</a></li>
<li><a href="{{ url('portal/live/apiusers') }}"><i class="fas fa-user"></i> Live API Users</a></li>
<li><a href="{{ url('portal/live/payments') }}"><i class="fas fa-money-check"></i> Live Payments</a></li>
<li><a href="{{ url('portal/live/settlements') }}"><i class="fas fa-hand-holding-usd"></i> Live Settlements</a></li>
<li><a href="{{ url('portal/live/fee_profiles') }}"><i class="fas fa-file-invoice-dollar"></i> Live Fee Profiles</a></li>
<li><a href="{{ url('portal/live/payment_instraments') }}"><i class="fas fa-credit-card"></i> Live Payment Instruments</a></li>
<li><a href="{{ url('portal/live/checkouts') }}"><i class="fas fa-shopping-cart"></i> Live Checkouts</a></li>
<li><a href="{{ url('portal/live/paymentLinks') }}"><i class="fas fa-link"></i> Live Payment Link</a></li>
<li><a href="{{ url('portal/live/holds') }}"><i class="fas fa-hand-holding"></i> Live Holds</a></li>
<li><a href="{{ url('portal/live/verifications') }}"><i class="fas fa-check-circle"></i> Live Verifications</a></li>
<li><a href="{{ url('portal/live/balanceTransfers') }}"><i class="fas fa-exchange-alt"></i> Live Balance Transfers</a></li>
<li><a href="{{ url('portal/live/compliances') }}"><i class="fas fa-file-signature"></i> Live PCI Forms</a></li>
<li><a href="{{ url('portal/live/disputes') }}"><i class="fas fa-exclamation-triangle"></i> Live Disputes</a></li>
{{-- <li><a href="{{ url('portal/live/subscriptionSchedules') }}"><i class="fas fa-calendar-alt"></i> Live Subscription Schedules</a></li>
<li><a href="{{ url('portal/live/subscriptionEnrollments') }}"><i class="fas fa-user-plus"></i> Live Subscription Enrollment</a></li> --}}
<li><a href="{{ route('frontend.auth.logout') }}"><i class="fas fa-user-plus"></i> Logout</a></li>

            {{-- @endif --}}

            <!-- Add more routes as needed -->
        </ul>
    </div>
    <div id="content">
    @if(isset($title))
    <h2>{{$title}}</h2>
    @endif
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
