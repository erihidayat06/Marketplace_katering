<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $Merchant = Merchant::get()->all();
        return view('index', [
            'merchants' => $Merchant
        ]);
    }
}
