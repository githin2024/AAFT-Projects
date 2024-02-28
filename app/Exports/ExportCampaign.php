<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCampaign implements FromCollection
{
    use Exportable;
    
    public function collection()
    {
        $campaignList = DB::select("SELECT i.institution_name, pt.program_type_name, c.campaign_name, ls.leadsource_name, cs.course_name, cps.campaign_status_name
                                    FROM campaigns c
                                    INNER JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id 
                                    INNER JOIN leadsource ls ON c.fk_lead_source_id = ls.leadsource_id
                                    INNER JOIN courses cs ON c.fk_course_id = cs.course_id
                                    INNER JOIN institution i ON i.institution_id = cs.fk_institution_id
                                    INNER JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id");

        $campaignArray[] = array('Institution', 'Program Type', 'Campaign', 'Lead Source', 'Course', 'Status');
        foreach($campaignList as $camp){
            $campaignArray[] = array(
                'Institution' => $camp->institution_name,
                'Program Type' => $camp->program_type_name,
                'Campaign' => $camp->campaign_name,
                'Lead Source' => $camp->leadsource_name,
                'Course' => $camp->course_name,
                'Status' => $camp->campaign_status_name
            );
        }    
        return collect($campaignArray);
    }
}
