<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\ApiUser;
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
                'api_key'=>"USER_KEY_".$this->generateApiKey(),
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
}
