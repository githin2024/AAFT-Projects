<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\ExportCampaign;
use App\Campaigns;
use Maatwebsite\Excel\Facades\Excel;
class IntHomeController extends Controller
{
    public function InternalIndex() 
    {
        if(session('username'))
        {
            $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, c.campaign_name, c.adset_name, c.adname, c.creative, l.leadsource_name, DATE_FORMAT(c.campaign_date, '%d %M %Y') campaign_date FROM campaigns c
                                                LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                                                LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                                LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                                LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                                LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                                WHERE c.active = 1 ORDER BY c.created_by DESC LIMIT 5");
            
            $campaignStatusChart = DB::select("SELECT l.leadsource_name, COUNT(c.campaign_id) campaign_count FROM leadsource l
                                                LEFT JOIN campaigns c ON l.leadsource_id = c.fk_lead_source_id
                                                GROUP BY l.leadsource_name");   
                                                
            $campaignLeadCollect = collect($campaignStatusChart)->pluck('campaign_count', 'leadsource_name');

            $labels = $campaignLeadCollect->keys();
            $leadCount = $campaignLeadCollect->values();
            
            return view('int-marketing-shared.int-home', compact(['campaignList', 'labels', 'leadCount']));
        }
        else 
        {
            return view('user-login');
        }
    }

    public function LandingPage() 
    {
        return view('int-marketing-shared.int-landing-page');
    }

    public function InternalCampaign() 
    {
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, c.campaign_name, c.adset_name, c.adname, c.creative, l.leadsource_name, DATE_FORMAT(c.campaign_date, '%d %M %Y') campaign_date, cps.campaign_status_name FROM campaigns c
                                    LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                                    LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                    LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                    LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                    LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                    WHERE c.active = 1");     

        return view('int-marketing-shared.int-campaign', compact(['campaignList']));
    }

    public function ViewCampaign(Request $req)
    {
        $campaignId = $req->campaignId;
        $campaignList = DB::select("SELECT c.campaign_id, i.institution_name, pt.program_type_name, cs.course_name, c.campaign_name, c.adset_name, c.adname, c.creative, l.leadsource_name, DATE_FORMAT(c.campaign_date, '%d %M %Y') campaign_date, cps.campaign_status_name FROM campaigns c
                                                LEFT JOIN program_type pt ON c.fk_program_type_id = pt.program_type_id
                                                LEFT JOIN courses cs ON cs.course_id = c.fk_course_id
                                                LEFT JOIN institution i ON cs.fk_institution_id = i.institution_id
                                                LEFT JOIN leadsource l ON c.fk_lead_source_id = l.leadsource_id
                                                LEFT JOIN campaign_status cps ON c.fk_campaign_status_id = cps.campaign_status_id
                                                WHERE c.active = 1 AND c.campaign_id = ?", [$campaignId]);

        return response()->json(["campaignList" => $campaignList]);
    }

    public function DownloadCampaign()
    {
        $fileName = "campaign - " . date("Y-m-d") . ".xlsx";
        return Excel::download(new ExportCampaign(), $fileName);
    }

    public function InternalLandingPage()
    {
        $landingPageList = DB::select("SELECT lp.landing_page_id, cs.course_name, lp.title, lp.description, lp.assignee, lp.assigner, dt.development_type_name, i.issue_name, p.priority_name, lps.lp_status FROM landing_page lp
                                        LEFT JOIN courses cs ON lp.fk_course_id = cs.course_id
                                        LEFT JOIN development_type dt ON lp.fk_development_id = dt.development_type_id
                                        LEFT JOIN issue i ON lp.fk_issue_id = i.issue_id
                                        LEFT JOIN priority p ON lp.fk_priority_id = p.priority_id
                                        LEFT JOIN landing_page_status lps ON lp.fk_lp_status_id = lps.lp_status_id");
        
        return view('int-marketing-shared.int-landing-page', compact(['landingPageList']));
    }

    public function GetLandingPage(Request $req)
    {
        $landingPageId = $req->landingPageId;
        $landingPageList = DB::select("SELECT landing_page_id, fk_course_id, title, description, assignee, assigner, fk_development_id, fk_issue_id, fk_priority_id, fk_lp_status_id, i.institution_id
                                        FROM landing_page lp 
                                        LEFT JOIN courses c ON c.course_id = lp.fk_course_id
										LEFT JOIN institution i ON i.institution_id = c.fk_institution_id
                                        WHERE landing_page_id = ?", [$landingPageId]);

        $landingPageCommentList = DB::select("SELECT lp_comment_id, lp_comment FROM landing_page_comments WHERE fk_landing_page_id = ?", [$landingPageId]);
        $landingFileList = DB::select("SELECT lp_file_id, file_name, file_path FROM landing_page_file WHERE fk_lp_id = ?", [$landingPageId]);
        
        $institutionList = DB::select("SELECT institution_id, institution_name FROM institution WHERE active = 1");
        $assigneeList = DB::select("SELECT u.user_id, CONCAT(u.first_name, ' ', u.last_name) AS assignee FROM users u
                                    WHERE ACTIVE  = 1");
        
        $developmentTypeList = DB::select("SELECT development_type_id, development_type_name FROM development_type WHERE active = 1");
        $issueList = DB::select("SELECT issue_id, issue_name FROM issue WHERE active = 1");
        $priorityList = DB::select("SELECT priority_id, priority_name FROM priority WHERE active = 1");
        $statusList = DB::select("SELECT lp_status_id, lp_status FROM landing_page_status WHERE active = 1");
        return view('int-marketing-shared.int-create-landing-page', compact(["institutionList", "landingPageList", "assigneeList",
                                 "developmentTypeList", "issueList", "priorityList", "statusList", "landingPageId", "landingPageCommentList", "landingFileList"]));
    }

    public function GetLandingPageCourses(Request $req)
    {
        $institutionId = $req->institutionId;
        $courseList = DB::select("SELECT course_id, course_name FROM courses WHERE fk_institution_id = ? AND active = 1", [$institutionId]);
        return response()->json(["courseList" => $courseList]);
    }

    public function StoreLandingPage(Request $req)
    {
       $institutionId = $req->landing_page_institution;
       $courseId = $req->landing_page_course;
       $title = $req->landing_page_title;
       $description = $req->description;
       $assignee = $req->assignee;
       $assigner = $req->assigner;
       $developmentType = $req->developmentType;
       $comments = $req->comments;
       $landingPageId = $req->landing_page_id;
       $issue = $req->issue == "" ? DB::table('issue')->where('issue_name', '=', "Task")->pluck('issue_id') : $req->issue;
       $priorityId = $req->priorityId == "" ? DB::table('priority')->where('priority_name', '=', 'Medium')->pluck('priority_id') : $req->priorityId;
       $status = $req->status == "" ? DB::table('landing_page_status')->where('lp_status', '=', "To Do")->pluck('lp_status_id') : $req->status;
       $fileName = "";
       
       try
        {
            if($landingPageId == 0 || $landingPageId == "")
            {         
                // DB::table('landing_page')->insert(['fk_course_id' => $courseId, 'title' => $title, 'description' => $description, 'assignee' => $assignee,
                //         'fk_development_id' => $developmentType, 'fk_issue_id' => $issue[0], 'fk_priority_id' => $priorityId[0], 'fk_lp_status_id' => $status[0], 'assigner' => $assigner, 'created_by' => session('username'), 
                //         'updated_by' => session('username'), 'created_date' => now(), 'updated_date' => now(), 'active' => 1]);
                
                // $lpId = DB::getPdo()->lastInsertId();
                // if($comments != ""){
                //     DB::table('landing_page_comments')->insert(['lp_comment' => $comments, 'fk_landing_page_id' => $lpId, 'created_by' => session("username"),
                //                                         'updated_by' => session('username'), 'created_date' => now(), 'updated_date' => now(), 'active' => 1]);
                // }

                // if($req->hasFile('files')) {
                //     $files = $req->file('files');

                //     foreach($files as $key => $file) {
                //         if($file->isValid()){
                //             $filePath = $file->store('public/uploads');
                //             $fileName = basename($filePath);
                //             $extension = $file->getClientOriginalExtension();
                //             $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                //             $fileName = $originalName . '.' . $extension;
                //             DB::table('landing_page_file')->insert(['file_name' => $fileName, 'file_path' => $filePath, 'fk_lp_id' => $landingPageId, 'fk_user_id' => $assignee, 
                //                                                     'created_by' => session('username'), 'updated_by' => session('username'), 'created_date' => now(), 
                //                                                     'updated_date' => now(), 'active' => 1]);
                //         }
                //     }
                // }

                if ($req->file('attach')) {
                    foreach ($req->file('attach') as $media) {
                        if (!empty($media)) {
                            $destinationPath = 'public/uploads';
                            $filename = $media->getClientOriginalName();
                            $media->move($destinationPath, $filename);
                            // DB::table('landing_page_file')->insert(['file_name' => $fileName, 'file_path' => $filePath, 'fk_lp_id' => $landingPageId, 'fk_user_id' => $assignee,
                            //                                         'created_by' => session('username'), 'updated_by' => session('username'), 'created_date' => now(), 
                            //                                         'updated_date' => now(), 'active' => 1]);
                        }
                    }
                }

                return $req->all();

                //return response()->json(["message" => "Landing page created successfully."]);            
            }
            else 
            {
                return response()->json(["message" => "Landing page updated successfully."]);
            }
        }
        catch(Exception $e)
        {
            return response()->json(["message" => "Error in creating a task"]);
        }
    }    
}
