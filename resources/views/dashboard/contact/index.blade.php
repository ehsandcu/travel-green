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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Messages</h5>
                    <p class="card-text total_messages">0</p>                
                </div>
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contact Us</h4>                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="contact_us_data_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Received At</th>
                                    <th>Action</th>
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
            loadContactUsList();
        });

        function loadContactUsList() {
            $("#contact_us_data_table").DataTable().destroy();
            $('#contact_us_data_table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('load.contact_us.list') }}",
                    "contentType": "application/json",
                    "type": "POST",
                    "data": function (d) { return JSON.stringify(d); },
                    complete: function (res) {
                        var response = res['responseJSON'];
                        $('.total_messages').text(response.iTotalRecords);
                    },
                },
                columns: [
                    { data: 'Name' },
                    { data: 'Email' },
                    { data: 'Message' },
                    { data: 'Received At' },
                    { data: 'Action', orderable: false }
                ]
            });
        }
    </script>
@stop