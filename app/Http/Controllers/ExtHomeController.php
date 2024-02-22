<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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

    public function createCampaign() {
        $institution = DB::table('institution')->where('active', 1)->get();
        $programType = DB::table('program_type')->where('active', 1)->get();
        $marketingAgency = DB::table('agency')->where('active', 1)->get(); 
        $leadSource = DB::table('leadsource')->where('active', 1)->get();
        $targetLocation = DB::table('target_location')->where('active', 1)->get();
        $persona = DB::table('persona')->where('active', 1)->get();
        $price = DB::table('campaign_price')->where('active', 1)->get();
        $headline = DB::table('headline')->where('active', 1)->get();
        $targetSegment = DB::table('target_segment')->where('active', 1)->get();
        $campaignType = DB::table('campaign_type')->where('active', 1)->get();
        $campaignSize = DB::table('campaign_size')->where('active', 1)->get();
        $campaignVersion = DB::table('campaign_version')->where('active', 1)->get();
        return response()->json(['institution' => $institution, 'programType' => $programType, 'marketingAgency' => $marketingAgency, 'leadSource' => $leadSource,
            'targetLocation' => $targetLocation, 'persona' => $persona, 'price' => $price, 'headline' => $headline, 'targetSegment' => $targetSegment, 'campaignType' => $campaignType,
             'campaignSize' => $campaignSize, 'campaignVersion' => $campaignVersion]);
    }

    public function getCourses(Request $req) {
        $institutionCode = $req->get('institutionCode');
        $institutionId = DB::table('institution')->where('institution_code', $institutionCode)->value('institution_id');
        $courses = DB::table('courses')->where('fk_institution_id', $institutionId)->get();
        return response()->json(['courses' => $courses]);
    }

    public function storeCampaign(Request $req) {
        $req->validate([
            'campaign-institution' => 'required',
            'programType' => 'required',
            'marketingAgency' => 'required',
            'leadSource' => 'required',
            'targetLocation' => 'required',
            'persona' => 'required',
            'price' => 'required',
            'courses' => 'required',
            'campaignDate' => 'required',
            'targetSegment' => 'required',
            'campaignType' => 'required',
            'campaignSize' => 'required',
            'campaignVersion' => 'required',
            
        ]);
        $userComment = new UserComment();
        $userComment->name = $request->input('name');
        $userComment->email = $request->input('email');
        $userComment->message = $request->input('message');
        $userComment->save();
    }
}
