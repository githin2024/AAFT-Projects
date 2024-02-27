@extends('ext-marketing.ext-master')

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 card-backgroundcolor">
                <div class="row">
                    <div class="col-lg-6 col-6">
                    <h5 id="campaign-title"></h5>  
                    </div>    
                </div>
            </div>
            <div class="card-body px-1 pb-2">
                <form name="add-campaign" id="add-campaign" method="post" action="store-campaign">
                    @csrf
                    <div class="row form-group">
                    <div class="col-md-3 float-end">
                        <label class="form-label" for="campaign-institution">Institution</label>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-6">
                        <select name="campaign-institution" class="form-control" id="campaign-institution" onchange="getCourses();"> 
                            <option value="">--Select---</option>
                            @foreach($institutions as $institution)
                                <option value="{{$institution->institution_code}}">{{$institution->institution_name}}</option>
                            @endforeach                 
                        </select>                
                        <span id="institution-error" class="text-danger"></span>
                    </div>
                    </div>
                    <div class="row form-group mt-2">
                    <div class="col-md-3 text-right">
                        <label class="form-label" for="programType">Program Type</label>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-6">
                        <select name="programType" class="form-control" id="programType">
                            <option value="">--Select--</option>
                            @foreach($programTypes as $programType)
                                <option value="{{$programType->program_code}}">{{$programType->program_type_name}}</option>
                            @endforeach                  
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
                            <option value="">--Select--</option>
                            @foreach($marketingAgencies as $marketingAgency)
                                <option value="{{$marketingAgency->agency_code}}">{{$marketingAgency->agency_name}}</option>
                            @endforeach                  
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
                            <option value="">--Select--</option>
                            @foreach($leadSources as $leadSource)
                                <option value="{{$leadSource->leadsource_id}}">{{$leadSource->leadsource_name}}</option>
                            @endforeach                  
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
                            <option value="">--Select--</option>
                            @foreach($targetLocations as $targetLocation)
                                <option value="{{$targetLocation->target_location_code}}">{{$targetLocation->target_location_name}}</option>
                            @endforeach                
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
                            <option value="">--Select--</option>
                            @foreach($personas as $persona)
                                <option value="{{$persona->persona_code}}">{{$persona->persona_name}}</option>
                            @endforeach             
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
                            <option value="">--Select--</option>
                            @foreach($prices as $price)
                                <option value="{{$price->campaign_price_code}}">{{$price->campaign_price_name}}</option>
                            @endforeach                 
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
                            <option value="">--Select--</option>
                            @foreach($headlines as $headline)
                                <option value="{{$headline->headline_code}}">{{$headline->headline_name}}</option>
                            @endforeach                  
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
                            <option value="">--Select--</option>
                            @foreach($targetSegments as $targetSegment)
                                <option value="{{$targetSegment->target_segment_code}}">{{$targetSegment->target_segment_name}}</option>
                            @endforeach
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
                            <option value="">--Select--</option>
                            @foreach($campaignTypes as $campaignType)
                                <option value="{{$campaignType->campaign_type_code}}">{{$campaignType->campaign_type_name}}</option>
                            @endforeach                
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
                            <option value="">--Select--</option>
                            @foreach($campaignSizes as $campaignSize)
                                <option value="{{$campaignSize->campaign_size_code}}">{{$campaignSize->campaign_size_name}}</option>
                            @endforeach
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
                            <option value="">--Select--</option>
                            @foreach($campaignVersions as $campaignVersion)
                                <option value="{{$campaignVersion->campaign_version_code}}">{{$campaignVersion->campaign_version_name}}</option>
                            @endforeach
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
        $("campaign-title").empty().html("Create Campaign");      
    });
    
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
      if(programType == "" || programType == "undefined"){
        $("#programType-error").html("Please select a Program Type");        
      }
      if(marketingAgency == "" || marketingAgency == "undefined"){
        $("#marketingAgency-error").html("Please select a Marketing Agency");        
      }
      if(leadSource == "" || leadSource == "undefined"){
        $("#leadSource-error").html("Please select a Lead Source");        
      }
      if(targetLocation == "" || targetLocation == "undefined"){
        $("#targetLocation-error").html("Please select a Target Location");        
      }
      if(persona == "" || persona == "undefined"){
        $("#persona-error").html("Please select a Persona");        
      }
      if(price == "" || price == "undefined"){
        $("#price-error").html("Please select a Price");        
      }
      if(courses == "" && institution == ""){
        $("#courses-error").html("Please select an institution first");        
      }
      if(courses == "" || courses == "undefined"){
        $("#courses-error").html("Please select a Course");        
      }
       if(campDate == "" || campDate == "undefined"){
        $("#campaignDate-error").html("Please select a Date");        
      }
      if(headline == "" || headline == "undefined"){
        $("#headline-error").html("Please select a Headline");        
      }
      if(targetSegment == "" || targetSegment == "undefined"){
        $("#targetSegment-error").html("Please select a Target Segment");        
      }
      if(campaignType == "" || campaignType == "undefined"){
        $("#campaignType-error").html("Please select a Type");        
      }
      if(campaignSize == "" || campaignSize == "undefined"){
        $("#campaignSize-error").html("Please select a Size");        
      }
      if(campaignVersion == "" || campaignVersion == "undefined"){
        $("#campaignVersion-error").html("Please select a Version");        
      }
      
      if($("#institution-error").text() != "" || $("#programType-error").text() != "" || $("#campaignVersion-error").text() != "" || $("#campaignSize-error").text() != ""
        || $("#campaignType-error").text() != "" || $("#targetSegment-error").text() != "" || $("#headline-error").text() != "" || $("#campaignDate-error").text() != ""
        || $("#courses-error").text() != "" || $("#marketingAgency-error").text() != "" || $("#leadSource-error").text() != "" || $("#targetLocation-error").text() != ""
        || $("#persona-error").text() != "" || $("#price-error").text() != ""){
          return false;
        }
    }

    // function createCampaign() {
    //     $("#exampleModalLabel").html("Create New Campaign");
    //     $("#createCampaignModal").modal("show");
    //     $.ajax({
    //         type:'get',
    //         url: "/create-campaign",
    //         success:function(data){
    //             if(data){                    
    //                 var institutionId = $("#campaign-institution").empty();
    //                 institutionId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < Object.keys(data['institution']).length;i++){
    //                     var institution_item_el = '<option value="'+data.institution[i]['institution_code']+'">'+data.institution[i]['institution_name']+'</option>';
    //                     institutionId.append(institution_item_el);
    //                 }
                    
    //                 var programTypeId = $("#programType").empty();
    //                 programTypeId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.programType.length;i++){
    //                     var programType_item_el = '<option value="'+ data.programType[i]['program_code'] +'">'+data.programType[i]['program_type_name']+'</option>';
    //                     programTypeId.append(programType_item_el);
    //                 }

    //                 var marketingAgencyId = $("#marketingAgency").empty();
    //                 marketingAgencyId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.marketingAgency.length;i++){
    //                     var marketingAgency_item_el = '<option value="'+ data.marketingAgency[i]['agency_code'] +'">'+data.marketingAgency[i]['agency_name']+'</option>';
    //                     marketingAgencyId.append(marketingAgency_item_el);
    //                 }

    //                 var leadSourceId = $("#leadSource").empty();
    //                 leadSourceId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.leadSource.length;i++){
    //                     var leadSource_item_el = '<option value="'+ data.leadSource[i]['leadsource_id'] +'">'+ data.leadSource[i]['leadsource_name']+'</option>';
    //                     leadSourceId.append(leadSource_item_el);
    //                 }

    //                 var targetLocationId = $("#targetLocation").empty();
    //                 targetLocationId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.targetLocation.length;i++){
    //                     var targetLocation_item_el = '<option value="'+ data.targetLocation[i]['target_location_code'] +'">'+ data.targetLocation[i]['target_location_name']+'</option>';
    //                     targetLocationId.append(targetLocation_item_el);
    //                 }

    //                 var personaId = $("#persona").empty();
    //                 personaId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.persona.length;i++){
    //                     var persona_item_el = '<option value="'+ data.persona[i]['persona_code'] +'">'+ data.persona[i]['persona_name']+'</option>';
    //                     personaId.append(persona_item_el);
    //                 }

    //                 var priceId = $("#price").empty();
    //                 priceId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.price.length;i++){
    //                     var price_item_el = '<option value="'+ data.price[i]['campaign_price_code'] +'">'+ data.price[i]['campaign_price_name']+'</option>';
    //                     priceId.append(price_item_el);
    //                 }

    //                 var headlineId = $("#headline").empty();
    //                 headlineId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.headline.length;i++){
    //                     var headline_item_el = '<option value="'+ data.headline[i]['headline_code'] +'">'+ data.headline[i]['headline_name']+'</option>';
    //                     headlineId.append(headline_item_el);
    //                 }

    //                 var targetSegmentId = $("#targetSegment").empty();
    //                 targetSegmentId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.targetSegment.length;i++){
    //                     var targetSegment_item_el = '<option value="'+ data.targetSegment[i]['target_segment_code'] +'">'+ data.targetSegment[i]['target_segment_name']+'</option>';
    //                     targetSegmentId.append(targetSegment_item_el);
    //                 }

    //                 var campaignTypeId = $("#campaignType").empty();
    //                 campaignTypeId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.campaignType.length;i++){
    //                     var campaignType_item_el = '<option value="'+ data.campaignType[i]['campaign_type_code'] +'">'+ data.campaignType[i]['campaign_type_name']+'</option>';
    //                     campaignTypeId.append(campaignType_item_el);
    //                 }

    //                 var campaignSizeId = $("#campaignSize").empty();
    //                 campaignSizeId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.campaignSize.length;i++){
    //                     var campaignSize_item_el = '<option value="'+ data.campaignSize[i]['campaign_size_code'] +'">'+ data.campaignSize[i]['campaign_size_name']+'</option>';
    //                     campaignSizeId.append(campaignSize_item_el);
    //                 }

    //                 var campaignVersionId = $("#campaignVersion").empty();
    //                 campaignVersionId.append('<option selected="selected" value="">--Select--</option>');
    //                 for(var i = 0; i < data.campaignVersion.length;i++){
    //                     var campaignVersion_item_el = '<option value="'+ data.campaignVersion[i]['campaign_version_code'] +'">'+ data.campaignVersion[i]['campaign_version_name']+'</option>';
    //                     campaignVersionId.append(campaignVersion_item_el);
    //                 }
    //             }
    //         }
    //     });
    // }
</script>
@endsection

