@extends('int-marketing-shared.int-master')

@section('int-content')
<div class="row mt-4">
    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 card-backgroundcolor">
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <h5>Campaigns</h5>                
                    </div>
                    <div class="col-lg-6 col-6 my-auto text-end">
                    <div class="dropdown float-lg-end pe-4">
                        <a class="btn btn-primary" id="createCampaignID" href="{{ url('int-campaign-download')}}">
                            <i class="fa fa-file-excel-o" style="font-size: small;">&nbsp; Export</i>                            
                        </a>                
                    </div>
                </div>                  
            </div>            
        </div>
        <div class="card-body px-1 pb-2">
            <div class="table-responsive">
            <table class="table align-items-center mb-1" id="campaignTable">
                <thead>
                    <tr>                                
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Institution</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Program Type</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Course</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Campaign Name</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Adset Name</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Ad Name</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Creative</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Leadsource</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Campaign Date</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Status</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Approval Status</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Approval Comments</th>
                        <th class="text-uppercase text-secondary text-left font-weight-bolder opacity-10">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($campaignList as $campaign)
                    <tr>
                        <td class="text-left">{{ $campaign->institution_name }}</td>
                        <td class="text-left">{{ $campaign->program_type_name }}</td>
                        <td class="text-left">{{ $campaign->course_name }}</td>
                        <td class="text-left">{{ $campaign->campaign_name }}</td>
                        <td class="text-left">{{ $campaign->adset_name }}</td>
                        <td class="text-left">{{ $campaign->adname }}</td>
                        <td class="text-left">{{ $campaign->creative }}</td>
                        <td class="text-left">{{ $campaign->leadsource_name }}</td>
                        <td class="text-left">{{ $campaign->campaign_date }}</td>
                        <td class="text-left">{{ $campaign->campaign_status_name }}</td>
                        <td class="text-left">
                            @if($campaign->camp_approval_id && $campaign->camp_approve == 1)
                                Yes 
                            @elseif($campaign->camp_approval_id && $campaign->camp_approve == 0)
                                No
                            @else 
                                Approval Pending 
                            @endif
                        </td>
                        <td class="text-left">@if($campaign->comments){{ $campaign->comments }} @endif</td>
                        <td class="text-left">
                            @if(!$campaign->camp_approval_id)
                                <button class="btn btn-success" id="btnViewId" onclick="approveCampaign({{ $campaign->campaign_id }});">Approval</button>
                            @endif
                            <button class="btn btn-primary" id="btnViewId" onclick="viewCampaign({{ $campaign->campaign_id }});">View</button>
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
<!-- View Campaign Modal -->
<div class="modal fade" id="viewCampaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Campaign</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <table class="table table-bordered" id="viewTableId">
            
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Approval Campaign Modal -->
<div class="modal fade" id="approvalCampaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Campaign Approval</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <input type="hidden" id="hdnCampId" name="hdnCampId" />
        <p id="descriptionId">Do you wish to approve the campaign?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="buttonId" title="Accept" onclick="acceptCampaign();">Accept</button>
        <button type="button" class="btn btn-danger" title="Reject" onclick="rejectCampaign();">Reject</button>
      </div>
    </div>
  </div>
</div>
<!-- Reject Comment Campaign Modal -->
<div class="modal fade" id="rejectCampaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Campaign Rejection</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <input type="hidden" id="hidnCampId" name="hidnCampId" />
        <div class="row">
            <div class="col-md-3">
                <label for="rejectCampComment">Reason</label>
                <span class="text-danger">*</span>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" name="rejectCampComment" id="rejectCampComment" cols="30" rows="5"></textarea>
                <span class="text-danger" id="rejectReasonValId"></span>
            </div>
        </div>
        <div class="row form-group mt-3">
            <div class="col-md-5">
              <button class="btn btn-primary" id="submit" title="submit" onclick="rejectCampaignComment();">Submit</button>
              <button data-bs-dismiss="modal" class="btn btn-danger" title="Cancel">Cancel</button>
            </div>                
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
<script src="https://cdn.tutorialjinni.com/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {        
        $("#intCampaignHomeID").removeClass( "active bg-gradient-primary" );
        $("#intLandingPageID").removeClass( "active bg-gradient-primary" );
        $("#intCampaignID").addClass( "active bg-gradient-primary" );
        $('#campaignTable').dataTable();          
    });

    function viewCampaign(id) {
        $.ajax({
          type:'get',
          url: "/int-view-campaign",
          data: {'campaignId' : id},
          success:function(data){
            if(data){                
               $("#viewCampaignModal").modal('show');
               var campaignTable = $("#viewTableId").empty();
               for(var i=0; i<data.campaignList.length; i++){
                   var items  = "<tr><td>Insititution</td><td>" + data.campaignList[i]['institution_name'] + "</td></tr>"+
                                "<tr><td>Program Type</td><td>" + data.campaignList[i]['program_type_name'] + "</td></tr>"+
                                "<tr><td>Course</td><td>" + data.campaignList[i]['course_name'] + "</td></tr>"+
                                "<tr><td>Campaign Name</td><td>" + data.campaignList[i]['campaign_name'] + "</td></tr>"+
                                "<tr><td>Adset Name</td><td>" + data.campaignList[i]['adset_name'] +"</td></tr>" + 
                                "<tr><td>Ad Name</td><td>" + data.campaignList[i]['adname'] + "</td></tr>" + 
                                "<tr><td>Creative</td><td>" + data.campaignList[i]['creative'] + "</td></tr>" + 
                                "<tr><td>Leadsource</td><td>"+ data.campaignList[i]['leadsource_name'] +"</td></tr>" +
                                "<tr><td>Campaign Date</td><td>" + data.campaignList[i]["campaign_date"] + "</td></tr>" +
                                "<tr><td>Campaign Status</td><td>" + data.campaignList[i]["campaign_status_name"] + "</td></tr>" +
                                "<tr><td>Campaign Approval Status</td><td>" + data.campaignList[i]["campaign_size"] + "</td></tr>" +
                                "<tr><td>Campaign Approval Comment</td><td>" + data.campaignList[i]["approval_date"] + "</td></tr>";
                   campaignTable.append(items);
               }
            }
          }
      });
    }

    function approveCampaign(id) {
      $("#approvalCampaignModal").modal('show');
      $("#hdnCampId").val(id);
    }

    function rejectCampaign() {
      $("#approvalCampaignModal").modal('hide');
      $("#rejectCampaignModal").modal('show');
      $("#hidnCampId").val($("#hdnCampId").val());
    }

    function acceptCampaign() {
      var campaignId = $("#hdnCampId").val();
      $.ajax({
          type:'get',
          url: "/accept-campaign",
          data: {'campaignId' : campaignId},
          success:function(data){           
            if(data != ""){              
              $.notify(data, "success");              
              setTimeout(() => { window.location.href="{{'int-campaign'}}"}, 2000);
            }
          }          
      });
    }

    function rejectCampaignComment() {
      
      var campaignId = $("#hidnCampId").val();
      var comment = $("#rejectCampComment").val();
      if(comment == "") {
        $("#rejectReasonValId").empty().text("Please enter the reason");
        return false;
      }
      else {
        $.ajax({
            type:'get',
            url: "/reject-campaign",
            data: {'campaignId' : campaignId, 'comment' : comment},
            success:function(data){            
              if(data != ""){              
                $("#rejectCampaignModal").modal('hide');
                $.notify(data, "success");
                setTimeout(() => { window.location.href="{{'int-campaign'}}"}, 2000);
              }
            }          
        });
      }
    }

</script>
@endsection