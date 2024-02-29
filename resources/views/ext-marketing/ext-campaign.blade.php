@extends('ext-marketing.ext-master')

@section('content')
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
                        <a class="btn btn-primary" id="createCampaignID" onclick="createCampaign();" title="Create">
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
                        @if(is_null($campaign->camp_param_check_id))
                          <button type="button" class="btn btn-info" title="Parameter Check" onclick="parameterCheckCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">Parameter Check</span></button>
                        @elseif(is_null($campaign->lead_request_id))
                          <button type="button" class="btn btn-info" title="Lead Request" onclick="leadRequestCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">Lead Request</span></button>
                        @endif
                        @if(is_null($campaign->camp_edit_request_id) && $campaign->Edit_Active == 0 && $campaign->Lead_Active == 1 && is_null($campaign->camp_delete_request_id))
                          <button type="button" class="btn btn-warning" title="Edit Request" onclick="editRequestCampaign({{ $campaign->campaign_id }})"><span style="font-size:12px;">Edit Request</span></button>
                          <button type="button" class="btn btn-danger" title="Delete Request" onclick="deleteRequestCampaing({{ $campaign->campaign_id }})"><span style="font-size:12px;">Delete Request</span></button>
                        @elseif(!is_null($campaign->camp_edit_request_id) && $campaign->Edit_Active == 0 && $campaign->Lead_Active == 1 && is_null($campaign->camp_delete_request_id))
                          <button type="button" class="btn btn-warning" title="Edit Campaign" onclick="editCampaign({{ $campaign->campaign_id }})"><i class="fa fa-pencil-square-o">&nbsp;Edit</i></button>
                        @elseif(!is_null($campaign->camp_delete_request_id))
                          <button type="button" class="btn btn-danger" title="Delete Campaign" onclick="deleteCampaign({{ $campaign->campaign_id }})"><i class="fa fa-trash-o">&nbsp;Delete</i></button>
                        @endif
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
<!-- Crete Campaign Modal -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form name="add-campaign" id="add-campaign" method="post" action="{{ url('store-campaign') }}">
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
              <button class="btn btn-primary" id="generate" title="Generate" onclick="VerifyCampaign();">Generate</button>
              <button data-bs-dismiss="modal" class="btn btn-danger" title="Cancel">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Parameter Check Modal -->
<div class="modal fade" id="parameterCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Parameter Check</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="parameter-check" name="parameter-check" method="post" action="{{ url('parameter-campaign') }}">
          @csrf
          <input type="hidden" name="campaignId" id="campaignId" />
          <div class="row form-group">
            <div class="col-md-2 text-end">
              <input type="checkbox" id="published" name="published" />                          
            </div>
            <div class="col-md-8">
              <label class="form-label" for="published">Is the form published</label>
              <span class="text-danger">*</span>
              <br />
              <span id="published-error" class="text-danger"></span>                
            </div>
          </div>
          <div class="row form-group mt-2">
            <div class="col-md-2 text-end">
              <input type="checkbox" id="course-campaign" name="course-campaign" />              
            </div>
            <div class="col-md-8">
              <label class="form-label" for="course-campaign">Is the course integrated in the form</label>
              <span class="text-danger">*</span>
              <br />
              <span id="course-campaign-error" class="text-danger"></span>
            </div>
          </div>          
          <hr />
          <div class="row form-group mt-2">
            <div class="col-md-5">
              <button class="btn btn-primary" type="submit" id="confirmParameterCheck" title="Confirm" onclick="VerifyParameter();">Confirm</button>
              <button data-bs-dismiss="modal" class="btn btn-danger" title="Cancel">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Lead Generation Confirmation Modal -->
