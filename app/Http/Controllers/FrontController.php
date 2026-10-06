<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;

class FrontController extends Controller
{
    use LogsApiCalls;

    public function home(Request $request)
    {
        return view('front-pages.home');
    }

}