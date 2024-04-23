@extends('it-admin-shared.it-admin-master')

@section('it-adminContent')
<div class="row mt-4">
    @if(session()->has('message'))
      <div class="alert alert-success" id="successMesgID" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false" style="display: none">
        {{ session()->get('message') }}
        <button type="button" onclick="campNotify();" class="btn-close" style="float: right;" aria-label="Close"></button>
      </div>
    @endif
    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 card-backgroundcolor">
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <h5>Campaigns</h5>                
                    </div>
                    <div class="col-lg-6 col-6 my-auto text-end">
                        <div class="dropdown float-lg-end pe-4">
                            <a class="btn btn-primary" id="it-adminCampaignDownloadId" href="{{ url('it-admin-campaign-download')}}" title="Download">
                                <span class="fa fa-file-excel" style="font-size: small;">&nbsp; Download</span>
                            </a>                
                        </div>
                    </div>                  
                </div>            
            </div>
            <div class="card-body px-1 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-1" id="it-campaignTable">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Institution</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Program Type</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Campaign</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Lead Source</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Course</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Status</th>
                            <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($campaignList as $campaign)
                            <tr>
                            <td style="padding-left: 20px;">{{ $campaign->institution_name }}</td>
                            <td style="padding-left: 15px;">{{ $campaign->program_type_name }}</td>
                            <td style="padding-left: 15px;">{{ $campaign->campaign_name }}</td>
                            <td style="padding-left: 15px;">{{ $campaign->leadsource_name }}</td>
                            <td style="padding-left: 15px;">{{ $campaign->course_name }}</td>
                            <td style="padding-left: 15px;">{{ $campaign->campaign_status_name }}</td>
                            <td style="padding-left: 15px;">
                            @if(!is_null($campaign->camp_param_check_id) && is_null($campaign->lead_request_id))
                                <button type="button" class="btn btn-info" title="Lead Request" onclick="leadRequestCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">Lead Request</span></button>
                            @elseif(!is_null($campaign->camp_edit_request_id) && $campaign-> camp_edit_accept == 0 && $campaign -> camp_edit_request ==1)
                                <button type="button" class="btn btn-success" title="Allow Edit" onclick="editAllowCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">Allow Edit</span></button>
                            @endif
                                <button type="button" class="btn btn-primary" title="View" onclick="viewCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">View</span></button>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>        
</div>

<!-- Lead Generation Modal -->
<div class="modal fade" id="leadRequestModal" tabindex="-1" role="dialog" aria-labelledby="leadRequestModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Lead Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdnCampaignId" name="hdnCampaignId" />
        <p>Do you wish to send the request to check if lead is generated in CRM? </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="leadRequestId" title="Lead Request" onclick="leadRequest();">Confirm</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View Campaign Modal -->
<div class="modal fade" id="viewCampaignModal" tabindex="-1" role="dialog" aria-labelledby="leadRequestModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Campaign Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <table class="table table-bordered" id="campaignViewId">

        </table>
      </div>
      
    </div>
  </div>
</div>

<!-- Edit Accept Modal -->
<div class="modal fade" id="editAcceptModal" tabindex="-1" role="dialog" aria-labelledby="leadRequestModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId" >Edit Accept</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <input type="hidden" id="hdnCampId" name="hdnCampId" />
        <p id="modalDescriptionId">Do you wish to approve the request to edit the campaign? </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="EditAcceptId" title="Confirm" onclick="EditAcceptConfirm();">Confirm</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>      
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function() {        
        $("#it-adminCampaignID").addClass( "active bg-primary bg-gradient");
        $("#it-adminLandingPageID").removeClass( "active bg-primary bg-gradient");
        $("#it-adminHomeID").removeClass( "active bg-primary bg-gradient");
        $("#it-adminSettingsID").removeClass( "active bg-primary bg-gradient");
        $("#it-campaignTable").dataTable();
        if($("#successMesgID").text() !="") {
          $.notify($("#successMesgID").text(), "success");          
        }
    });
    
    function leadRequestCampaign(campaignId) {        
        $("#leadRequestModal").modal('show');
        $("#hdnCampaignId").val(campaignId);
    }

    function leadRequest() {
        var campId = $("#hdnCampaignId").val();
        $.ajax({
            type:'get',
            url: "/lead-request-campaign",
            data: {'campaignId' : campId},
            success:function(data){                
                if(data){
                    $.notify(data, "success");
                    $("#leadRequestModal").modal('hide');
                    window.location.href="{{'it-admin-campaign'}}" 
                }
            }
        });
    }

    function viewCampaign(campaignId) {
        $("#viewCampaignModal").modal('show');
        $.ajax({
            type:'get',
            url: "/it-admin-view-campaign",
            data: {'campaignId' : campaignId},
            success:function(data){  
                debugger;              
                if(data){
                    var campaignViewId = $("#campaignViewId").empty();
                    for(var i = 0; i < data.campaignList.length;i++){
                        var campaignDetail = "<tr>" + 
                                                "<td>Institution</td>" + 
                                                "<td>" + data.campaignList[i]['institution_name'] + "</td>" +
                                            "</tr>" +
                                            "<tr>" + 
                                                "<td>Program Type</td>" + 
                                                "<td>" + data.campaignList[i]['program_type_name'] + "</td>" +
                                            "</tr>" +
                                            "<tr>" + 
                                                "<td>Campaign</td>" + 
                                                "<td>" + data.campaignList[i]['campaign_name'] + "</td>" +
                                            "</tr>" +
                                            "<tr>" + 
                                                "<td>Lead Source</td>" + 
                                                "<td>" + data.campaignList[i]['leadsource_name'] + "</td>" +
                                            "</tr>" +
                                            "<tr>" + 
                                                "<td>Course</td>" + 
                                                "<td>" + data.campaignList[i]['course_name'] + "</td>" +
                                            "</tr>" +
                                            "<tr>" + 
                                                "<td>Status</td>" + 
                                                "<td>" + data.campaignList[i]['campaign_status_name'] + "</td>" +
                                            "</tr>";
                        campaignViewId.html(campaignDetail);
                    }           
                }
            }
        });
    }

    function editAllowCampaign(campaignId) {
        $("#editAcceptModal").modal('show');
        $("#hdnCampId").val(campaignId);
    }

    function EditAcceptConfirm() {
        var campId = $("#hdnCampId").val();
        $.ajax({
            type:'get',
            url: "/edit-accept-campaign",
            data: {'campaignId' : campId},
            success:function(data){                
                if(data){
                    $.notify(data, {
                        showDuration: 2000,
                        className: 'success',
                    });
                    $("#editAcceptModal").modal('hide');
                    window.location.href="{{'it-admin-campaign'}}" 
                }
            }
        });
    }

</script>
@endsection