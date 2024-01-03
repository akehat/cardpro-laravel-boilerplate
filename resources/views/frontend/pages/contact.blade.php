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

        .contact-card {
            max-width: 800px;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-card h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333; /* Heading color */
        }

        .contact-card form {
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

        .form-group input[type=text], .form-group input[type=email], .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc; /* Input border color */
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px; /* Input font size */
        }

        .form-group textarea {
            height: 150px; /* Adjust the height of the textarea */
        }

        .contact-card button {
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

        .contact-card button:hover {
            background-color: #007bb5; /* Button background color on hover */
        }

        .contact-card a {
            color: #3498db; /* Link color */
            text-decoration: none;
            margin-left: 10px;
            font-size: 14px; /* Link font size */
        }

        .contact-card a:hover {
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
            <h1>Contact Us</h1>
            <p>Get in touch with us. We'd love to hear from you!</p>
            <!-- Add more information or details here -->
        </div>

        <!-- Right Section with Contact Form -->
        <div class="right-section">
            <div class="contact-card">
            <img src="{{ asset('img/logo.png') }}" alt="Card Wiz Pro" height="100">
                <h2>Contact Form</h2>
                <form method="post" action="{{ route('frontend.contact.submit') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="" placeholder="Your Name" maxlength="100" required="required" autofocus="autofocus" autocomplete="name">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail Address</label>
                        <input type="email" name="email" id="email" placeholder="Your E-mail Address" value="" maxlength="255" required="required" autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" placeholder="Your Message" required="required"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
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
