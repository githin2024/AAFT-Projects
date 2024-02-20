<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtHomeController extends Controller
{
    public function index()
    {
        return view('ext-marketing.ext-home');
    }

    public function campaign()
    {
        return view('ext-marketing.ext-campaign');
    }
}
