<?php

namespace App\Http\Controllers\Frontend;

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
        return view('frontend.pages.dashboard');
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
    public function contact()
    {
        return view('frontend.pages.contact');
    }
}
