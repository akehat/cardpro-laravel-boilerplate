<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect('/contact')
                        ->withErrors($validator)
                        ->withInput();
        }
         // Save contact information to the database
        ContactUs::create($request->all());

        // Send the email
        Mail::to(config('mail.admin_email'))->queue(new ContactUs($request->all()));


        // Redirect with a success message
        return redirect('/contact')->with('success', 'Your message has been sent successfully!');
    }
}
?>