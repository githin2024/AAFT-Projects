@extends('ext-marketing.ext-master')

@section('content')



    <div class="col-lg-12 mb-4">
      <div class="nav-wrapper position-relative">
        <ul class="nav nav-pills nav-tabs p-1" role="tablist">
          @foreach($institutionList as $institute)
            <li class="nav-item">
              @if($institute->institution_name == "AAFT Online")
                  <a class="nav-link mb-0 px-0 py-2 mx-1 active" data-bs-toggle="tab" onclick="changeInstitution('{{ $institute->institution_name }}')" role="tab">              
                  <span class="ms-1 text-uppercase" style="padding: 5px;"> {{ $institute->institution_name }}</span>
                  </a>
              @else
                  <a class="nav-link mb-0 px-0 py-2 mx-1" data-bs-toggle="tab" onclick="changeInstitution('{{ $institute->institution_name }}')" role="tab" >              
                  <span class="ms-1 text-uppercase" style="padding: 5px;"> {{ $institute->institution_name }}</span>
                  </a>
              @endif
            </li>
          @endforeach          
        </ul>
      </div>
    </div>
    <div class="row" id="extHomeContentId">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 card-backgroundcolor">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-outlined">task_alt</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Active</p>
                        <h4 class="mb-0" id="activeCount">{{ $activeCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    
                </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 card-backgroundcolor">
                    <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-outlined">pause_circle</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">On Hold</p>
                        <h4 class="mb-0" id="onHoldCount">{{$onHoldCount}}</h4>
                    </div>                    
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    
                </div>                
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 card-backgroundcolor">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-outlined">new_releases</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">New</p>
                        <h4 class="mb-0" id="newCount">{{ $newCount }}</h4>
                    </div>                    
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    
                </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 card-backgroundcolor">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-outlined">delete</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Delete</p>
                        <h4 class="mb-0" id="deleteCount">{{ $deleteCount }}</h4>
                    </div>
                    
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    
                </div>                
          </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0 card-backgroundcolor">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h5>Campaigns</h5>                  
                </div>
                <div class="col-lg-6 col-6 my-auto text-end">
                  <div class="dropdown float-lg-end pe-0">
                    <input type="hidden" id="hdnInstitutionId" value="{{ $institutionId }}" />
                    <a class="btn btn-primary" onclick="downloadExtCampaign({{ $institutionId }})" href="{{ url('excel-campaign') }}" title="Download">
                      <i class="fa fa-file-excel-o" style="font-size: small;">&nbsp; Download</i>
                    </a>
                  </div>
                </div>                
              </div>
            </div>
            <div class="card-body px-1 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0" id="homeCampaignTable">
                  <thead>
                    <tr>
                        <th class="text-uppercase opacity-10">Institution</th>
                        <th class="text-uppercase opacity-10">Program Type</th>
                        <th class="text-uppercase opacity-10">Course</th>
                        <th class="text-uppercase opacity-10">Campaign Name</th>
                        <th class="text-uppercase opacity-10">Campaign Form Name</th>
                        <th class="text-uppercase opacity-10">Leadsource</th>                        
                        <th class="text-uppercase opacity-10">Status</th>                                            
                    </tr>
                  </thead>
                  <tbody id="homeCampaignBody">
                    @foreach($campaignList as $campaign)
                      
                      <tr>
                        <td style="padding-left: 20px;">{{ $campaign->institution_name }}</td>
                        <td style="padding-left: 15px;">{{ $campaign->program_type_name }}</td>
                        <td style="padding-left: 15px;">{{ $campaign->course_name }}</td>
                        <td style="padding-left: 15px;">{{ $campaign->campaign_name }}</td>
                        <td style="padding-left: 15px;">{{ $campaign->campaign_form_name }}</td>                        
                        <td style="padding-left: 15px;">{{ $campaign->leadsource_name }}</td>                        
                        <td style="padding-left: 15px;">{{ $campaign->campaign_status_name }}</td>                       
                      </tr>
                      
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>        
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
      <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.1/js/bootstrap.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script>
      
      <script type="text/javascript">
        $(document).ready(function() {               
          $("#extCampaignID").removeClass( "active bg-primary bg-gradient" );
          $("#extCampaignHomeID").addClass( "active bg-primary bg-gradient" );
          $("#extCampaignFormID").removeClass("active bg-primary bg-gradient");
          $('#homeCampaignTable').dataTable();          
          // document.getElementById('sidebar-text-home').style.color = "white !important";
          // document.getElementById('sidebar-text-campaign').style.color = "black !important";
          // document.getElementById('sidebar-text-camp-form').style.color = "black !important";
          // document.getElementById('sidebar-text-lp').style.color = "black !important";

        });
        
        function changeInstitution(institute) {
          
          $.ajax({
            type:'get',
            url: "/ext-home-change-institution",
            data: {'institution' : institute},          
            success:function(data){
              
              var campBody = $("#homeCampaignTable").empty();
                //$("#hdnInstitutionId").val(data.institutionId);
                $("#activeCount").empty().text(data.activeCount);
                $("#onHoldCount").empty().text(data.onHoldCount);
                $("#newCount").empty().text(data.newCount);
                $("#deleteCount").empty().text(data.deleteCount);
              if(data.campaignList != "" && data.campaignList != undefined){
                
                var campTheadItem = "<thead>" +
                "<tr>" +                    
                    "<th class='opacity-10'>PROGRAM TYPE</th>" + 
                    "<th class='opacity-10'>COURSE</th>" +
                    "<th class='opacity-10'>LEADSOURCE</th>" +
                    "<th class='opacity-10'>AGENCY</th>" +
                    "<th class='opacity-10'>CAMPAIGN NAME</th>" +                                   
                    "<th class='opacity-10'>STATUS</th>" +
                    "<th class='opacity-10'>APPROVAL STATUS</th>" +
                    "<th class='opacity-10'>APPROVAL COMMENTS</th>" +                                    
                    "<th class='opacity-10'>ACTION</th>" +
                "</tr>" +
                "</thead><tbody>";
                campBody.append(campTheadItem);
                for(var i = 0; i < data.campaignList.length;i++){
                  var campBodyItem = "<tr><td style='padding-left: 20px;'>"+ data.campaignList[i]['institution_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['program_type_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['course_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['campaign_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['campaign_form_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['leadsource_name'] +"</td>" +
                                     "<td style='padding-left: 20px;'>"+ data.campaignList[i]['campaign_status_name'] +"</td>" +
                                     "</tr>";
                  campBody.append(campBodyItem);
                }
                campBody.append("</tbody>")
              }
              $('#homeCampaignTable').DataTable().destroy();
              $("#homeCampaignTable").dataTable();
            }
          });
        } 

        function downloadExtCampaign() {
          var institute = $("#hdnInstitutionId").val();
          window.location.href = "{{ url('excel-campaign') }}" + "/" + institute;
        }
      </script>
    
@endsection