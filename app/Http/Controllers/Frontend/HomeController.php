<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\ApiUser;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }
    public function apiEndpoint()
    {
        return view('frontend.pages.api.endpoint');
    }

    /**
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $user_id=Auth::id();
        $found=ApiUser::where('user_id',$user_id)->first();
        if($found==null){
            $apiuser=ApiUser::create(['userID'=>$user_id,
            'user_id'=>$user_id,
            'payments_count'=>0,
            'total'=>0]);
            $apiuser->save();
            $apiuser->refresh();
            $user=User::where('id',$user_id)->first();
            $user->update([
                'api_key'=>"USER_KEY_".$user_id.$this->generateApiKey(),
                'api_users_id'=>$apiuser->id
            ]);
            $user->save();
            $user->refresh();

        }
        return view('frontend.pages.portal.welcome');
    }
    function generateApiKey($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apiKey = '';

        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $apiKey;
    }
      /**
     * @return Application|Factory|View
     */
    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    /**
     * @return Application|Factory|View
     */
    public function pricing()
    {
        return view('frontend.pages.pricing');
    }
     /**
     * @return Application|Factory|View
     */
    public function signin()
    {
        return view('frontend.auth.loginCardWiz');
    }
 /**
     * @return Application|Factory|View
     */
    public function signup()
    {
        return view('frontend.auth.registerCardWiz');
    }
    /**
     * @return Application|Factory|View
     */
    public function contact()
    {
        return view('frontend.pages.contact');
    }
    public function contactSubmit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Call the contactSubmit function from the Email model
        $response = Email::contactSubmit($request);
        // Return the response message
        return redirect()->back()->with('status', $response);
    }
    public function demoRequest(Request $request){
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Call the contactSubmit function from the Email model
        $response = Email::demoRequestSubmit($request);
        // Return the response message
        return redirect()->back()->with('status', $response);
    }
}
