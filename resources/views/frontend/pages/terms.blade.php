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

        .left-section,
        .right-section {
            flex: 1;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-section {
            background-color: #3498db; /* Your brand color */
            color: #fff;
            text-align: center;
        }

        @media only screen and (max-width: 768px) {
            .left-section {
                flex: 0.5;
            }
        }

        /* Phone styles */
        @media only screen and (max-width: 480px) {
            .left-section {
                display: none;
            }
        }

        .left-section h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .right-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .right-section h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333; /* Heading color */
        }

        .right-section p {
            margin-bottom: 20px;
        }

        .right-section .terms-card {
            max-width: 800px;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .right-section .terms-card h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333; /* Heading color */
        }

        .right-section .terms-card p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    @include('frontend.includes.header')

    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')
    @include('includes.partials.messages')

    <div class="index-container">
        <!-- Left Section with Welcome Message -->

<div class="left-section d-flex flex-column">
    <h5>Explore Our Terms & Conditions</h5>
    <p>Thank you for choosing our platform! Before you get started, please take a moment to familiarize yourself with our Terms & Conditions. By using our services, you agree to comply with these terms, ensuring a positive experience for everyone.</p>
</div>
        <!-- Right Section with terms Policy -->
        <div class="right-section">
            <div class="terms-card">
                <h2>Terms Of Service</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in augue eu risus suscipit congue. Sed eu orci ac elit malesuada vestibulum vel non lectus. Proin facilisis nulla in cursus mattis. Quisque ut ullamcorper velit. Duis id augue semper, vestibulum risus non, dapibus nisi. Integer auctor, ex eu feugiat varius, odio magna efficitur velit, in convallis tellus ligula vel sapien. Sed vel bibendum tellus. Vestibulum euismod nulla quis dui viverra fringilla. Etiam euismod cursus quam, et fermentum justo feugiat vel. Curabitur et congue purus.</p>

                <p>Phasellus fringilla metus eu mi tristique, id gravida odio iaculis. Nullam eget lacus nec lectus blandit tempus. Suspendisse nec nunc nec elit feugiat suscipit. Curabitur vitae orci eu mauris blandit iaculis. Nullam bibendum dapibus eleifend. Fusce non dapibus justo. Praesent tincidunt, sapien ut bibendum hendrerit, felis nisi tristique mi, non venenatis arcu risus et dolor. Ut hendrerit velit quam, a lacinia nisl vehicula et.</p>
                <img src="{{ asset('img/logo.png') }}" alt="Card Wiz Pro" height="100">

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
