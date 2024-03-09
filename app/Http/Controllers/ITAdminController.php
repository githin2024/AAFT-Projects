<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\ExportCampaign;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class ITAdminController extends Controller
{
    public function ITAdminHome()
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                    cs.course_name, cps.campaign_status_name 
                                    FROM campaigns c
                                    LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                    LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                    LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                    LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                    LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                    WHERE c.active = 1 AND i.institution_id = ? ORDER BY c.created_by DESC", [1]);

        $campaignLeadCount = DB::select("SELECT l.leadsource_name as `Leadsource_Name`, COUNT(c.campaign_id) AS `Campaign_Count` FROM campaigns c
                                            LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id                                            
                                            GROUP BY l.leadsource_id, l.leadsource_name");
        
        $campaignLeadCollect = collect($campaignLeadCount)->pluck('Campaign_Count', 'Leadsource_Name');
        
        $labels = $campaignLeadCollect->keys();
        $leadCount = $campaignLeadCollect->values();

        return view('it-admin-shared.it-admin-home', compact(['campaignList', 'labels', 'leadCount']));
    }

    public function ITAdminCampaign()
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                            cs.course_name, cps.campaign_status_name, cpc.camp_param_check_id, clr.lead_request_id, 
                                            cer.camp_edit_request_id, cer.camp_edit_request, cer.camp_edit_accept, cdr.camp_delete_request_id, cer.active AS `Edit_Active`, clr.active AS `Lead_Active` 
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
        
        return view('it-admin-shared.it-admin-campaign', ['campaignList' => $campaignList]);
    }

    public function ITAdminCampaignLeadRequest(Request $req)
    {       
        DB::table('campaign_lead_request')->insert([
            'fk_campaign_id' => $req->get('campaignId'),
            'fk_user_id' => 3,
            'campaign_lead_request' => 1,
            'campagin_lead_request_date' => now(),
            'created_by' => "githin.thomas",
            'updated_by' => "githin.thomas",
            'created_date' => now(),
            'updated_date' => now(),
            'active' => 1   
        ]);

        return response()->json(["Lead request sent successfully."]);
    }

    public function ITAdminView(Request $req)
    {
        $campaignList = DB::select("SELECT i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, 
                                            cs.course_name, cps.campaign_status_name 
                                            FROM campaigns c
                                            LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                            LEFT JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                            LEFT JOIN courses cs ON c.fk_course_id = cs.course_id
                                            LEFT JOIN institution i ON i.institution_id = cs.fk_institution_id
                                            LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                            WHERE c.active = 1 AND c.campaign_id = ?", [$req->get('campaignId')]);
        
        return response()->json(['campaignList' => $campaignList]);
    }

    public function ITAdminEditAccept(Request $req)
    {
        DB::table('campaign_edit_request')->where('fk_campaign_id', $req->get('campaignId'))->update([
            'camp_edit_accept' => 1,
            'camp_edit_accept_date' => now(),
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json(["Edit request accepted successfully."]);
    }

    public function ITAdminSettings()
    {
        return view('it-admin-shared.it-admin-settings');
    }

    // Role Management

    public function ITAdminRole()
    {
        $roleList = DB::table('role')->get();
        return view('it-admin-shared.it-admin-role', ['roleList' => $roleList]);
    }

    public function ITAdminCreateRole(Request $req)
    {
        $roleId = $req->input('hdnRoleId');
        $mesg = "";
        if($roleId == 0) 
        {
            DB::table('role')->insert([
                'role_name' => $req->input('roleName'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Role created successfully.";
        }
        else 
        {
            DB::table('role')->where('role_id', $roleId)->update([
                'role_name' => $req->input('roleName'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Role updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteRole(Request $req)
    {
        $roleId = $req->get('roleId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Role deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Role restored successfully.";
        }

        DB::table('role')->where('role_id', $roleId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetRole(Request $req)
    {
        $roleId = $req->get('roleId');
        $roleList =  DB::table('role')->where('role_id', $roleId)->get();
        return $roleList;
    }

    // End Role Management
    // Agency Management

    public function ITAdminAgency()
    {
        $agencyList = DB::table('agency')->get();
        return view('it-admin-shared.it-admin-agency', ['agencyList' => $agencyList]);
    }

    public function ITAdminCreateAgency(Request $req)
    {
        $agencyId = $req->input('hdnAgencyId');
        $mesg = "";
        if($agencyId == 0) 
        {
            DB::table('agency')->insert([
                'agency_name' => $req->input('agencyName'),
                'agency_code' => $req->input('agencyCode'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Agency created successfully.";
        }
        else 
        {
            DB::table('agency')->where('agency_id', $agencyId)->update([
                'agency_name' => $req->input('agencyName'),
                'agency_code' => $req->input('agencyCode'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Agency updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteAgency(Request $req)
    {
        $agencyId = $req->get('agencyId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Agency deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Agency restored successfully.";
        }

        DB::table('agency')->where('agency_id', $agencyId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetAgency(Request $req)
    {
        $agencyId = $req->get('agencyId');
        $agencyList =  DB::table('agency')->where('agency_id', $agencyId)->get();
        return $agencyList;
    }

    public function ITAdminAgencyCheck(Request $req)
    {
        $mesg;
        $agencyCode = $req->get('agencyCode');
        $agencyId = $req->get('agencyId');
        if($agencyId != 0 )
        {
            $agencyList = DB::select("SELECT COUNT(*) AS count FROM agency a
                                      WHERE a.agency_id <> ? AND a.agency_code = ?", [$agencyId, $agencyCode]);
        }
        else 
        {
            $agencyList = DB::select("SELECT COUNT(*) AS count FROM agency a
                                      WHERE a.agency_code = ?", [$agencyCode]);
        }

        return response()->json($agencyList);        
    }

    //End Agency Management

    // Lead Source Management
    public function ITAdminLeadSource()
    {
        $leadsourceList = DB::table('leadsource')->get();
        return view('it-admin-shared.it-admin-lead-source', ['leadsourceList' => $leadsourceList]);
    }

    public function ITAdminCreateLeadSource(Request $req)
    {
        $leadSourceId = $req->input('hdnLeadSourceId');
        $mesg = "";
        if($leadSourceId == 0) 
        {
            DB::table('leadsource')->insert([
                'leadsource_name' => $req->input('leadSourceName'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Lead source created successfully.";
        }
        else 
        {
            DB::table('leadsource')->where('leadsource_id', $leadSourceId)->update([
                'leadsource_name' => $req->input('leadSourceName'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Lead source updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteLeadSource(Request $req)
    {
        $leadSourceId = $req->get('leadSourceId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Lead source deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Lead source restored successfully.";
        }

        DB::table('leadsource')->where('leadsource_id', $leadSourceId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetLeadSource(Request $req)
    {
        $leadSourceId = $req->get('leadSourceId');
        $leadSourceList =  DB::table('leadsource')->where('leadsource_id', $leadSourceId)->get();
        return $leadSourceList;
    }

    //End Lead Source Management

    //Program type Management

    public function ITAdminProgramType()
    {
        $programTypeList = DB::table('program_type')->get();
        return view('it-admin-shared.it-admin-program-type', ['programTypeList' => $programTypeList]);
    }

    public function ITAdminCreateProgramType(Request $req)
    {
        $programTypeId = $req->input('hdnProgramTypeId');
        $mesg = "";
        if($programTypeId == 0) 
        {
            DB::table('program_type')->insert([
                'program_type_name' => $req->input('programTypeName'),
                'program_code' => $req->input('programTypeCode'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Program type created successfully.";
        }
        else 
        {
            DB::table('program_type')->where('program_type_id', $programTypeId)->update([
                'program_type_name' => $req->input('programTypeName'),
                'program_code' => $req->input('programTypeCode'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Program type updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteProgramType(Request $req)
    {
        $programTypeId = $req->get('programTypeId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Program type deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Program type restored successfully.";
        }

        DB::table('program_type')->where('program_type_id', $programTypeId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetProgramType(Request $req)
    {
        $programTypeId = $req->get('programTypeId');
        $programTypeList =  DB::table('program_type')->where('program_type_id', $programTypeId)->get();
        return $programTypeList;
    }

    public function ITAdminProgramTypeCheck(Request $req)
    {
        $mesg;
        $programTypeCode = $req->get('programTypeCode');
        $programTypeId = $req->get('programTypeId');
        if($programTypeId != 0 )
        {
            $programTypeList = DB::select("SELECT COUNT(*) AS count FROM program_type p
                                      WHERE p.program_type_id <> ? AND p.program_code = ?", [$programTypeId, $programTypeCode]);
        }
        else 
        {
            $programTypeList = DB::select("SELECT COUNT(*) AS count FROM program_type p
                                      WHERE p.program_code = ?", [$programTypeCode]);
        }

        return response()->json($programTypeList);        
    }

    //End Lead Source Management

    //Persona Management

    public function ITAdminPersona()
    {
        $personaList = DB::table('persona')->get();
        return view('it-admin-shared.it-admin-persona', ['personaList' => $personaList]);
    }

    public function ITAdminCreatePersona(Request $req)
    {
        $personaId = $req->input('hdnPersonaId');
        $mesg = "";
        if($personaId == 0) 
        {
            DB::table('persona')->insert([
                'persona_name' => $req->input('personaName'),
                'persona_code' => $req->input('personaCode'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Persona created successfully.";
        }
        else 
        {
            DB::table('persona')->where('persona_id', $personaId)->update([
                'persona_name' => $req->input('personaName'),
                'persona_code' => $req->input('personaCode'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Persona updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeletePersona(Request $req)
    {
        $personaId = $req->get('personaId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Persona deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Persona restored successfully.";
        }

        DB::table('persona')->where('persona_id', $personaId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetPersona(Request $req)
    {
        $personaId = $req->get('personaId');
        $personaList =  DB::table('persona')->where('persona_id', $personaId)->get();
        return $personaList;
    }

    public function ITAdminPersonaCheck(Request $req)
    {
        $mesg;
        $personaCode = $req->get('personaCode');
        $personaId = $req->get('personaId');
        if($personaId != 0 )
        {
            $personaList = DB::select("SELECT COUNT(*) AS count FROM persona cp
                                      WHERE cp.persona_id <> ? AND cp.persona_code = ?", [$personaId, $personaCode]);
        }
        else 
        {
            $personaList = DB::select("SELECT COUNT(*) AS count FROM persona cp
                                      WHERE cp.persona_code = ?", [$personaCode]);
        }

        return response()->json($personaList);        
    }

    //End Persona Management

    //Campaign Price Management

    public function ITAdminCampaignPrice()
    {
        $campaignPriceList = DB::table('campaign_price')->get();
        return view('it-admin-shared.it-admin-campaign-price', ['campaignPriceList' => $campaignPriceList]);
    }

    public function ITAdminCreateCampaignPrice(Request $req)
    {
        $campaignPriceId = $req->input('hdnCampaignPriceId');
        $mesg = "";
        if($campaignPriceId == 0) 
        {
            DB::table('campaign_price')->insert([
                'campaign_price_name' => $req->input('campaignPriceName'),
                'campaign_price_code' => $req->input('campaignPriceCode'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Campaign price created successfully.";
        }
        else 
        {
            DB::table('campaign_price')->where('campaign_price_id', $campaignPriceId)->update([
                'campaign_price_name' => $req->input('campaignPriceName'),
                'campaign_price_code' => $req->input('campaignPriceCode'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Campaign price updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteCampaignPrice(Request $req)
    {
        $campaignPriceId = $req->get('campaignPriceId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Campaign Price deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Campaign Price restored successfully.";
        }

        DB::table('campaign_price')->where('campaign_price_id', $campaignPriceId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetCampaignPrice(Request $req)
    {
        $campaignPriceId = $req->get('campaignPriceId');
        $campaignPriceList =  DB::table('campaign_price')->where('campaign_price_id', $campaignPriceId)->get();
        return $campaignPriceList;
    }

    public function ITAdminCampaignPriceCheck(Request $req)
    {
        $mesg;
        $campaignPriceCode = $req->get('campaignPriceCode');
        $campaignPriceId = $req->get('campaignPriceId');
        if($campaignPriceId != 0 )
        {
            $campaignPriceList = DB::select("SELECT COUNT(*) AS count FROM campaign_price cp
                                      WHERE cp.campaign_price_id <> ? AND cp.campaign_price_code = ?", [$campaignPriceId, $campaignPriceCode]);
        }
        else 
        {
            $campaignPriceList = DB::select("SELECT COUNT(*) AS count FROM campaign_price cp
                                      WHERE cp.campaign_price_code = ?", [$campaignPriceCode]);
        }

        return response()->json($campaignPriceList);        
    }

    //End Camapaign Price Management

    //Headline Management

    public function ITAdminHeadline()
    {
        $headlineList = DB::table('headline')->get();
        return view('it-admin-shared.it-admin-headline', ['headlineList' => $headlineList]);
    }

    public function ITAdminCreateHeadline(Request $req)
    {
        $headlineId = $req->input('hdnHeadlineId');
        $mesg = "";
        if($headlineId == 0) 
        {
            DB::table('headline')->insert([
                'headline_name' => $req->input('headlineName'),
                'headline_code' => $req->input('headlineCode'),
                'created_by' => "githin.thomas",
                'updated_by' => "githin.thomas",
                'created_date' => now(),
                'updated_date' => now(),
                'active' => 1
            ]);
            $mesg = "Headline created successfully.";
        }
        else 
        {
            DB::table('headline')->where('headline_id', $headlineId)->update([
                'headline_name' => $req->input('headlineName'),
                'headline_code' => $req->input('headlineCode'),
                'updated_by' => "githin.thomas",
                'updated_date' => now()
            ]);

            $mesg = "Headline updated successfully.";
        }

        return redirect()->back()->with('message', $mesg);
    }

    public function ITAdminDeleteHeadline(Request $req)
    {
        $headlineId = $req->get('headlineId');
        $active = 0;
        $mesg = "";
        if($req->get('identification') == 0) {
            $active = 0;
            $mesg = "Headline deleted successfully.";
        }
        else {
            $active = 1;
            $mesg = "Headline restored successfully.";
        }

        DB::table('headline')->where('headline_id', $headlineId)->update([
            'active' => $active,
            'updated_by' => "githin.thomas",
            'updated_date' => now()
        ]);

        return response()->json([$mesg]);
    }

    public function ITAdminGetHeadline(Request $req)
    {
        $headlineId = $req->get('headlineId');
        $headlineList =  DB::table('headline')->where('headline_id', $headlineId)->get();
        return $headlineList;
    }

    public function ITAdminHeadlineCheck(Request $req)
    {
        $mesg;
        $headlineCode = $req->get('headlineCode');
        $headlineId = $req->get('headlineId');
        if($headlineId != 0 )
        {
            $headlineList = DB::select("SELECT COUNT(*) AS count FROM headline h
                                      WHERE h.headline_id <> ? AND h.headline_code = ?", [$headlineId, $headlineCode]);
        }
        else 
        {
            $headlineList = DB::select("SELECT COUNT(*) AS count FROM headline h
                                      WHERE h.headline_code = ?", [$headlineCode]);
        }

        return response()->json($headlineList);        
    }

    //End Headline Management
}
