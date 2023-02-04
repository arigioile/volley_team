<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Matcher\Not;
use App\Models\Notice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = [
            'https://www.centrosportivosantamaria.it/wordpress/wp-content/uploads/2020/04/slide-sm-04-1024x478.jpg',
            'https://www.centrosportivosantamaria.it/wordpress/wp-content/uploads/2020/04/slide-sm-03-1024x478.jpg',
            // 'https://www.centrosportivosantamaria.it/wordpress/wp-content/uploads/2020/04/slide-hp-00-1536x716.jpg',
        ];

        $notice = Notice::find(1);

        return view('home', compact('sliders', 'notice'));
    }
}
