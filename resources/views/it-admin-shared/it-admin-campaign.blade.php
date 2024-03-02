@extends('it-admin-shared.it-admin-master')

@section('it-adminContent')
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
                            <a class="btn btn-primary" id="it-adminCampaignDownloadId" }}" title="Download">
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
                            <button type="button" class="btn btn-danger" title="Delete Campaign" onclick="deleteCampaign({{ $campaign->campaign_id }})"><i class="fa fa-trash-o">&nbsp;Delete</i></button> 
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.tutorialjinni.com/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {        
        $("#it-adminCampaignID").addClass( "active bg-gradient-primary" );
        $("#it-adminLandingPageID").removeClass( "active bg-gradient-primary" );
        $("#it-adminHomeID").removeClass( "active bg-gradient-primary" );
    });
    
</script>
@endsection