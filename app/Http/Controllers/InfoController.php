<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function contactUs(){

        return view('frontend.pages.contact_us');
    }

    public function aboutUs(){

        return view('frontend.pages.aboutUs');
    }

}
