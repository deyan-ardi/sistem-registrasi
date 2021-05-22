<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Vote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $active = Vote::where('status', '1')->first();
        $setting = Setting::first();
        return view('user.page.index',['sidebar' => 1,'activity' => $active,'setting' => $setting]);
    }

}