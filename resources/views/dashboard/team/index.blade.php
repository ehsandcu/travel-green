@extends('dashboard.layouts.main')
@section('dashboard_content')
    <style>
        td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 50px;
        }
    </style>
    <div class="row grid-margin stretch-card">
        <div class="col-sm-4">
            <div class="card shadow rounded">
                <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="card-text total_members">0</p>                
                </div>
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow rounded">
                <div class="card-body">
                    <h4 class="card-title">Contact Us</h4>                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="team_data_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>                                                                                                                                                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('dashboard-script')
    <script>
        $(document).ready(function() {  
            loadTeamList();
        });

        function loadTeamList() {
            $("#team_data_table").DataTable().destroy();
            $('#team_data_table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('load.team.list') }}",
                    "contentType": "application/json",
                    "type": "POST",
                    "data": function (d) { return JSON.stringify(d); },
                    complete: function (res) {
                        var response = res['responseJSON'];
                        $('.total_members').text(response.iTotalRecords);
                    },
                },
                columns: [
                    { data: 'Name' },
                    { data: 'Position' },
                    { data: 'Link' }
                ]
            });
        }
    </script>
@stop