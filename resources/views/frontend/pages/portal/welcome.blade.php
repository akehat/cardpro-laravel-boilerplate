<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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
            font-size: 0.9rem;
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
    /* height: 90vh; */
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
                button.togglebtn {
            background-color: #4e79a7; /* Darker blue */
            border: none;
            color: white; /* White text for better contrast */
            padding: 10px 20px;
            text-align: left;
            cursor: pointer;
            outline: none;
            width: 100%;
            margin-bottom: 2px;
        }

        button.togglebtn:hover {
            background-color: #6389b8; /* Slightly lighter blue on hover */
        }

        ul li a.active {
            color: #52ee50!important; /* A shade of green for active links */
        }


    </style>
</head>
<body>
    <div id="sidebar">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="{{ url('portal/keys') }}" class="{{ Route::is('frontend.portal.keys') ? 'active' : '' }}"><i class="fas fa-key"></i> Keys</a></li>
            <button class="togglebtn" id="toggleTestRoutes" onclick="toggleRoutes('test')">TEST <span id="testIcon">&#9660;</span></button>
            <ul id="testRoutes" style="display:none;">
                <button class="togglebtn" id="toggleTestformRoutes" onclick="toggleRoutes('testform')">FORMS <span id="testformIcon">&#9660;</span></button>
                <ul id="testformRoutes" style="display:none;">
                    <li><a href="{{ url('portal/testSignup') }}" class="{{ Route::is('frontend.portal.testSignup') ? 'active' : '' }}"><i class="fas fa-user-plus"></i>Test Signup</a></li>
                    {{-- @if(Auth::user()->hasID) --}}
                    {{-- <li><a href="{{ url('portal/testFee') }}" class="{{ Route::is('frontend.portal.testFee') ? 'active' : '' }}">Test Fee Form</a></li> --}}
                    <li><a href="{{ url('portal/testPayment') }}" class="{{ Route::is('frontend.portal.testPayment') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Test Payment</a></li>
                    <li><a href="{{ url('portal/testHold') }}" class="{{ Route::is('frontend.portal.testHold') ? 'active' : '' }}"><i class="fas fa-hand-holding-usd"></i>Test Hold</a></li>
                    <li><a href="{{ url('portal/testCheckout') }}" class="{{ Route::is('frontend.portal.testCheckout') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i>Test Checkout</a></li>
                    <li><a href="{{ url('portal/testPaylink') }}" class="{{ Route::is('frontend.portal.testPaylink') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i>Test Paylink</a></li>
                    @if (auth()->user()->isAdmin())
                        <li><a href="{{ url('portal/testFee') }}" class="{{ Route::is('frontend.portal.testFee') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i>Test Fee Profile</a></li>
                    @endif
                </ul>
                <button class="togglebtn" id="toggleTesttableRoutes" onclick="toggleRoutes('testtable')">TABLES <span id="testtableIcon">&#9660;</span></button>
                <ul id="testtableRoutes" style="display:none;">
                    <li><a href="{{ url('portal/merchants') }}" class="{{ Route::is('frontend.portal.merchants') ? 'active' : '' }}"><i class="fas fa-store-alt"></i> Test Merchants</a></li>
                    <li><a href="{{ url('portal/identities') }}" class="{{ Route::is('frontend.portal.identities') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Test Identities</a></li>
                    <li><a href="{{ url('portal/payments') }}" class="{{ Route::is('frontend.portal.payments') ? 'active' : '' }}"><i class="fas fa-money-check"></i> Test Payments</a></li>
                    <li><a href="{{ url('portal/settlements') }}" class="{{ Route::is('frontend.portal.settlements') ? 'active' : '' }}"><i class="fas fa-hand-holding-usd"></i> Test Settlements</a></li>
                    <li><a href="{{ url('portal/fee_profiles') }}" class="{{ Route::is('frontend.portal.fee_profiles') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar"></i> Test Fee Profiles</a></li>
                    <li><a href="{{ url('portal/payment_instraments') }}" class="{{ Route::is('frontend.portal.payment_instraments') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Test Payment Instruments</a></li>
                    <li><a href="{{ url('portal/checkouts') }}" class="{{ Route::is('frontend.portal.checkouts') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Test Checkouts</a></li>
                    <li><a href="{{ url('portal/paymentLinks') }}" class="{{ Route::is('frontend.portal.paymentLinks') ? 'active' : '' }}"><i class="fas fa-link"></i> Test Payment Link</a></li>
                    <li><a href="{{ url('portal/holds') }}" class="{{ Route::is('frontend.portal.holds') ? 'active' : '' }}"><i class="fas fa-hand-holding"></i> Test Holds</a></li>
                    <li><a href="{{ url('portal/verifications') }}" class="{{ Route::is('frontend.portal.verifications') ? 'active' : '' }}"><i class="fas fa-check-circle"></i> Test Verifications</a></li>
                    <li><a href="{{ url('portal/balanceTransfers') }}" class="{{ Route::is('frontend.portal.balanceTransfers') ? 'active' : '' }}"><i class="fas fa-exchange-alt"></i> Test Balance Transfers</a></li>
                    <li><a href="{{ url('portal/compliances') }}" class="{{ Route::is('frontend.portal.compliances') ? 'active' : '' }}"><i class="fas fa-file-signature"></i> Test PCI Forms</a></li>
                    <li><a href="{{ url('portal/disputes') }}" class="{{ Route::is('frontend.portal.disputes') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle"></i> Test Disputes</a></li>
                    <li><a href="{{ url('portal/files') }}" class="{{ Route::is('frontend.portal.files') ? 'active' : '' }}"><i class="fas fa-file"></i> Test Files</a></li>
                    <li><a href="{{ url('portal/externalfiles') }}" class="{{ Route::is('frontend.portal.externalfiles') ? 'active' : '' }}"><i class="fas fa-external-link-alt"></i> Test External Files</a></li>
                </ul>
            </ul>
            <button class="togglebtn" id="toggleLiveRoutes" onclick="toggleRoutes('live')">LIVE <span id="liveIcon">&#9660;</span></button>
            <ul id="liveRoutes" style="display:none;">
                <button class="togglebtn" id="toggleLiveformRoutes" onclick="toggleRoutes('liveform')">FORMS <span id="liveformIcon">&#9660;</span></button>
                <ul id="liveformRoutes" style="display:none;">
                    {{-- <li><a href="{{ url('portal/subscriptionSchedules') }}" class="{{ Route::is('frontend.portal.subscriptionSchedules') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Test Subscription Schedules</a></li>
                    <li><a href="{{ url('portal/subscriptionEnrollments') }}" class="{{ Route::is('frontend.portal.subscriptionEnrollments') ? 'active' : '' }}"><i class="fas fa-user-plus"></i> Test Subscription Enrollment</a></li>  --}}
                    <li><a href="{{ url('portal/liveSignup') }}" class="{{ Route::is('frontend.portal.liveSignup') ? 'active' : '' }}"><i class="fas fa-user-plus"></i> Live Signup</a></li>
                    <li><a href="{{ url('portal/livePayment') }}" class="{{ Route::is('frontend.portal.livePayment') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Live Payment</a></li>
                    <li><a href="{{ url('portal/liveHold') }}" class="{{ Route::is('frontend.portal.liveHold') ? 'active' : '' }}"><i class="fas fa-hand-holding-usd"></i> Live Hold</a></li>
                    <li><a href="{{ url('portal/liveCheckout') }}" class="{{ Route::is('frontend.portal.liveCheckout') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Live Checkout</a></li>
                    @if (auth()->user()->isAdmin())
                    <li><a href="{{ url('portal/liveFee') }}" class="{{ Route::is('frontend.portal.liveFee') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Live Fee Form</a></li>
                    @endif
                </ul>
                <button class="togglebtn" id="toggleLivetableRoutes" onclick="toggleRoutes('livetable')">TABLES <span id="livetableIcon">&#9660;</span></button>
                <ul id="livetableRoutes" style="display:none;">
                    <li><a href="{{ url('portal/live/merchants') }}" class="{{ Route::is('frontend.portal.live.merchants') ? 'active' : '' }}"><i class="fas fa-store-alt"></i> Live Merchants</a></li>
                    <li><a href="{{ url('portal/live/identities') }}" class="{{ Route::is('frontend.portal.live.identities') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Live Identities</a></li>
                    <li><a href="{{ url('portal/live/apiusers') }}" class="{{ Route::is('frontend.portal.live.apiusers') ? 'active' : '' }}"><i class="fas fa-user"></i> Live API Users</a></li>
                    <li><a href="{{ url('portal/live/payments') }}" class="{{ Route::is('frontend.portal.live.payments') ? 'active' : '' }}"><i class="fas fa-money-check"></i> Live Payments</a></li>
                    <li><a href="{{ url('portal/live/settlements') }}" class="{{ Route::is('frontend.portal.live.settlements') ? 'active' : '' }}"><i class="fas fa-hand-holding-usd"></i> Live Settlements</a></li>
                    <li><a href="{{ url('portal/live/fee_profiles') }}" class="{{ Route::is('frontend.portal.live.fee_profiles') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar"></i> Live Fee Profiles</a></li>
                    <li><a href="{{ url('portal/live/payment_instraments') }}" class="{{ Route::is('frontend.portal.live.payment_instraments') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Live Payment Instruments</a></li>
                    <li><a href="{{ url('portal/live/checkouts') }}" class="{{ Route::is('frontend.portal.live.checkouts') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Live Checkouts</a></li>
                    <li><a href="{{ url('portal/live/paymentLinks') }}" class="{{ Route::is('frontend.portal.live.paymentLinks') ? 'active' : '' }}"><i class="fas fa-link"></i> Live Payment Link</a></li>
                    <li><a href="{{ url('portal/live/holds') }}" class="{{ Route::is('frontend.portal.live.holds') ? 'active' : '' }}"><i class="fas fa-hand-holding"></i> Live Holds</a></li>
                    <li><a href="{{ url('portal/live/verifications') }}" class="{{ Route::is('frontend.portal.live.verifications') ? 'active' : '' }}"><i class="fas fa-check-circle"></i> Live Verifications</a></li>
                    <li><a href="{{ url('portal/live/balanceTransfers') }}" class="{{ Route::is('frontend.portal.live.balanceTransfers') ? 'active' : '' }}"><i class="fas fa-exchange-alt"></i> Live Balance Transfers</a></li>
                    <li><a href="{{ url('portal/live/compliances') }}" class="{{ Route::is('frontend.portal.live.compliances') ? 'active' : '' }}"><i class="fas fa-file-signature"></i> Live PCI Forms</a></li>
                    <li><a href="{{ url('portal/live/disputes') }}" class="{{ Route::is('frontend.portal.live.disputes') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle"></i> Live Disputes</a></li>
                    <li><a href="{{ url('portal/live/files') }}" class="{{ Route::is('frontend.portal.live.files') ? 'active' : '' }}"><i class="fas fa-file"></i> Live Files</a></li>
                    <li><a href="{{ url('portal/live/externalfiles') }}" class="{{ Route::is('frontend.portal.live.externalfiles') ? 'active' : '' }}"><i class="fas fa-external-link-alt"></i> Live External Files</a></li>
                </ul>
                {{-- <li><a href="{{ url('portal/live/subscriptionSchedules') }}" class="{{ Route::is('frontend.portal.live.subscriptionSchedules') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Live Subscription Schedules</a></li>
                <li><a href="{{ url('portal/live/subscriptionEnrollments') }}" class="{{ Route::is('frontend.portal.live.subscriptionEnrollments') ? 'active' : '' }}"><i class="fas fa-user-plus"></i> Live Subscription Enrollment</a></li> --}}
            </ul>
            {{-- @endif --}}

            <li><a href="{{ route('frontend.auth.logout') }}"><i class="fas fa-user-plus"></i> Logout</a></li>
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
    <script>
   // Function to toggle routes and remember the state
function toggleRoutes(type) {
    var routes = document.getElementById(type + "Routes");
    var icon = document.getElementById(type + "Icon");
    if (routes.style.display === "none") {
        routes.style.display = "block";
        icon.innerHTML = "&#9650;"; // Change to up arrow
        sessionStorage.setItem(type + "RoutesState", "visible");
    } else {
        routes.style.display = "none";
        icon.innerHTML = "&#9660;"; // Change to down arrow
        sessionStorage.setItem(type + "RoutesState", "hidden");
    }
}

// Function to set the initial state of routes based on stored state
function setInitialState() {
    var types = ["live", "test","testform","testtable","liveform","livetable"];
    types.forEach(function(type) {
        var routesState = sessionStorage.getItem(type + "RoutesState");
        if (routesState === "visible") {
            toggleRoutes(type);
        }
    });
}

// Call setInitialState when the page loads
window.onload = function() {
    setInitialState();
};

        </script>
</body>
</html>
