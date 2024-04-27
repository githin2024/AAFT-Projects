<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\ExportCampaign;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\BaseController;
class ExtHomeController extends BaseController
{
    public function Index()
    {
        if(session('username') != "")
        {
            $campaignList = $this->CampaignList("AAFT Online");

            $activeCount = $this->CampaignCount("Active", "AAFT Online");
                
            $newCount = $this->CampaignCount("New", "AAFT Online");
            
            $onHoldCount = $this->CampaignCount("On Hold", "AAFT Online");

            $deleteCount = $this->CampaignCount("Delete", "AAFT Online");

            $statusChart = DB::select("SELECT cs.campaign_status_name, COUNT(c.fk_campaign_status_id) AS `Campaign_Status_Count` FROM campaigns c
                                                LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                                LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                                                LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                                                WHERE i.institution_name = 'AAFT Online'
                                                GROUP BY c.fk_campaign_status_id, cs.campaign_status_name");
                                                
            $institutionId = 1;
            
            return view('ext-marketing.ext-home', compact(['campaignList', 'activeCount', 'newCount', 'onHoldCount', 'deleteCount', 'institutionId']));
        }
        else
        {
            return view('user-login');
        }
    }

    public function ChangeExtHomeInstitution(Request $req)
    {
        $institution = $req->institution;
        $campaignList = $this->CampaignList($institution);
        
        $activeCount = $this->CampaignCount("Active", $institution);
                
        $newCount = $this->CampaignCount("New", $institution);
        
        $onHoldCount = $this->CampaignCount("On Hold", $institution);

        $deleteCount = $this->CampaignCount("Delete", $institution);

        return response()->json(['campaignList', 'activeCount', 'newCount', 'onHoldCount', 'deleteCount', 'institution']);
        
    }

    public function CampaignForm()
    {
        if(session('username') != "")
        {
            $institutionName = "AAFT Online";
            $campaignFormList = $this->CampaignFormDetails($institutionName);
            
            return view('ext-marketing.ext-campaignForm', ['campaignFormList' => $campaignFormList]);
        }
        else
        {
            return view('user-login');
        }
    }

    public function CreateCampaignForm(Request $req) {
        $institution = DB::table('institution')->where('active', 1)->get();
        $programType = DB::table('program_type')->where('active', 1)->get();
        $marketingAgency = DB::table('agency')->where('active', 1)->get(); 
        $targetLocation = DB::table('target_location')->where('active', 1)->get();
        $persona = DB::table('persona')->where('active', 1)->get();
        $price = DB::table('campaign_price')->where('active', 1)->get();
        $headline = DB::table('headline')->where('active', 1)->get();
        $targetSegment = DB::table('target_segment')->where('active', 1)->get();
        $campaignType = DB::table('campaign_type')->where('active', 1)->get();
        $campaignSize = DB::table('campaign_size')->where('active', 1)->get();
        $leadSource = DB::table('leadsource')->where('active', 1)->get();
        $campaignVersion = DB::table('campaign_version')->where('active', 1)->get();
        $campaignList = DB::table('campaigns')->where('fk_institution_id', $req->institute)->get();
        return response()->json(['institution' => $institution, 'programType' => $programType, 'marketingAgency' => $marketingAgency, 'leadSource' => $leadSource,
            'targetLocation' => $targetLocation, 'persona' => $persona, 'price' => $price, 'headline' => $headline, 'targetSegment' => $targetSegment, 'campaignType' => $campaignType,
             'campaignSize' => $campaignSize, 'campaignVersion' => $campaignVersion, '$campaignList' => $campaignList]);
    }

    public function GetCourses(Request $req) {
        $institutionCode = $req->get('institutionCode');
        $institutionId = DB::table('institution')->where('institution_code', $institutionCode)->value('institution_id');
        $courses = DB::table('courses')->where('fk_institution_id', $institutionId)->get();
        return response()->json(['courses' => $courses]);
    }
    
    public function excelCampaign($institution) {
              
        return Excel::download(new ExportCampaign(), 'campaigns.xlsx');
    }

    public function parameterCampaign(Request $req) {
        if($req->input('published') == "true" && $req->input('course-campaign') == "true"){
            $userId = DB::table('users')->select('user_id')->where('username', '=', session('username'))->first();
            DB::table('campaign_parameters_check')->insert([
                'fk_campaign_id' => $req->input('campaignId'),
                'is_published' => 1,
                'is_course_parameter' => 1,
                'fk_user_id' => $userId -> user_id,
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1,
                'created_by' => session('username'),
                'updated_by' => session('username')
            ]);

            return redirect()->back()->with('message', ' Campaign set successfully.');
        }
    }

    public function confirmLead(Request $req) {
        $campaignId = $req->get('campaignId');
        DB::table('campaign_lead_request')
            ->where('fk_campaign_id', $campaignId)
            ->update(['campaign_lead_accept' => 1, 
                      'campaign_lead_accept-date' => now(),
                      'updated_by' => session('username'),
                      'updated_date' => now()]);
        $campaignStatusList = DB::select("select campaign_status_id from campaign_status where campaign_status_name = 'Active'");
        foreach($campaignStatusList as $status) {
            $campaignStatusId = $status->campaign_status_id;
        }
        
        DB::table('campaigns')
            ->where('campaign_id', $campaignId)
            ->update(['fk_campaign_status_id' => $campaignStatusId,
                      'updated_by' => session('username'),
                      'updated_date' => now()]);

        return response()->json(["Lead request accepted successfully."]);
    }

    public function editCampaignRequest(Request $req)
    {
        $campaignId = $req->get('campaignId');
        $userId = DB::table('users')->select('user_id')->where('username', '=', session('username'))->first();
        $campaignEditId = DB::table('campaign_edit_request')->select('camp_edit_request_id')->where('fk_campaign_id', '=', $campaignId)->first();
        if($campaignEditId->camp_edit_request_id > 0)
        {
            DB::table('campaign_edit_request')
                ->where('fk_campaign_id', '=', $campaignId)
                ->update(['camp_edit_request_date' => now(),
                          'camp_edit_request' => 1,
                          'updated_date' => now(),
                          'updated_by' => session('username')]);
        }
        else {
        DB::table('campaign_edit_request')
            ->insert([
                'fk_campaign_id' => $campaignId,
                'fk_user_id' => $userId->user_id,
                'camp_edit_request' => 1,
                'camp_edit_request_date' => now(),
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1,
                'created_by' => session('username'),
                'updated_by' => session('username')
            ]);
        }
        
        return response()->json(["Edit request sent successfully."]);
    }

    public function getCampaign(Request $req)
    {
        $campaignList = DB::select("SELECT c.campaign_id, c.campaign_name, c.adset_name, 
                                            c.adname, c.creative, c.leadsource_name,
                                            i.institution_name, cs.course_name, 
                                            c.fk_campaign_status_id,
                                            l.leadsource_name AS `Lead_Source`
                                    FROM campaigns c 
                                    LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                    LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                    LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                    WHERE c.campaign_id = ?", [$req->get('campaignId')]);
        
        $campaignStatusList = DB::select("SELECT campaign_status_id, campaign_status_name FROM campaign_status");
        
        return response()->json(['campaignList' => $campaignList, 'campaignStatusList' => $campaignStatusList]);
    }

    public function updateCampaign(Request $req)
    {
        $campaignStatusId = $req->input('campaignStatusId');
        $campaignId = $req->input('campId');

        DB::table('campaigns')
            ->where('campaign_id', $campaignId)
            ->update([
                'fk_campaign_status_id' => $campaignStatusId,
                'updated_date' => now(),
                'updated_by' => session('username')
            ]);

        DB::table('campaign_edit_request')
            ->where('fk_campaign_id', $campaignId)
            ->update([
                'camp_edit_request' => 0,
                'camp_edit_accept' => 0,
                'camp_edit_request_date' => null,
                'camp_edit_accept_date' => null,
                'updated_by' => session('username'),
                'updated_date' => now()
            ]);

        return redirect()->back()->with('message', 'Campaign updated successfully.');
    }

    // public function createCampaignForm()
    // {        
    //     $campaignList = DB::select("SELECT c.campaign_id, c.campaign_name FROM campaigns c
    //                                 LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
    //                                 LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id                                    
    //                                 WHERE i.institution_id = 1");
        
    //     return response()->json(['campaignList' => $campaignList]);
    // }

    public function checkCampaignKey(Request $req)
    {
        $campaignKey = $req->get('keyName');
        $campaignFormId = $req->get('campaignFormId');
        $campaignFormCount = DB::select("SELECT COUNT(*) AS count FROM campaigns_form cf
                                        WHERE cf.campaign_form_id <> ? AND cf.form_key = ?", [$campaignFormId, $campaignKey]); 
        
        return response()->json([$campaignFormCount]);
    }

    //Campaign

    public function ExtCampaign()
    {
        $campaignList = $this->CampaignDetails("AAFT Online");
        $instituteId = DB::table('institution')->select('institution_id')->where('institution_name', '=', "AAFT Online")->pluck('institution_id');
        return view('ext-marketing.ext-camp', ['campaignList' => $campaignList, 'instituteId' => $instituteId]);
    }

    public function CreateCampaign()
    {
        $institution = DB::table('institution')->where('active', 1)->get();
        $programType = DB::table('program_type')->where('active', 1)->get();
        $marketingAgency = DB::table('agency')->where('active', 1)->get(); 
        $targetLocation = DB::table('target_location')->where('active', 1)->get();
        $persona = DB::table('persona')->where('active', 1)->get();
        $price = DB::table('campaign_price')->where('active', 1)->get();
        $headline = DB::table('headline')->where('active', 1)->get();
        $targetSegment = DB::table('target_segment')->where('active', 1)->get();
        $campaignType = DB::table('campaign_type')->where('active', 1)->get();
        $campaignSize = DB::table('campaign_size')->where('active', 1)->get();
        $leadSource = DB::table('leadsource')->where('active', 1)->get();
        $campaignVersion = DB::table('campaign_version')->where('active', 1)->get();
        
        return response()->json(['institution' => $institution, 'programType' => $programType, 'marketingAgency' => $marketingAgency, 'leadSource' => $leadSource,
             'targetLocation' => $targetLocation, 'persona' => $persona, 'price' => $price, 'headline' => $headline, 'targetSegment' => $targetSegment, 'campaignType' => $campaignType,
             'campaignSize' => $campaignSize, 'campaignVersion' => $campaignVersion]);
    }

    public function StoreCampaign(Request $req) {
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

        $institution = DB::select('select institution_id, institution_name, institution_code from institution where institution_code = ?', [$reqValidatedData['campaign-institution']]);
        $programType = DB::select("select program_type_id, program_type_name, program_code from program_type where program_code = ?", [$reqValidatedData['programType']]);
        $agency = DB::select("select agency_id, agency_name, agency_code from agency where agency_code = ?", [$reqValidatedData['marketingAgency']]);
        $leadSource = DB::select("select leadsource_id, leadsource_name from leadsource where leadsource_id = ?", [$reqValidatedData['leadSource']]);
        $targetLocation = DB::select("select target_location_id, target_location_name, target_location_code from target_location where target_location_code = ?", [$reqValidatedData['targetLocation']]);
        $persona = DB::select("select persona_id, persona_name, persona_code from persona where persona_code = ?", [$reqValidatedData['persona']]);
        $price = DB::select("select campaign_price_id, campaign_price_name, campaign_price_code from campaign_price where campaign_price_code = ?", [$reqValidatedData['price']]);
        $courses = DB::select("select course_id, course_name, course_code from courses where course_code = ?", [$reqValidatedData['courses']]);
        $campDate= $req->input('campaignDate');
        $campaignMonth = Carbon::parse($campDate)->month;
        $campaignYear = Carbon::parse($campDate)->year;
        $campDay = Carbon::parse($campDate)->day;
        $headline = DB::select("select headline_id, headline_name, headline_code from headline where headline_code = ?", [$reqValidatedData['headline']]);
        $targetSegment = DB::select("select target_segment_id, target_segment_name, target_segment_code from target_segment where target_segment_code = ?", [$reqValidatedData['targetSegment']]);
        $campType = DB::select("select campaign_type_id, campaign_type_name, campaign_type_code from campaign_type where campaign_type_code = ?", [$reqValidatedData['campaignType']]);
        $campSize = DB::select("select campaign_size_id, campaign_size_name, campaign_size_code from campaign_size where campaign_size_code = ?", [$reqValidatedData['campaignSize']]);
        $campVersion = DB::select("select campaign_version_id, campaign_version_name, campaign_version_code from campaign_version where campaign_version_code = ?", [$reqValidatedData['campaignVersion']]);
        $campStatusId = DB::table('campaign_status')->where('campaign_status_name', '=', 'New')->pluck('campaign_status_id');

        foreach($institution as $inst){
            $institutionCode = $inst->institution_code;
            $institutionId = $inst->institution_id;
        }
        foreach($programType as $prog){
            $programTypeCode = $prog->program_code;
            $programTypeId = $prog->program_type_id;
        }
        foreach($agency as $ag){
            $agencyCode = $ag->agency_code;
            $agencyId = $ag->agency_id;
        }
        foreach($leadSource as $lead){
            $leadName = $lead->leadsource_name;
            $leadSourceId = $lead->leadsource_id;
        }
        foreach($targetLocation as $loc){
            $targetLocationCode = $loc->target_location_code;
            $targetLocationId = $loc->target_location_id;
        }
        foreach($persona as $per){
            $personaCode = $per->persona_code;
            $personaId = $per->persona_id;
        }
        foreach($price as $pr){
            $priceCode = $pr->campaign_price_code;
            $priceId = $pr->campaign_price_id;
        }
        foreach($courses as $cour){
            $courseCode = $cour->course_code;
            $courseId = $cour->course_id;
        }
        foreach($headline as $head){
            $headlineCode = $head->headline_code;
            $headlineId = $head->headline_id;
        }
        foreach($targetSegment as $seg){
            $targetSegmentCode = $seg->target_segment_code;
            $targetSegmentId = $seg->target_segment_id;
        }
        foreach($campType as $type){
            $campaignTypeCode = $type->campaign_type_code;
            $campaignTypeId = $type->campaign_type_id;
        }
        foreach($campSize as $camp)
        {
            $campaignSizeCode = $camp->campaign_size_code;
            $campaignSizeId = $camp->campaign_size_id;            
        }
        foreach($campVersion as $ver) {
            $campaignVersionCode = $ver->campaign_version_code;
            $campaignVersionId = $ver->campaign_version_id;
        }
        $campaignName = $institutionCode.''. $programTypeCode . '_' . $agencyCode . '_' . $courseCode . '_' . $campDay . '_' . $campaignMonth .'_'. $campaignYear;
        $campaignAdsetName = $campaignName . '_' . $personaCode . '_' . $targetLocationCode;
        $campaignAdName = $campaignAdsetName . '_' . $priceCode . '_' . $campaignTypeCode . '_' . $targetSegmentCode . '_' . $campaignVersionCode;
        $campaignCreative = $campaignName . '_' . $priceCode . '_' . $personaCode . '_' . $headlineCode . '_' . $campaignSizeCode . '_' . $campaignVersionCode;
        $leadSourceName = $institutionCode .''. $programTypeCode . '_' . $agencyCode . '_' . $courseCode . '_' . $leadName;
        $userId = DB::table('users')->select('user_id')->where('username', '=', session('username'))->first(); 
        DB::table('campaigns')->insert([
            'campaign_name' => $campaignName,
            'fk_institution_id' => $institutionId,
            'fk_course_id' => $courseId,
            'fk_program_type_id' => $programTypeId,
            'fk_agency_id' => $agencyId,
            'fk_leadsource_id' => $leadSourceId,
            'fk_persona_id' => $personaId,
            'fk_campaign_price_id' => $priceId,
            'campaign_date' => $campDate,
            'fk_headline_id' => $headlineId,
            'fk_target_location_id' => $targetLocationId,
            'fk_target_segment_id' => $targetSegmentId,
            'fk_campaign_size_id' => $campaignSizeId,
            'fk_campaign_version_id' => $campaignVersionId,
            'fk_campaign_type_id' => $campaignTypeId,
            'fk_user_id' => $userId->user_id,
            'fk_campaign_status_id' => $campStatusId[0],
            'adset' => $campaignAdsetName,
            'adname' => $campaignAdName,
            'creative' => $campaignCreative,
            'leadsource_name' => $leadSourceName,
            'created_date' => now(),
            'updated_date' => now(),
            'active' => 1,
            'created_by' => session('username'),
            'updated_by' => session('username')
        ]);

        return redirect()->back()->with('message', 'Campaign created successfully.');
    }
}
