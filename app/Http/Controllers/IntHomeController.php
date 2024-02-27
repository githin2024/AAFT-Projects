<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntHomeController extends Controller
{
    public function InternalIndex() 
    {
        return view('int-marketing-shared.int-home');
    }

    public function LandingPage() 
    {
        return view('int-marketing-shared.int-landing-page');
    }

    public function InternalCampaign() 
    {
        return view('int-marketing-shared.int-campaign');
    }
}
