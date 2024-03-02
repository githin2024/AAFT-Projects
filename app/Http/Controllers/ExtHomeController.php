<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\ExportCampaign;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class ExtHomeController extends Controller
{
    public function index()
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, cs.course_name, cps.campaign_status_name
                                    FROM campaigns c
                                    INNER JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                    INNER JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                    INNER JOIN courses cs ON c.fk_course_id = cs.course_id
                                    INNER JOIN institution i ON i.institution_id = cs.fk_institution_id
                                    INNER JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id");
        $activeCount = DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                                    LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                    WHERE cs.campaign_status_name = ?", ["Active"]);
            
        $newCount = DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                                LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                WHERE cs.campaign_status_name = ?", ["New"]);
        
        $onHoldCount = DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                                LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                WHERE cs.campaign_status_name = ?", ["On Hold"]);

        $deleteCount = DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                                LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                WHERE cs.campaign_status_name = ?", ["Delete"]);

        $statusChart = DB::select("SELECT cs.campaign_status_name, COUNT(c.fk_campaign_status_id) AS `Campaign_Status_Count` FROM campaigns c
                                            LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                                            GROUP BY c.fk_campaign_status_id, cs.campaign_status_name");      
        
        return view('ext-marketing.ext-home', compact(['campaignList', 'activeCount', 'newCount', 'onHoldCount', 'deleteCount']));
    }

    public function campaign()
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                            cs.course_name, cps.campaign_status_name, cpc.camp_param_check_id, clr.lead_request_id, 
                                            cer.camp_edit_request_id, cdr.camp_delete_request_id, cer.active AS `Edit_Active`, clr.active AS `Lead_Active` 
                                            FROM campaigns c
                                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                            LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                            LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                            LEFT JOIN campaign_parameters_check cpc ON cpc.fk_campaign_id = c.campaign_id
                                            LEFT JOIN campaign_lead_request clr ON clr.fk_campaign_id = c.campaign_id
                                            LEFT JOIN campaign_edit_request cer ON cer.fk_campaign_id = c.campaign_id
                                            LEFT JOIN campaign_delete_request cdr ON cdr.fk_campaign_id = c.campaign_id
                                            WHERE c.active = 1");
        
        return view('ext-marketing.ext-campaign', ['campaignList' => $campaignList]);
    }

    public function createCampaign() {
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
        $headline = DB::select("select headline_id, headline_name, headline_code from headline where headline_code = ?", [$reqValidatedData['headline']]);
        $targetSegment = DB::select("select target_segment_id, target_segment_name, target_segment_code from target_segment where target_segment_code = ?", [$reqValidatedData['targetSegment']]);
        $campType = DB::select("select campaign_type_id, campaign_type_name, campaign_type_code from campaign_type where campaign_type_code = ?", [$reqValidatedData['campaignType']]);
        $campSize = DB::select("select campaign_size_id, campaign_size_name, campaign_size_code from campaign_size where campaign_size_code = ?", [$reqValidatedData['campaignSize']]);
        $campVersion = DB::select("select campaign_version_id, campaign_version_name, campaign_version_code from campaign_version where campaign_version_code = ?", [$reqValidatedData['campaignVersion']]);
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
        $campaignName = $institutionCode.''. $programTypeCode . '_' . $agencyCode . '_' . $courseCode . '_' . $campaignMonth .''. $campaignYear;
        $campaignAdsetName = $campaignName . '_' . $personaCode . '_' . $targetLocationCode;
        $campaignAdName = $campaignAdsetName . '_' . $priceCode . '_' . $campaignTypeCode . '_' . $targetSegmentCode . '_' . $campaignVersionCode;
        $campaignCreative = $campaignName . '_' . $priceCode . '_' . $personaCode . '_' . $headlineCode . '_' . $campaignSizeCode . '_' . $campaignVersionCode;
        $leadSourceName = $institutionCode .''. $programTypeCode . '_' . $agencyCode . '_' . $courseCode . '_' . $leadName;

        DB::table('campaigns')->insert([
            'campaign_name' => $campaignName,
            'fk_course_id' => $courseId,
            'fk_program_type_id' => $programTypeId,
            'fk_agency_id' => $agencyId,
            'fk_lead_source_id' => $leadSourceId,
            'fk_persona_id' => $personaId,
            'fk_campaign_price_id' => $priceId,
            'campaign_date' => $campDate,
            'fk_headline_id' => $headlineId,
            'fk_target_location_id' => $targetLocationId,
            'fk_target_segment_id' => $targetSegmentId,
            'fk_campaign_size_id' => $campaignSizeId,
            'fk_campaign_version_id' => $campaignVersionId,
            'fk_campaign_type_id' => $campaignTypeId,
            'fk_user_id' => 3,
            'fk_campaign_status_id' => 2,
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

        return redirect()->back()->with('message', 'Campaign created successfully.');
    }

    public function excelCampaign() {        
        return Excel::download(new ExportCampaign(), 'campaigns.xlsx');
    }

    public function parameterCampaign(Request $req) {
        if($req->input('published') == "true" && $req->input('course-campaign') == "true"){
            DB::table('campaign_parameters_check')->insert([
                'fk_campaign_id' => $req->input('campaignId'),
                'is_published' => 1,
                'is_course_parameter' => 1,
                'fk_user_id' => 3,
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1,
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas"
            ]);

            return redirect()->back()->with('message', ' Campaign set successfully.');
        }
    }

    public function confirmLead(Request $req) {
        $data = $req->all();
        return $data;
    }
}
