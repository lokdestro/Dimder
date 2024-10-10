<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class PageController extends BaseController
{
    public function index(){


        Log::info("0000000000000000" );
        return view('welcome');
    }

    public function page(){
        $x = 20;
        return view('page');
    }
    
}