<div class="modal fade" id="confirmLeadModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lead Generation Confirmation</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hdnCampaignId" name="hdnCampaignId" />
        <p>Do you wish to confirm the lead generation is initiated? </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="confirmLeadGenration" title="Confirm Lead Generation" onclick="ConfirmLead();">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        $("#extCampaignID").addClass( "active bg-gradient-primary" );
        $("#extCampaignHomeID").removeClass( "active bg-gradient-primary" );
        $('#campaignTable').dataTable();
        if($("#successMesgID").text() !="") {
          $.notify($("#successMesgID").text(), "success");          
        }
    });

    function createCampaign() {
        $("#exampleModalLabel").html("Create New Campaign");
        $("#createCampaignModal").modal('show');
        $("#institution-error").html(''); 
        $("#programType-error").html(''); 
        $("#campaignVersion-error").html('');
        $("#campaignSize-error").html('');
        $("#campaignType-error").html('');
        $("#targetSegment-error").html('');
        $("#headline-error").html('');
        $("#campaignDate-error").html('');
        $("#courses-error").html(''); 
        $("#marketingAgency-error").html('');
        $("#leadSource-error").html('');
        $("#targetLocation-error").html('');
        $("#persona-error").html('');
        $("#price-error").html(''); 
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

    function VerifyCampaign() {      
      
      var institution = $("#campaign-institution").val();
      var programType = $("#programType").val();
      var marketingAgency = $("#marketingAgency").val();
      var leadSource = $("#leadSource").val();
      var targetLocation = $("#targetLocation").val();
      var persona = $("#persona").val();
      var price = $("#price").val();
      var courses = $("#courses").val();
      var campDate = $("#campaignDate").val();
      var headline = $("#headline").val();
      var targetSegment = $("#targetSegment").val();
      var campaignType = $("#campaignType").val();
      var campaignSize = $("#campaignSize").val();
      var campaignVersion = $("#campaignVersion").val();
      
      if(institution == "" || institution == "undefined"){
        $("#institution-error").html("Please select an Institution");         
      }
      else {
        $("#institution-error").html(""); 
      }
      if(programType == "" || programType == "undefined"){
        $("#programType-error").html("Please select a Program Type");        
      }
      else {
        $("#programType-error").html("");
      }
      if(marketingAgency == "" || marketingAgency == "undefined"){
        $("#marketingAgency-error").html("Please select a Marketing Agency");        
      }
      else {
        $("#marketingAgency-error").html("");
      }
      if(leadSource == "" || leadSource == "undefined"){
        $("#leadSource-error").html("Please select a Lead Source");        
      }
      else {
        $("#leadSource-error").html("");
      }
      if(targetLocation == "" || targetLocation == "undefined"){
        $("#targetLocation-error").html("Please select a Target Location");        
      }
      else {
        $("#targetLocation-error").html("");
      }
      if(persona == "" || persona == "undefined"){
        $("#persona-error").html("Please select a Persona");        
      }
      else {
        $("#persona-error").html("");
      }
      if(price == "" || price == "undefined"){
        $("#price-error").html("Please select a Price");        
      }
      else {
        $("#price-error").html("");
      }
      if(courses == "" && institution == ""){
        $("#courses-error").html("Please select an institution first");        
      }
      else {
        $("#courses-error").html("");
      }
      if(courses == "" || courses == "undefined"){
        $("#courses-error").html("Please select a Course");        
      }
      else {
        $("#courses-error").html("");
      }
       if(campDate == "" || campDate == "undefined"){
        $("#campaignDate-error").html("Please select a Date");        
      }
      else {
        $("#campaignDate-error").html("");
      }
      if(headline == "" || headline == "undefined"){
        $("#headline-error").html("Please select a Headline");        
      }
      else {
        $("#headline-error").html("");
      }
      if(targetSegment == "" || targetSegment == "undefined"){
        $("#targetSegment-error").html("Please select a Target Segment");        
      }
      else {
        $("#targetSegment-error").html("");
      }
      if(campaignType == "" || campaignType == "undefined"){
        $("#campaignType-error").html("Please select a Type");        
      }
      else {
        $("#campaignType-error").html("");
      }
      if(campaignSize == "" || campaignSize == "undefined"){
        $("#campaignSize-error").html("Please select a Size");        
      }
      else {
        $("#campaignSize-error").html("");
      }
      if(campaignVersion == "" || campaignVersion == "undefined"){
        $("#campaignVersion-error").html("Please select a Version");        
      }
      else {
        $("#campaignVersion-error").html("");
      }
      $("#add-campaign").submit(function (e) {
        if($("#institution-error").text() != "" || $("#programType-error").text() != "" || $("#campaignVersion-error").text() != "" || $("#campaignSize-error").text() != ""
        || $("#campaignType-error").text() != "" || $("#targetSegment-error").text() != "" || $("#headline-error").text() != "" || $("#campaignDate-error").text() != ""
        || $("#courses-error").text() != "" || $("#marketingAgency-error").text() != "" || $("#leadSource-error").text() != "" || $("#targetLocation-error").text() != ""
        || $("#persona-error").text() != "" || $("#price-error").text() != ""){
          e.preventDefault();
          return false;
        }
      }); 
          
    }

    function parameterCheckCampaign(campaignID) {
      $("#parameterCheckModal").modal('show');
      $("#campaignId").val(campaignID); 
      $("#published-error").text(''); 
      $("#course-campaign-error").text('');
      $("#published").prop('checked', false); 
      $("#course-campaign").prop('checked', false);
    }

    function VerifyParameter() {
      if($("#published").prop('checked') == false ){
        $("#published-error").text('Please select form is published');
      }
      else {
        $("#published-error").text('');
        $("#published").val(true);
      }
      
      if($("#course-campaign").prop('checked') == false ){
        $("#course-campaign-error").text('Please select course is integrated');
      }
      else {
        $("#course-campaign-error").text('');
        $("#course-campaign").val(true);
      }
      
      $("#parameter-check").submit(function (e) { 
        if ($("#course-campaign-error").text() != "" || $("#published-error").text() != "") {
          e.preventDefault();
          return false;
        }
      }); 
    }

    function campNotify() {
      $("#successMesgID").hide();
    }

    function leadRequestCampaign(campaignId) {
      $("#confirmLeadModal").modal('show');
      $("#hdnCampLeadId").val(campaignId);
    }

    function ConfirmLead(){
      var campId = $("#hdnCampLeadId").val();
      $.ajax({
          type:'post',
          url: "/confirm-lead",
          data: {'campaignId' : campId},
          success:function(data){
            if(data){
              console.log(data);
            }
          }
      });
    }
    
</script>
@endsection