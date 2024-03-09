<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAdminCampaign;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function AdminInstitution()
    {
        $institution_List = DB::select('Select institution_id, institution_name FROM institution WHERE active = 1');
        return view('admin-shared.admin-institution', ['institution_List'=>$institution_List]);
    }

    private function GetCampaignList()
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                    cs.course_name, cps.campaign_status_name 
                                    FROM campaigns c
                                    LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                    LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                    LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                    LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                    LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id");
        return $campaignList;
    }

    public function AdminHomeInstitution()
    {                
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                    cs.course_name, cps.campaign_status_name, c.active 
                                    FROM campaigns c
                                    LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                    LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                    LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                    LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                    LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                    WHERE c.active = 1 ORDER BY c.created_by DESC LIMIT 5");

        $campaignLeadCount = DB::select("SELECT l.leadsource_name as `Leadsource_Name`, COUNT(c.campaign_id) AS `Campaign_Count` FROM campaigns c
                                            LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                            WHERE c.active = 1                                           
                                            GROUP BY l.leadsource_id, l.leadsource_name");
        
        $campaignLeadCollect = collect($campaignLeadCount)->pluck('Campaign_Count', 'Leadsource_Name');
        
        $labels = $campaignLeadCollect->keys();
        $leadCount = $campaignLeadCollect->values();
        
        return view('admin-shared.admin-home', compact(['campaignList', 'labels', 'leadCount']));
    }

    public function AdminCampaignInstitution()
    {
        $institutionList = DB::select('Select institution_id, institution_name FROM institution WHERE active = 1');
        return view('admin-shared.admin-campaign', compact(['institutionList']));
    }

    public function AdminCampaignListInstitution(Request $req)
    {
        $institutionId = $req->get('institutionId');
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                            cs.course_name, cps.campaign_status_name 
                                            FROM campaigns c
                                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                            LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                            LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                            WHERE i.institution_id = ?", [$institutionId]);
        
        return response()->json(['campaignList' => $campaignList]);
    }
    
    public function AdminCampaignDownload(Request $req)
    {        
        $fileName = "campaign - " . date("Y-m-d") . ".xlsx";
        return Excel::download(new ExportAdminCampaign($req->get('institutionId')), $fileName);
    }
    
}
