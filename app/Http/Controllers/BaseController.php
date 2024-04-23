<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    public function CampaignList($institutionName)
    {
        return DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, c.campaign_name, cf.campaign_form_name, l.leadsource_name, cps.campaign_status_name FROM campaigns c
                                        LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                                        LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                                        LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                        LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                        LEFT JOIN campaign_form_lead_request cflr ON cf.campaign_form_id = cflr.fk_campaign_form_id
                                        LEFT JOIN campaign_accept ca ON ca.fk_campaign_id = c.campaign_id
                                        LEFT JOIN campaign_form_accept cfa ON cfa.fk_campaign_form_id = cf.campaign_form_id
                                        LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id 
                                        LEFT JOIN leadsource l ON c.fk_leadsource_id = l.leadsource_id
                                        WHERE i.institution_name = ?", [$institutionName]);
    }

    public function CampaignCount($campStatus, $institutionName)
    {
        return DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                            LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                            LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                            LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                            WHERE cs.campaign_status_name = ? AND i.institution_name = ?", [ $campStatus, $institutionName]);
    }

    public function NewCount($institutionName)
    {
        return DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                            LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                            LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                            LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                            WHERE cs.campaign_status_name = 'New' AND i.institution_name = ?", [$institutionName]);
    }

    public function CampaignDetails($institutionName)
    {
        return DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, l.leadsource_name, a.agency_name, c.campaign_name, 
                                    c.campaign_date, cps.campaign_status_name, ca.camp_accept_id, ca.camp_accept, ca.comments, ce.camp_edit_accept,ce.camp_edit_id, 
                                    ce.camp_edit_reject, ce.edit_comments 
                            FROM campaigns c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                            LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                            LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                            LEFT JOIN campaign_accept ca ON ca.fk_campaign_id = c.campaign_id
                            LEFT JOIN leadsource l ON c.fk_leadsource_id = l.leadsource_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN campaign_status cps ON cps.campaign_status_id = c.fk_campaign_status_id
                            LEFT JOIN campaign_edit ce ON ce.fk_campaign_id = c.campaign_id
                            WHERE i.institution_name = ?", [$institutionName]);
    }

    public function CampaignFormDetails($institutionName)
    {
        return DB::select("SELECT c.campaign_form_id, i.institution_name, pt.program_type_name, c.campaign_form_name, ls.leadsource_name, a.agency_name, c.campaign_form_date, cfa.camp_form_accept_id, cfa.camp_form_accept, cfa.camp_form_request, cfa.camp_form_comments, cpc.camp_form_param_check_id,
                            cer.camp_form_edit_id, cer.camp_form_edit_request, cer.camp_form_edit_accept, cer.active AS `Edit_Active`, cer.camp_form_edit_comment, clr.active AS `Lead_Active`, clr.lead_request_id, clr.camp_lead_accept 
                            FROM campaign_form c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                            LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                            LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                            LEFT JOIN campaign_form_parameter_check cpc ON cpc.fk_camp_form_id = c.campaign_form_id
                            LEFT JOIN campaign_form_lead_request clr ON clr.fk_campaign_form_id = c.campaign_form_id
                            LEFT JOIN campaign_form_edit cer ON cer.fk_campaign_form_id = c.campaign_form_id 
                            LEFT JOIN campaign_form_accept cfa ON cfa.fk_campaign_form_id = c.campaign_form_id                                                
                            WHERE i.institution_name = ?", [$institutionName]);
    }

    //Campaigns

    public function CampList($institutionName)
    {
        return DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, l.leadsource_name, a.agency_name, c.campaign_name, c.campaign_date,
                                    cps.campaign_status_name, ca.camp_accept_id, ca.camp_accept, ca.comments as `accept_comments`, ce.camp_edit_accept,ce.camp_edit_id, ce.camp_edit_request, ce.edit_comments, ce.active  
                            FROM campaigns c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                            LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                            LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                            LEFT JOIN campaign_accept ca ON ca.fk_campaign_id = c.campaign_id
                            LEFT JOIN leadsource l ON c.fk_leadsource_id = l.leadsource_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN campaign_status cps ON cps.campaign_status_id = c.fk_campaign_status_id
                            LEFT JOIN campaign_edit ce ON ce.fk_campaign_id = c.campaign_id
                            WHERE i.institution_name = 'AAFT Online'");
    }
}
