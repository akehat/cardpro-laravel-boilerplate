<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ appName() }} | Pricing</title>
    <link rel="icon"  href="{{ asset('img/logo.png') }}">
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">

    @stack('after-styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif; /* Replace with your preferred font */
        }

        .pricing-container {
            display: flex;
            justify-content: space-around;
            padding: 40px;
            height: calc(100vh - 200px);
        }

        .pricing-feature {
            flex: 1;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            text-align: center;

        }

        .pricing-feature h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .pricing-form {
            max-width:400px;
            margin: auto;
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            text-align: center;
        }

        .pricing-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group label {
            width: 100%;
            text-align: left;
            margin-bottom: 5px;
            color: #666; /* Label color */
        }

        .form-group input[type=email] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc; /* Input border color */
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px; /* Input font size */
        }

        .pricing-form button {
            background-color: #3498db; /* Button background color */
            color: #fff; /* Button text color */
            padding: 5px 50px; /* Increased padding */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            letter-spacing: 2px;
            font-size: 16px; /* Button font size */
            transition: background-color 0.3s;
        }

        .pricing-form button:hover {
            background-color: #007bb5; /* Button background color on hover */
        }
    </style>
</head>
<body>
    @include('frontend.includes.header')

    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')
    @include('includes.partials.messages')


    <div class="pricing-container flex-wrap">
        <!-- Pricing Features -->
        <div class="pricing-feature">
            <h2>Feature 1</h2>
            <p>Description of Feature 1.</p>
        </div>

        <div class="pricing-feature">
            <h2>Feature 2</h2>
            <p>Description of Feature 2.</p>
        </div>

        <div class="pricing-feature">
            <h2>Feature 3</h2>
            <p>Description of Feature 3.</p>
        </div>

        <!-- Pricing Form -->
        <div class="col-12">
        <div class="pricing-form mx-auto">
            <img src="{{ asset('img/logo.png') }}" alt="Card Wiz Pro" height="100">

            <h2>Interested in a Demo?</h2>
            <form method="post" action="{{ route('frontend.demo.request') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Enter your email:</label>
                    <input type="email" name="email" id="email" placeholder="Your Email" required="required" autocomplete="email">
                </div>

                <button type="submit">Request Demo</button>
            </form>
        </div>
        </div>
    </div>

    @include('frontend.includes.footer')

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
