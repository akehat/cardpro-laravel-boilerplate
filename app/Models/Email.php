<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function contactSubmit($request)
    {
        try {
            // Create a new email entry
            $email = new Email();
            $email->type = 'Contact Form';
            $email->from_name = $request->input('name');
            $email->from_email = $request->input('email');
            $email->to_email = 'your_email@example.com'; // Specify the recipient email address
            $email->content = $request->input('message');
            $email->title = 'Contact Form Submission';
            $email->save();

            // Return success message
            return "Your message has been successfully submitted. We will get back to you shortly.";
        } catch (\Exception $e) {
            // Return error message if an exception occurs
            return "An error occurred while submitting your message. Please try again later.";
        }
    }
}
