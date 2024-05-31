<?php
namespace App\Http\Components;
use Illuminate\Support\Facades\DB;

class BaseComponent
{
    //
    public static function CampaignList($institutionName)
    {
        return DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, c.campaign_name, cf.campaign_form_name, l.leadsource_name, cps.campaign_status_name, a.agency_name FROM campaigns c
                                        LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                                        LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                                        LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                        LEFT JOIN agency a on a.agency_id = c.fk_agency_id
                                        LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                        LEFT JOIN campaign_form_lead_request cflr ON cf.campaign_form_id = cflr.fk_campaign_form_id
                                        LEFT JOIN campaign_accept ca ON ca.fk_campaign_id = c.campaign_id
                                        LEFT JOIN campaign_form_accept cfa ON cfa.fk_campaign_form_id = cf.campaign_form_id
                                        LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id 
                                        LEFT JOIN leadsource l ON c.fk_leadsource_id = l.leadsource_id
                                        WHERE i.institution_name = ?", [$institutionName]);
    }

    public static function CampaignCount($campStatus, $institutionName)
    {
        return DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                            LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                            LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                            LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                            WHERE cs.campaign_status_name = ? AND i.institution_name = ?", [ $campStatus, $institutionName]);
    }

    public static function NewCount($institutionName)
    {
        return DB::scalar("SELECT COUNT(c.campaign_id) FROM campaigns c
                            LEFT JOIN campaign_status cs ON c.fk_campaign_status_id = cs.campaign_status_id
                            LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                            LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                            WHERE cs.campaign_status_name = 'New' AND i.institution_name = ?", [$institutionName]);
    }

    public static function CampaignDetails($institutionName)
    {
        return DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, l.leadsource_name, a.agency_name, c.campaign_name, 
                                    c.campaign_date, cps.campaign_status_name, ca.camp_accept_id, ca.camp_accept, ca.comments, ca.camp_request, ca.active as `camp_accept_active`, ce.camp_edit_accept, ce.camp_edit_id, ce.active AS `camp_edit_active`, 
                                    ce.camp_edit_request, ce.edit_comments, cpc.camp_param_check_id, cpc.lead_field, cpc.camp_integrated, clr.camp_lead_request_id, clr.camp_lead_request, clr.camp_lead_accept, clr.active AS `camp_lead_accept_active`
                            FROM campaigns c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                            LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                            LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                            LEFT JOIN campaign_accept ca ON ca.fk_campaign_id = c.campaign_id
                            LEFT JOIN leadsource l ON c.fk_leadsource_id = l.leadsource_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN campaign_status cps ON cps.campaign_status_id = c.fk_campaign_status_id
                            LEFT JOIN campaign_edit ce ON ce.fk_campaign_id = c.campaign_id
                            LEFT JOIN campaign_parameter_check cpc ON c.campaign_id = cpc.fk_campaign_id
                            LEFT JOIN campaign_lead_request clr ON c.campaign_id = clr.fk_campaign_id
                            WHERE i.institution_name = ?", [$institutionName]);
    }

    public static function CampaignFormDetails($institutionName)
    {
        return DB::select("SELECT c.campaign_form_id, i.institution_name, pt.program_type_name, c.campaign_form_name, ls.leadsource_name, a.agency_name, c.campaign_form_date, cfa.camp_form_accept_id, cfa.camp_form_accept, cfa.camp_form_request, cfa.camp_form_comments, cfa.active AS `camp_form_accept_active`, cpc.camp_form_param_check_id, cpc.form_integrated, cpc.lead_field,
        cer.camp_form_edit_id, cer.camp_form_edit_request, cer.camp_form_edit_accept, cer.active AS `Edit_Active`, cer.camp_form_edit_comment, clr.active AS `Lead_Active`, clr.lead_request_id, clr.camp_lead_request, clr.camp_lead_accept, clr.active AS `camp_form_lead_active`, cs.course_name, cps.campaign_status_name, cfl.camp_form_lead_id, cfl.lead_email, cfl.lead_phone, cfl.active AS `campaign_form_lead_active`, cfl.lead_verify 
                            FROM campaign_form c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                            LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                            LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                            LEFT JOIN campaign_form_parameter_check cpc ON cpc.fk_camp_form_id = c.campaign_form_id
                            LEFT JOIN campaign_form_lead_request clr ON clr.fk_campaign_form_id = c.campaign_form_id
                            LEFT JOIN campaign_form_lead cfl ON cfl.fk_camp_form_lead_request_id = clr.lead_request_id
                            LEFT JOIN campaign_form_edit cer ON cer.fk_campaign_form_id = c.campaign_form_id 
                            LEFT JOIN campaign_form_accept cfa ON cfa.fk_campaign_form_id = c.campaign_form_id                                                
                            WHERE i.institution_name = ?", [$institutionName]);
    }

    public static function CampaignStatusChart($institutionName)
    {
        return DB::select("SELECT a.agency_name, COUNT(c.campaign_id) AS `campaigncount`
                            FROM campaigns c
                            LEFT JOIN campaign_form cf ON c.campaign_id = cf.fk_campaign_id
                            LEFT JOIN campaign_form_lead_request cflr ON cf.campaign_form_id = cflr.fk_campaign_form_id
                            LEFT JOIN agency a ON a.agency_id = c.fk_agency_id
                            LEFT JOIN institution i ON i.institution_id = c.fk_institution_id
                            WHERE cflr.camp_lead_accept = 1 AND i.institution_name = ?
                            GROUP BY a.agency_name, c.campaign_id", [$institutionName]);
    }

    public static function LandingPageStatusChart($institutionName)
    {
        return DB::select("SELECT pt.program_type_name, COUNT(lpc.fk_program_type) AS `lpProgramCount`  
                            FROM landing_page lpc
                            LEFT JOIN program_type pt ON pt.program_type_id = lpc.fk_program_type
                            LEFT JOIN institution i ON i.institution_id = lpc.fk_institution_id
                            WHERE i.institution_name = ?
                            GROUP BY pt.program_type_name, lpc.fk_program_type", [$institutionName]);
    }

    public static function LandingPageAgencyChart($institutionName)
    {
        return DB::select("SELECT c.course_name, count(lpc.fk_course_id) AS `lpCourseCount`  
                            FROM landing_page lpc
                            LEFT JOIN courses c ON lpc.fk_course_id = c.course_id
                            LEFT JOIN institution i ON i.institution_id = lpc.fk_institution_id
                            WHERE i.institution_name = ?
                            GROUP BY c.course_name, lpc.fk_course_id", [$institutionName]);
    }

    //Campaigns

    public static function CampList($institutionName)
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

    public static function ViewCampaignDetails($campaignId)
    {
        return DB::select("SELECT c.campaign_id, c.campaign_name, pt.program_type_name, i.institution_name, a.agency_name, cs.course_name, l.leadsource_name, p.persona_name, cp.campaign_price_name, 
                            h.headline_name, tl.target_location_name, ts.target_segment_name, cps.campaign_size_name, cpv.campaign_version_name, cpt.campaign_type_name, c.adset, c.adname, c.adset, c.creative, c.leadsource_name AS camp_leadsource,
                            cpst.campaign_status_name, c.campaign_date
                            FROM campaigns c
                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                            LEFT JOIN institution i ON c.fk_institution_id = i.institution_id
                            LEFT JOIN agency a ON c.fk_agency_id = a.agency_id
                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                            LEFT JOIN leadsource l ON l.leadsource_id = c.fk_leadsource_id
                            LEFT JOIN persona p ON c.fk_persona_id = p.persona_id
                            LEFT JOIN campaign_price cp ON c.fk_campaign_price_id = cp.campaign_price_id
                            LEFT JOIN headline h ON c.fk_headline_id = h.headline_id
                            LEFT JOIN target_location tl ON c.fk_target_location_id = tl.target_location_id
                            LEFT JOIN target_segment ts ON c.fk_target_segment_id = ts.target_segment_id
                            LEFT JOIN campaign_size cps ON c.fk_campaign_size_id = cps.campaign_size_id
                            LEFT JOIN campaign_version cpv ON c.fk_campaign_version_id = cpv.campaign_version_id
                            LEFT JOIN campaign_type cpt ON c.fk_campaign_type_id = cpt.campaign_type_id
                            LEFT JOIN campaign_status cpst ON cpst.campaign_status_id = c.fk_campaign_status_id
                            WHERE c.campaign_id = ?", [$campaignId]);
    }

    public static function ViewCampaignFormDetails($campFormId)
    {
        return DB::select("SELECT cf.campaign_form_id, cf.campaign_form_name, cf.form_key, cs.course_name, i.institution_name, pt.program_type_name, a.agency_name, l.leadsource_name, l.leadsource_name,
                                    cps.campaign_status_name, c.campaign_name, cf.campaign_form_date 
                            FROM campaign_form cf
                            LEFT JOIN courses cs ON cf.fk_course_id = cs.course_id
                            LEFT JOIN institution i ON cf.fk_institution_id = i.institution_id
                            LEFT JOIN program_type pt ON cf.fk_program_type_id = pt.program_type_id
                            LEFT JOIN agency a ON cf.fk_agency_id = a.agency_id
                            LEFT JOIN leadsource l ON cf.fk_lead_source_id = l.leadsource_id
                            LEFT JOIN campaign_status cps ON cf.fk_campaign_status_id = cps.campaign_status_id
                            LEFT JOIN campaigns c ON cf.fk_campaign_id = c.campaign_id
                            WHERE cf.campaign_form_id = ?", [$campFormId]);
    }

    //Landing Page 

    public static function ViewLandingPageList($institution)
    {
        return DB::select("SELECT lpc.lp_campaign_id, lpc.camp_name, pt.program_type_name, i.institution_name, c.course_name, lpc.camp_url, lpc.active
                            FROM landing_page lpc
                            LEFT JOIN institution i ON i.institution_id = lpc.fk_institution_id
                            LEFT JOIN program_type pt ON pt.program_type_id = lpc.fk_program_type
                            LEFT JOIN courses c ON lpc.fk_course_id = c.course_id                                               
                              
                            WHERE i.institution_name = ?", [$institution]);
    }

    public static function ViewLandingPageCampDetails($lpCampId)
    {
        return DB::select("SELECT lpc.lp_campaign_id, lpc.camp_name, pt.program_type_name, i.institution_name, c.course_name, lpc.camp_url
                            FROM landing_page lpc
                            LEFT JOIN institution i ON i.institution_id = lpc.fk_institution_id
                            LEFT JOIN program_type pt ON pt.program_type_id = lpc.fk_program_type
                            LEFT JOIN courses c ON lpc.fk_course_id = c.course_id                                                
                                  
                            WHERE lpc.lp_campaign_id = ?", [$lpCampId]);
    }
}
