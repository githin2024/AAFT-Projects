<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminInstitution()
    {
        $institution_List = DB::select('Select institution_id, institution_name FROM institution WHERE active = 1');
        return view('admin-shared.admin-institution', ['institution_List' => $institution_List]);
    }

    public function AdminHomeInstitution(int $id)
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
                                    LEFT JOIN campaign_status css ON css.campaign_status_id = c.fk_campaign_status_id
                                    WHERE c.active = 1 AND i.institution_id = ? AND css.campaign_status_name = ? LIMIT 5", [$id, 'New']);

        $campaignLeadCount = DB::select("SELECT l.leadsource_name as `Leadsource_Name`, COUNT(c.campaign_id) AS `Campaign_Count` FROM campaigns c
                                            LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                            WHERE i.institution_id = ?
                                            GROUP BY l.leadsource_id, l.leadsource_name", [$id]);
        
        sessionStorage.setItem('institutionID', $id);
        
        $campaignLeadCollect = collect($campaignLeadCount)->pluck('Campaign_Count', 'Leadsource_Name');
        
        $labels = $campaignLeadCollect->keys();
        $leadCount = $campaignLeadCollect->values();
        
        return view('admin-shared.admin-home', compact(['campaignList', 'labels', 'leadCount']));
    }

    public function AdminCampaignInstitution(int $id)
    {

    }
    
}
