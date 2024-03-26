<style>
        body {
            margin: 0;
            padding: 0;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0;
        }

        footer img {
            max-width: 100px;
        }

        footer p {
            font-size: 14px;
            margin-top: 15px;
        }

        footer h5 {
            color: #ffd700;
        }

        footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        footer ul li {
            margin-bottom: 10px;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffd700!important;
        }
        footer li a.active{
            color: #ffd700!important;
        }
        /* Add more styles for additional content or social media links */
    </style>
<footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('img/logo-white.png') }}" alt="Card Wiz Pro" style="max-width: 100px;">
                    <p class="mt-3">Your trusted platform for seamless and secure payments.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.privacy') }}" class="{{ Route::is('frontend.privacy') ? 'active' : '' }} text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('frontend.pages.terms') }}" class="{{ Route::is('frontend.pages.terms') ? 'active' : '' }} text-white">Terms of Service</a></li>
                        <li><a href="{{ route('frontend.contact') }}" class="{{ Route::is('frontend.contact') ? 'active' : '' }} text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <!-- Additional content or social media links can go here -->
                </div>
            </div>
        </div>
    </footer>
