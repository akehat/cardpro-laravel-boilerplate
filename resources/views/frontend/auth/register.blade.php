<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ appName() }}</title>
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

            .index-container {
                display: flex;
            }

            .left-section {
                flex: 1;
                background-color: #3498db; /* Your brand color */
                color: #fff;
                padding: 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .left-section h1 {
                font-size: 36px;
                margin-bottom: 20px;
            }

            .right-section {
                flex: 1;
                padding: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .signup-card {
                max-width: 800px;
                background-color: #fff;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .signup-card img {
                max-width: 100%;
                margin-bottom: 20px;
            }

            .signup-card h2 {
                font-size: 36px;
                margin-bottom: 20px;
                color: #333; /* Heading color */
            }

            .signup-card form {
                margin-bottom: 20px;
            }

            .form-group {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .form-group label {
                width: 100%;
                text-align: left;
                margin-bottom: 5px;
                color: #666; /* Label color */
            }

            .form-group input[type=text],.form-group input[type=password], .form-group input[type=email] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc; /* Input border color */
                border-radius: 4px;
                box-sizing: border-box;
                font-size: 14px; /* Input font size */
            }

            .form-group .form-check {
                width: 100%;
                margin-top: 10px;
            }

            .signup-card button {
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

            .signup-card button:hover {
                background-color: #007bb5; /* Button background color on hover */
            }

            .signup-card a {
                color: #3498db; /* Link color */
                text-decoration: none;
                margin-left: 10px;
                font-size: 14px; /* Link font size */
            }

            .signup-card a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        @include('frontend.includes.header')

        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        <div class="index-container">
            <!-- Left Section with Praise Words -->
            <div class="left-section">
                <h1>Sign Up to Card Wiz Pro</h1>
                <p>Your trusted platform for seamless and secure payments.</p>
                <!-- Add more praising words or testimonials here -->
            </div>

            <!-- Right Section with Login Card -->
            <div class="right-section">
                <div class="signup-card">
                    <img src="{{ asset('img/logo.png') }}" alt="Card Wiz Pro" height="100">
                    <h2>Register</h2>
                    <form method="post" action="{{ route('frontend.auth.register') }}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="d-flex flex-wrap">
                        <div class="form-group col-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="" placeholder="Name" maxlength="100" required="required" autofocus="autofocus" autocomplete="name">
                        </div>

                        <div class="form-group col-6">
                            <label for="email">E-mail Address</label>
                            <input type="email" name="email" id="email" placeholder="E-mail Address" value="" maxlength="255" required="required" autocomplete="email">
                        </div>

                        <div class="form-group col-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" maxlength="100" required="required" autocomplete="new-password">
                        </div>

                        <div class="form-group col-6">
                            <label for="password_confirmation">Password Confirmation</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation" maxlength="100" required="required" autocomplete="new-password">
                        </div>

                        <div class="form-group col-12">
                            <div class="form-check">
                                <input type="checkbox" name="terms" value="1" id="terms" required="required" class="form-check-input">
                                <label for="terms" class="form-check-label">
                                    I agree to the <a href="{{ route('frontend.pages.terms') }}"  target="_blank">Terms &amp; Conditions</a>
                                </label>
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
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
