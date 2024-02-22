@extends('layouts.app')

@section('content')
    <h2>Contact Us</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <form action="/contact" method="post">
            @csrf

            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstname" placeholder="Your name.." required>

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastname" placeholder="Your last name.." required>
            
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" placeholder="Your phone number.." required>
            
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Your email address.." required>
                        
            <label for="message">Subject</label>
            <textarea id="message" name="message" placeholder="Write your message here.." style="height:200px" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
@endsection