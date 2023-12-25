<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchantSignUpController extends Controller
{
    public function get(){
        return view('frontend.merchantSignUp');
    }
    public function signup(Request $request){
        dd($request);
        return view('frontend.merchantSignUp');
    }
}

