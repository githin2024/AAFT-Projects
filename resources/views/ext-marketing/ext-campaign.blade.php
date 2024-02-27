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
                        <a class="btn btn-primary" id="createCampaignID" onclick="createCampaign();">
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
<div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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
                <select name="campaign-institution" class="form-control" id="campaign-institution" onchange="getCourses();">                  
                </select>                
                <span id="institution-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="programType">Program Type</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="programType" class="form-control" id="programType">                  
                </select>                
                <span id="programType-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="marketingAgency">Marketing Agency</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="marketingAgency" class="form-control" id="marketingAgency">                  
                </select>                
                <span id="marketingAgency-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="leadSource">Lead Source</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="leadSource" class="form-control" id="leadSource">                  
                </select>                
                <span id="leadSource-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="targetLocation">Target Location</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="targetLocation" class="form-control" id="targetLocation">                  
                </select>                
                <span id="targetLocation-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="persona">Persona</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="persona" class="form-control" id="persona">                  
                </select>                
                <span id="persona-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="price">Price</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="price" class="form-control" id="price">                  
                </select>                
                <span id="price-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="courses">Courses</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="courses" class="form-control" id="courses">
                  <option value="">--Select--</option>
                </select>                
                <span id="courses-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignDate">Date</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <input type="date" name="campaignDate" class="form-control" id="campaignDate" />                
                <span id="campaignDate-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="headline">Headline</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="headline" class="form-control" id="headline">                  
                </select>                
                <span id="headline-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="targetSegment">Target Segment</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="targetSegment" class="form-control" id="targetSegment">
                </select>                
                <span id="targetSegment-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignType">Type</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignType" class="form-control" id="campaignType">                  
                </select>                
                <span id="campaignType-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignSize">Size</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignSize" class="form-control" id="campaignSize">
                </select>                
                <span id="campaignSize-error" class="text-danger"></span>
              </div>
            </div>
            <div class="row form-group mt-2">
              <div class="col-md-3">
                <label class="form-label" for="campaignVersion">Version</label>
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-7">
                <select name="campaignVersion" class="form-control" id="campaignVersion">
                </select>                
                <span id="campaignVersion-error" class="text-danger"></span>
              </div>
            </div>
            <hr />
            <div class="row form-group mt-2">
              <div class="col-md-5">
                <button type="submit" class="btn btn-primary" id="generate" title="Generate" onclick="VerifyCampaign();">Generate</button>
                <button data-bs-dismiss="modal" class="btn btn-danger" title="Cancel">Cancel</button>
              </div>
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

    function createCampaign() {
      window.location.href = "{{ url('create-campaign')}}"; 
    }

</script>
@endsection