<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        return view('ext-marketing.ext-create-campaign', ['institutions' => $institution, 'programTypes' => $programType, 'marketingAgencies' => $marketingAgency, 'leadSources' => $leadSource,
            'targetLocations' => $targetLocation, 'personas' => $persona, 'prices' => $price, 'headlines' => $headline, 'targetSegments' => $targetSegment, 'campaignTypes' => $campaignType,
            'campaignSizes' => $campaignSize, 'campaignVersions' => $campaignVersion]);
    }

    public function getCourses(Request $req) {
        $institutionCode = $req->get('institutionCode');
        $institutionId = DB::table('institution')->where('institution_code', $institutionCode)->value('institution_id');
        $courses = DB::table('courses')->where('fk_institution_id', $institutionId)->get();
        return response()->json(['courses' => $courses]);
    }

    public function storeCampaign(Request $req) {
        //Check Validation

        $reqValidatedData = $req->validate([
            'campaign-institution' => 'required',
            'programType' => 'required',
            'marketingAgency' => 'required',
            'leadSource' => 'required',
            'targetLocation' => 'required',
            'persona' => 'required',
            'price' => 'required',
            'courses' => 'required',
            'campaignDate' => 'required',
            'headline' => 'required',
            'targetSegment' => 'required',
            'campaignType' => 'required',
            'campaignSize' => 'required',
            'campaignVersion' => 'required'
        ]);

        $institution = DB::table('institution')->select('institution_id', 'institution_name', 'institution_code')->where('institution_code', $reqValidatedData['campaign-institution'])->get();
        $programType = DB::table('program_type')->select('program_type_id', 'program_type_name', 'program_code')->where('program_code', $reqValidatedData['programType'])->get();
        $agency = DB::table('agency')->select('agency_id', 'agency_name', 'agency_code')->where('agency_code', $reqValidatedData['marketingAgency'])->get();
        $leadSource = DB::table('leadsource')->select('leadsource_id', 'leadsource_name')->where('leadsource_id', $reqValidatedData['leadSource'])->get();
        $targetLocation = DB::table('target_location')->select('target_location_id', 'target_location_name', 'target_location_code')->where('target_location_code', $reqValidatedData['targetLocation'])->get();
        $persona = DB::table('persona')->select('persona_id', 'persona_name', 'persona_code')->where('persona_code', $reqValidatedData['persona'])->get();
        $price = DB::table('campaign_price')->select('campaign_price_id', 'campaign_price_name', 'campaign_price_code')->where('campaign_price_code', $reqValidatedData['price'])->get();
        $courses = DB::table('courses')->select('course_id', 'course_name', 'course_code')->where('course_code', $reqValidatedData['courses'])->get();
        $campDate= $req->input('campaignDate');
        $campaignMonth = Carbon::parse($campDate)->month;
        $campaignYear = Carbon::parse($campDate)->year;
        $headline = DB::table('headline')->select('headline_id', 'headline_name', 'headline_code')->where('headline_code', $reqValidatedData['headline'])->get();
        $targetSegment = DB::table('target_segment')->select('target_segment_id', 'target_segment_name', 'target_segment_code')->where('target_segment_code', $reqValidatedData['targetSegment'])->get();
        $campType = DB::table('campaign_type')->select('campaign_type_id','campaign_type_name', 'campaign_type_code')->where('campaign_type_code', $reqValidatedData['campaignType'])->get();
        $campSize = DB::table('campaign_size')->select('campaign_size_id', 'campaign_size_name', 'campaign_size_code')->where('campaign_size_code', $reqValidatedData['campaignSize'])->get();
        $campVersion = DB::table('campaign_version')->select('campaign_version_id', 'campaign_version_name', 'campaign_version_code')->where('campaign_version_code', $reqValidatedData['campaignVersion'])->get();

        $campaignName = $institution->institution_code.''. $programType->program_code . '_' . $agency->agency_code . '_' . $courses->course_code . '_' . $campaignMonth .''. $campaignYear;
        $campaignAdsetName = $campaignName . '_' . $persona->persona_code . '_' . $targetLocation->target_location_code;
        $campaignAdName = $campaignAdsetName . '_' . $price->campaign_price_code . '_' . $campType->campaign_type_code . '_' . $targetSegment->target_segment_code . '_' . $campVersion->campaign_version_code;
        $campaignCreative = $campaignName . '_' . $price->campaign_price_code . '_' . $persona->persona_code . '_' . $headline->headline_code . '_' . $campSize->campaign_size_name . '_' . $campVersion->campaign_version_code;
        $leadSourceName = $institution->institution_code .''. $programType->program_code . '_' . $agency->agency_code . '_' . $courses->course_code . '_' . $leadSource->leadsource_name;

        DB::table('campaigns')->insert([
            'campaign_name' => $campaignName,
            'fk_course_id' => $courses->course_id,
            'fk_program_type_id' => $programType->program_type_id,
            'fk_agency_id' => $agency->agency_id,
            'fk_lead_source_id' => $leadSource->leadsource_id,
            'fk_persona_id' => $persona->persona_id,
            'fk_campaign_price_id' => $price->campaign_price_id,
            'campaign_date' => $campDate,
            'fk_headline_id' => $headline->headline_id,
            'fk_target_location_id' => $targetLocation->target_location_id,
            'fk_target_segment_id' => $targetSegment->target_segment_id,
            'fk_campaign_size_id' => $campSize->campaign_size_id,
            'fk_campaign_version_id' => $campVersion->campaign_version_id,
            'fk_campaign_type_id' => $campType->campaign_type_id,
            'fk_user_id' => 3,
            'fk_campaign_status_id' => 1,
            'adset_name' => $campaignAdsetName,
            'adname' => $campaignAdName,
            'creative' => $campaignCreative,
            'leadsource_name' => $leadSourceName,
            'created_date' => now(),
            'updated_date' => now(),
            'active' => 1,
            'created_by' => "githin.thomas",
            'updated_by' => "githin.thomas"
        ]);

        return redirect()-> route('campaign')
        ->with('success', 'Registered Successfully');
    }
}
