@extends('int-marketing-shared.int-master')

@section('int-content')
@if(session()->has('message'))
  <div class="alert alert-success" id="successMesgID" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false" style="display: none">
    {{ session()->get('message') }}
    <button type="button" onclick="campNotify();" class="btn-close" style="float: right;" aria-label="Close"></button>
  </div>
@endif
<div class="row mt-4">
    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 card-backgroundcolor">
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <h5>Landing Page</h5>                
                    </div>
                    <div class="col-lg-6 col-6 my-auto text-end">
                      <div class="dropdown float-lg-end pe-4">
                          <a class="btn btn-primary" id="createCampaignID" onclick="editLandingPage(0);" href="{{ url('int-create-landing-page/0') }}">
                              <i class="fa fa-plus" style="font-size: small;">&nbsp; Create</i>                            
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Course</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Title</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Description</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Assigne</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Assigner</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Development Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Issue</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Priority</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Action</th> 
                </tr>
                </thead>
                <tbody>
                  @foreach($landingPageList as $landingPage)
                    <tr>
                        <td>{{ $landingPage->institution_name }}</td>
                        <td>{{ $landingPage->course_name }}</td>
                        <td>{{ $landingPage->title }}</td>
                        <td>{{ $landingPage->description }}</td>
                        <td>{{ $landingPage->assignee }}</td>
                        <td>{{ $landingPage->assigner }}</td>
                        <td>{{ $landingPage->development_type_name }}</td>
                        <td>{{ $landingPage->issue_name }}</td>
                        <td>{{ $landingPage->priority_name }}</td>
                        <td>{{ $landingPage->lp_status }}</td>
                        <td><a class="btn btn-primary" id="btnEditId" href="{{ url('int-create-landing-page/'. $landingPage->landing_page_id) }}"><i class="fa fa-pencil" style="font-size: small;">&nbsp;Edit</i></a></td>
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
<script src="https://cdn.tutorialjinni.com/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {        
        $("#intCampaignHomeID").removeClass( "active bg-gradient-primary" );
        $("#intLandingPageID").addClass( "active bg-gradient-primary" );
        $("#intCampaignID").removeClass( "active bg-gradient-primary" );   
        if($("#successMesgID").text() !="") {
          $.notify($("#successMesgID").text(), "success");           
        }       
    });

    function getLandingPageCourses(){
      
        var institutionId = $("#landing-page-institution").val();
        $.ajax({
            type:'get',
            url: "/get-courses",
            data: {'institutionId' : institutionId},
            success:function(data) {
              if(data) {
                var courses = $("#landing-page-course").empty();
                courses.append("<option value=''>--Select--</option>");
                for(var i=0; i<data.courseList.length; i++){
                  var course_item_el = '<option value="'+ data.courseList[i]['course_id']+'">'+ data.courseList[i]['course_name'] +'</option>';
                  courses.append(course_item_el);
                }
              }    
            }
        });
    }

    function editLandingPage(lpId) {
      
      $.ajax({
        type:'get',
        url:"/int-create-landing-page",
        data: {'lpId' : lpId}
      });
    }

    function CreateLandingPage(lpId) {
      $("#createLandingPageModal").modal('show');
      $.ajax({
            type:'get',
            url: "/create-landing-page",
            data: {'lpId' : lpId},
            success:function(data)
            {                                                
                if(lpId == 0)
                {
                  $("#landing-page-id").val(lpId);
                  $("#institution-error").html(''); 
                  $("#course-error").html(''); 
                  $("#title-error").html('');
                  $("#description-error").html('');
                  $("#assignee-error").html('');
                  $("#assigner-error").html('');
                  $("#developmentType-error").html('');
                  $("#issue-error").html('');
                  $("#priority-error").html(''); 
                  $("#status-error").html('');
                  $("#landing-page-title").val('');
                  $("#description").val('');
                  $("#attach").val('');
                  if(lpId == 0){
                    $("#exampleModalLabel").html("Create New Landing Page");                                       
                  }
                  else {
                    $("#exampleModalLabel").html("Edit Landing Page");
                    $("#landing-page-title").val(data.landingPageList[0]['title']);
                    $("#description").val(data.landingPageList[0]['description']);
                    //$("#attach").val(data.landingPageList[0]['file_name']);
                  }
                  var landingPageInstitution = $("#landing-page-institution").empty();
                  landingPageInstitution.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.institutionList.length; i++){
                    
                    if(lpId == 0) {
                      var institution_item_el = '<option value="'+data.institutionList[i]['institution_id']+'">'+data.institutionList[i]['institution_name']+'</option>';
                    }
                    else if(data.landingPageList[0]['institution_id'] == data.institutionList[i]['institution_id'] ){
                      var institution_item_el = '<option selected value="'+data.institutionList[i]['institution_id']+'">'+data.institutionList[i]['institution_name']+'</option>';
                    }
                    
                    landingPageInstitution.append(institution_item_el);
                  }

                  var assignee = $("#assignee").empty();
                  assignee.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.assigneeList.length; i++){
                    
                    if(lpId == 0) {
                      var assignee_item_el = '<option value="'+ data.assigneeList[i]['user_id']+'">'+ data.assigneeList[i]['assignee'] +'</option>';
                    }
                    else if(data.landingPageList[i]['assignee'] == data.assigneeList[0]['user_id']){
                      var assignee_item_el = '<option selected value="'+ data.assigneeList[i]['user_id']+'">'+ data.assigneeList[i]['assignee'] +'</option>';  
                    }
                    
                    assignee.append(assignee_item_el);
                  }

                  var assigner = $("#assigner").empty();
                  assigner.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.assigneeList.length; i++){
                    
                    if(lpId == 0){
                      var assigner_item_el = '<option value="'+ data.assigneeList[i]['user_id']+'">'+ data.assigneeList[i]['assignee'] +'</option>';
                    }
                    else if(data.landingPageList[i]['assigner'] == data.assingerList[0]['user_id']) {
                      var assigner_item_el = '<option selected value="'+ data.assigneeList[i]['user_id']+'">'+ data.assigneeList[i]['assignee'] +'</option>';
                    }
                    
                    assigner.append(assigner_item_el);
                  }
                  
                  var developmentType = $("#developmentType").empty();
                  developmentType.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.developmentTypeList.length; i++){
                    
                    if(lpId == 0){
                      var developmentType_item_el = '<option value="'+ data.developmentTypeList[i]['development_type_id']+'">'+ data.developmentTypeList[i]['development_type_name'] +'</option>';
                    }
                    else if(data.landingPageList[i]['fk_development_id'] == data.developmentTypeList[0]['development_type_id'] ){
                      var developmentType_item_el = '<option selected value="'+ data.developmentTypeList[i]['development_type_id']+'">'+ data.developmentTypeList[i]['development_type_name'] +'</option>';
                    }
                    
                    developmentType.append(developmentType_item_el);
                  }

                  var lpissue = $("#issue").empty();
                  lpissue.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.issueList.length; i++){                    
                    if(lpId == 0){
                      var issue_item_el = '<option value="'+ data.issueList[i]['issue_id']+'">'+ data.issueList[i]['issue_name'] +'</option>';
                    }
                    else if(data.landingPageList[i]['fk_issue_id'] == data.issueList[0]['issue_id'] ){
                      var issue_item_el = '<option selected value="'+ data.issueList[i]['issue_id']+'">'+ data.issueList[i]['issue_name'] +'</option>';
                    }
                    
                    lpissue.append(issue_item_el);
                  }

                  var lppriority = $("#priority").empty();
                  lppriority.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.priorityList.length; i++){                    
                    if(lpId == 0){
                      var priority_item_el = '<option value="'+ data.priorityList[i]['priority_id']+'">'+ data.priorityList[i]['priority_name'] +'</option>';
                    }
                    else if(data.landingPageList[i]['fk_priority_id'] == data.priorityList[0]['priority_id'] ){
                      var priority_item_el = '<option selected value="'+ data.priorityList[i]['priority_id']+'">'+ data.priorityList[i]['priority_name'] +'</option>';
                    }
                    
                    lppriority.append(priority_item_el);
                  }
                  
                  var lpstatus = $("#status").empty();
                  lpstatus.append("<option value=''>--Select--</option>");
                  for(var i=0; i<data.statusList.length; i++){
                    
                    if(lpId == 0){
                      var status_item_el = '<option value="'+ data.statusList[i]['lp_status_id']+'">'+ data.statusList[i]['lp_status'] +'</option>';
                    }
                    else if(data.landingPageList[i]['fk_lp_status_id'] == data.statusList[0]['lp_status_id'] ){
                      var status_item_el = '<option selected value="'+ data.statusList[i]['lp_status_id']+'">'+ data.statusList[i]['lp_status'] +'</option>';
                    } 
                    lpstatus.append(status_item_el);
                  }

                }
            }      
      });
      
    }
</script>
@endsection