@extends('dashboard.layouts.main')
@section('dashboard_content')
    <div class="row">    
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Emissions</h4>                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="emission_data_table">
                            <thead>
                                <tr>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Travel Mode</th>
                                    <th>Work Days/Week</th>
                                    <th>Distance</th>
                                    <th>Carbon Emission</th>
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
            loadEmissionList();
        });

        function loadEmissionList() {
            $("#emission_data_table").DataTable().destroy();
            $('#emission_data_table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('load.emissions') }}",
                    "contentType": "application/json",
                    "type": "POST",
                    "data": function (d) { return JSON.stringify(d);}
                },
                columns: [
                    { data: 'Origin' },
                    { data: 'Destination' },
                    { data: 'Travel Mode' },
                    { data: 'Work Days/Week' },
                    { data: 'Distance' },
                    { data: 'Carbon Emission' }
                ]
            });
        }
    </script>
@stop