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
            flex: 1;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-card {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-card img {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .login-card h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333; /* Heading color */
        }

        .login-card form {
            margin-bottom: 20px;
        }

        .login-card label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #666; /* Label color */
        }

        .login-card input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Input border color */
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-card button {
            background-color: #3498db; /* Button background color */
            color: #fff; /* Button text color */
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-card button:hover {
            background-color: #007bb5; /* Button background color on hover */
        }

        .login-card a {
            color: #3498db; /* Link color */
            text-decoration: none;
            margin-left: 10px;
        }

        .login-card a:hover {
            text-decoration: underline;
        }
        .login-card {
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .login-card img {
        max-width: 100%;
        margin-bottom: 20px;
    }

    .login-card h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333; /* Heading color */
    }

    .login-card form {
        margin-bottom: 20px;
    }

    .login-card label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #666; /* Label color */
        font-size: 14px; /* Label font size */
    }

    .login-card input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px; /* Increased margin */
        border: 1px solid #ccc; /* Input border color */
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px; /* Input font size */
    }

    .login-card button {
        background-color: #3498db; /* Button background color */
        color: #fff; /* Button text color */
        padding: 12px; /* Increased padding */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px; /* Button font size */
        transition: background-color 0.3s;
    }

    .login-card button:hover {
        background-color: #007bb5; /* Button background color on hover */
    }

    .login-card a {
        color: #3498db; /* Link color */
        text-decoration: none;
        margin-left: 10px;
        font-size: 14px; /* Link font size */
    }

    .login-card a:hover {
        text-decoration: underline;
    }
    </style>
    </head>
    <body>
        @include('frontend.includes.header')
        <div style="display: none;">
             @auth
                @if ($logged_in_user->isUser())
                    <a href="{{ route('frontend.user.dashboard') }}">@lang('Dashboard')</a>
                @endif

                <a href="{{ route('frontend.user.account') }}">@lang('Account')</a>
            @else
                <a href="{{ route('frontend.auth.login') }}">@lang('Login')</a>

                @if (config('boilerplate.access.user.registration'))
                    <a href="{{ route('frontend.auth.register') }}">@lang('Register')</a>
                @endif
            @endauth
        </div>
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        @include('includes.partials.announcements')
        @include('includes.partials.messages')

        <div class="index-container">
            <!-- Left Section with Praise Words -->
            <div class="left-section">
                <h1>Welcome to Card Wiz Pro</h1>
                <p>Your trusted platform for seamless and secure payments.</p>
                <!-- Add more praising words or testimonials here -->
            </div>

            <!-- Right Section with Login Card -->
            <div class="right-section">
            <div class="login-card">
            <img src="{{ asset('img/logo.png') }}" alt="Card Wiz Pro" height="100">
            <h2>Login</h2>
            <form method="post" action="{{route('frontend.auth.login')}}" class="form-horizontal">
                {{ csrf_field() }}
                <label for="email">E-mail Address</label>
                <input type="email" name="email" id="email" placeholder="E-mail Address" value="" maxlength="255" required="required" autofocus="autofocus" autocomplete="email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" maxlength="100" required="required" autocomplete="current-password">

                <div class="form-check">
                    <input name="remember" id="remember" type="checkbox" class="form-check-input">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit">Login</button>
            </form>
            <a href="{{route('frontend.auth.password.request')}}">Forgot Your Password?</a>
        </div>
        <div class="text-center"></div>
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
