@extends('ext-marketing.ext-master')

@section('content')
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
                        <a class="btn btn-primary" id="createCampaignID" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="createCampaign()">
                            <i class="fa fa-plus" style="font-size: small;"> &nbsp;Create</i>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Institution</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Program Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Campaign</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Lead Source</th>
                    <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Course</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Campaign Status</th> -->
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Material XD Version</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                        <img src="../assets/img/team-1.jpg" alt="team1">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                        <img src="../assets/img/team-2.jpg" alt="team2">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                        <img src="../assets/img/team-3.jpg" alt="team3">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                        <img src="../assets/img/team-4.jpg" alt="team4">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> $14,000 </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">60%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-atlassian.svg" class="avatar avatar-sm me-3" alt="atlassian">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Add Progress Track</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                        <img src="../assets/img/team-2.jpg" alt="team5">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                        <img src="../assets/img/team-4.jpg" alt="team6">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> $3,000 </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">10%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-info w-10" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm me-3" alt="team7">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Fix Platform Errors</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                        <img src="../assets/img/team-3.jpg" alt="team8">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                        <img src="../assets/img/team-1.jpg" alt="team9">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> Not set </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">100%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm me-3" alt="spotify">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Launch our Mobile App</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                        <img src="../assets/img/team-4.jpg" alt="user1">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                        <img src="../assets/img/team-3.jpg" alt="user2">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                        <img src="../assets/img/team-4.jpg" alt="user3">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                        <img src="../assets/img/team-1.jpg" alt="user4">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> $20,500 </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">100%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm me-3" alt="jira">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Add the New Pricing Page</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                        <img src="../assets/img/team-4.jpg" alt="user5">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> $500 </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">25%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-info w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm me-3" alt="invision">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Redesign New Online Shop</h6>
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="avatar-group mt-2">
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                        <img src="../assets/img/team-1.jpg" alt="user6">
                        </a>
                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                        <img src="../assets/img/team-4.jpg" alt="user7">
                        </a>
                    </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> $2,000 </span>
                    </td>
                    <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-xs font-weight-bold">40%</span>
                        </div>
                        </div>
                        <div class="progress">
                        <div class="progress-bar bg-gradient-info w-40" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="40"></div>
                        </div>
                    </div>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>        
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form name="add-campaign" id="add-campaign" method="post" action="store-campaign">
            @csrf
            <div class="row form-group">
              <div class="col-md-3">
                <label class="form-label" for="campaign-institution">Institution</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaign-institution" required class="form-control" id="campaign-institution" onchange="getCourses();">                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="programType">Program Type</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="programType" class="form-control" required id="programType">                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="marketingAgency">Marketing Agency</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="marketingAgency" class="form-control" required id="marketingAgency">
                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="leadSource">Lead Source</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="leadSource" class="form-control" required id="leadSource">
                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="targetLocation">Target Location</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="targetLocation" class="form-control" required id="targetLocation">
                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="persona">Persona</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="persona" class="form-control" required id="persona">
                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="price">Price</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="price" class="form-control" required id="price">
                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="courses">Courses</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="courses" class="form-control" required id="courses">
                  <option value="">--Select--</option>
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignDate">Date</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <input type="date" name="campaignDate" required class="form-control" id="campaignDate" />
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="headline">Headline</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="headline" class="form-control" required id="headline">                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="targetSegment">Target Segment</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="targetSegment" class="form-control" required id="targetSegment">
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignType">Type</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignType" class="form-control" required id="campaignType">                  
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignSize">Size</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignSize" class="form-control" required id="campaignSize">
                </select>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignVersion">Version</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignVersion" class="form-control" required id="campaignVersion">
                </select>
              </div>
            </div>
            <hr />
            <div class="row form-group mt-2">
              <div class="col-md-5">
                <button type="submit" class="btn btn-primary" id="generate" title="Generate">Generate</button>
                <button data-bs-dismiss="modal" class="btn btn-danger" title="Cancel">Cancel</button>
              </div>
            </div>
            <div class="row mt-2">
              
                @if ($errors->any())
                  <ul class="m-3">
                      @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                      @endforeach
                  </ul>
                @endif
              
            </div>
          </form>
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
        $("#extCampaignID").addClass( "active bg-gradient-primary" );
        $("#extCampaignHomeID").removeClass( "active bg-gradient-primary" );
        $('#campaignTable').dataTable();
    });

    // function generateCampaign() {
    //     debugger;
    //     $("#campaignDate").val();
    // }
    
    function createCampaign() {
        $("#exampleModalLabel").html("Create New Campaign");
        $.ajax({
            type:'get',
            url: "/create-campaign",
            success:function(data){
                if(data){                    
                    var institutionId = $("#campaign-institution").empty();
                    institutionId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < Object.keys(data['institution']).length;i++){
                        var institution_item_el = '<option value="'+data.institution[i]['institution_code']+'">'+data.institution[i]['institution_name']+'</option>';
                        institutionId.append(institution_item_el);
                    }
                    
                    var programTypeId = $("#programType").empty();
                    programTypeId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.programType.length;i++){
                        var programType_item_el = '<option value="'+ data.programType[i]['program_code'] +'">'+data.programType[i]['program_type_name']+'</option>';
                        programTypeId.append(programType_item_el);
                    }

                    var marketingAgencyId = $("#marketingAgency").empty();
                    marketingAgencyId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.marketingAgency.length;i++){
                        var marketingAgency_item_el = '<option value="'+ data.marketingAgency[i]['agency_code'] +'">'+data.marketingAgency[i]['agency_name']+'</option>';
                        marketingAgencyId.append(marketingAgency_item_el);
                    }

                    var leadSourceId = $("#leadSource").empty();
                    leadSourceId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.leadSource.length;i++){
                        var leadSource_item_el = '<option value="'+ data.leadSource[i]['leadsource_id'] +'">'+ data.leadSource[i]['leadsource_name']+'</option>';
                        leadSourceId.append(leadSource_item_el);
                    }

                    var targetLocationId = $("#targetLocation").empty();
                    targetLocationId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.targetLocation.length;i++){
                        var targetLocation_item_el = '<option value="'+ data.targetLocation[i]['target_location_code'] +'">'+ data.targetLocation[i]['target_location_name']+'</option>';
                        targetLocationId.append(targetLocation_item_el);
                    }

                    var personaId = $("#persona").empty();
                    personaId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.persona.length;i++){
                        var persona_item_el = '<option value="'+ data.persona[i]['persona_code'] +'">'+ data.persona[i]['persona_name']+'</option>';
                        personaId.append(persona_item_el);
                    }

                    var priceId = $("#price").empty();
                    priceId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.price.length;i++){
                        var price_item_el = '<option value="'+ data.price[i]['campaign_price_code'] +'">'+ data.price[i]['campaign_price_name']+'</option>';
                        priceId.append(price_item_el);
                    }

                    var headlineId = $("#headline").empty();
                    headlineId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.headline.length;i++){
                        var headline_item_el = '<option value="'+ data.headline[i]['headline_code'] +'">'+ data.headline[i]['headline_name']+'</option>';
                        headlineId.append(headline_item_el);
                    }

                    var targetSegmentId = $("#targetSegment").empty();
                    targetSegmentId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.targetSegment.length;i++){
                        var targetSegment_item_el = '<option value="'+ data.targetSegment[i]['target_segment_code'] +'">'+ data.targetSegment[i]['target_segment_name']+'</option>';
                        targetSegmentId.append(targetSegment_item_el);
                    }

                    var campaignTypeId = $("#campaignType").empty();
                    campaignTypeId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.campaignType.length;i++){
                        var campaignType_item_el = '<option value="'+ data.campaignType[i]['campaign_type_code'] +'">'+ data.campaignType[i]['campaign_type_name']+'</option>';
                        campaignTypeId.append(campaignType_item_el);
                    }

                    var campaignSizeId = $("#campaignSize").empty();
                    campaignSizeId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.campaignSize.length;i++){
                        var campaignSize_item_el = '<option value="'+ data.campaignSize[i]['campaign_size_code'] +'">'+ data.campaignSize[i]['campaign_size_name']+'</option>';
                        campaignSizeId.append(campaignSize_item_el);
                    }

                    var campaignVersionId = $("#campaignVersion").empty();
                    campaignVersionId.append('<option selected="selected" value="">--Select--</option>');
                    for(var i = 0; i < data.campaignVersion.length;i++){
                        var campaignVersion_item_el = '<option value="'+ data.campaignVersion[i]['campaign_version_code'] +'">'+ data.campaignVersion[i]['campaign_version_name']+'</option>';
                        campaignVersionId.append(campaignVersion_item_el);
                    }
                }
            }
        });
    }

</script>
@endsection