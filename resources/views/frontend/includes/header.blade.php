

   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        #logo {
            font-size: 24px;
            font-weight: bold;
            color: #3498db; /* Your brand color */
        }

        #navContainer {
            margin-top: 10px;
        }

        #navList {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end;
        }

        .navLink {
            text-decoration: none;
            color: #333; /* Your preferred text color */
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
            display: block;
        }

        .navLink:hover {
            color: #3498db; /* Change the color on hover to match brand color */
        }
        .navLink.active {
            color: #3498db; /* Change the color on hover to match brand color */
        }
    </style>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a href="{{ route('frontend.index') }}" id="logo" class="navbar-brand">Card Wiz Pro</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto" id="navList">
                    <li><a href="{{ route('frontend.index') }}" class="{{ Route::is('frontend.index') ? 'active' : '' }} navLink">Home</a></li>
                    <li><a href="{{ route('frontend.api.endpoint') }}" class="{{ Route::is('frontend.api.endpoint') ? 'active' : '' }} navLink">API</a></li>
                    <li><a href="{{ route('frontend.dashboard') }}" class="{{ Route::is('frontend.dashboard') ? 'active' : '' }} navLink">Dashboard</a></li>
                    <li><a href="{{ route('frontend.pricing') }}" class="{{ Route::is('frontend.pricing') ? 'active' : '' }} navLink">Request A Demo</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="{{ Route::is('frontend.contact') ? 'active' : '' }} navLink">Contact</a></li>
                    @if(Auth::user()==null)
                    <li><a href="{{ route('frontend.signup') }}" class="{{ Route::is('frontend.signup') ? 'active' : '' }} navLink">Sign Up</a></li>
                    <li><a href="{{ route('frontend.signin') }}" class="{{ Route::is('frontend.signin') ? 'active' : '' }} navLink">Sign In</a></li>
                    @else
                    <li><a href="{{ route('frontend.auth.logout')}}" class="navLink">Log out</a></li>
                    @endif
                </ul>
            </div><!--navbar-collapse-->
        </div><!--container-->
    </nav>

    <!-- Bootstrap JS (Assuming Bootstrap is used) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}

                </ul>
            </div><!--navbar-collapse-->
        </div><!--container-->
    </nav>

