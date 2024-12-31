@extends('dashboard.layouts.main')
@section('dashboard_content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h4 class="font-weight-bold"><span class="greeting"></span> 👋</h4>
                <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                    <div class="date-icon-set">
                       <input type="date" id="dashboard_start_date" name="dashboard_start_date" class="form-control" value="" placeholder="From Date">                       
                    </div>
                       <span class="flex-grow-0">
                       <span class="btn">To</span>
                    </span>
                    <div class="date-icon-set">
                       <input type="date" id="dashboard_end_date" name="dashboard_end_date" class="form-control" value="" placeholder="To Date">                       
                    </div>
              </div>
            </div>
         </div>
    </div>
   
    <div class="row grid-margin stretch-card">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Carbon Emission</h5>
                    <p class="card-text">{{ $emitStats->total_carbon_emission ?? 0 }}</p>                
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Records</h5>
                    <p class="card-text">{{ $emitStats->total_records ?? 0 }}</p>
                    
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Distance</h5>
                    <p class="card-text">{{ $emitStats->total_distance ?? 0 }}</p>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" id="dashboard-graph-emission-report" data-route="{{ route('emission.graph.data') }}">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="font-weight-bold">Emission Report</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- <div>
                                <svg  width="24" height="24" viewBox="0 0 24 24" fill="primary" xmlns="http://www.w3.org/2000/svg">
                                <rect class="sale_report_color" x="3" y="3" width="18" height="18" rx="2" fill="#820E4F" />
                                </svg>
                                <span>Sales</span>
                            </div>
                            <div class="ml-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="3" width="18" height="18" rx="2" fill="#808080" />
                                </svg>
                                <span>Orders</span>
                            </div> --}}
                        </div>
                    </div>
                    <div id="chart-apex-emission-report" class="custom-chart text-center">
                    </div>
                </div>
            </div>           
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Emissions</h4>                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="emission_data_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Trip Journey</th>
                                    <th>Journey Start Date</th>
                                    <th>Journey End Date</th>
                                    <th>Journey Description</th>
                                    <th>Route Type</th>
                                    <th>Travel Mode</th>
                                    <th>Work Days/Week</th>
                                    <th>Distance</th>
                                    <th>Carbon Emission</th>
                                    <th>Calculated At</th>
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
        var emissionSelector = "#chart-apex-emission-report";
        $(document).ready(function() {  
            // Display the greeting
            $('.greeting').text(greetingMsg());

            $(document).on('change','#dashboard_start_date', function() {
                var startDate = $(this).val();
                var endDate = $('#dashboard_end_date').val();

                if (startDate && endDate) {
                    emissionGraph();
                }
            });

            $(document).on('change','#dashboard_end_date', function() {
                var startDate = $('#dashboard_start_date').val();                
                var endDate = $(this).val();
                
                if (startDate && endDate) {
                    emissionGraph();
                }
            });

            $(document).on('click', '.delete_emission', function() {
                var deleteUrl = $(this).attr('data-delete_url');
                swal({
                    title: "Are you sure?",
                    icon: "warning",
                    text: "You will not be able to recover this record!",
                    buttons: {
                        cancel: true,
                        confirm: true,
                    },
                }).then(function(result){
                    if(result){
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            success: function(response) {
                                if (response.success == "1") {
                                    loadEmissionList();
                                    
                                    swal({
                                        title: "Got It!",
                                        text: response.message,
                                        icon: "success",
                                        button: "Ok",
                                        timer: 500
                                    });
                                } else {
                                    swal({
                                        title: "Got It!",
                                        text: response.message,
                                        icon: "error",
                                        button: "Ok",
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                swal({
                                    title: "Got It!",
                                    text: jqXHR.responseJSON.message||'Something went wrong please try again',
                                    icon: "error",
                                    button: "Ok",
                                });
                            }
                        }); 
                    }
                }); 
            });

            loadEmissionList();
            emissionGraph();
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
                    "data": function (d) { return JSON.stringify(d); }
                },
                columns: [
                    { data: 'Name' },
                    { data: 'Origin' },
                    { data: 'Destination' },
                    { data: 'Trip Journey' },
                    { data: 'Journey Start Date' },
                    { data: 'Journey End Date' },
                    { data: 'Journey Description' },
                    { data: 'Route Type' },
                    { data: 'Travel Mode' },
                    { data: 'Work Days/Week' },
                    { data: 'Distance' },
                    { data: 'Carbon Emission' },
                    { data: 'Calculated At' },
                    { data: 'Action', orderable: false }
                ]
            });
        }

        function emissionGraph(){
            $.ajax({
                url: $("#dashboard-graph-emission-report").attr("data-route"),
                type: "POST",
                cache: false,
                data: {
                    start_date:$('#dashboard_start_date').val(),
                    end_date:$('#dashboard_end_date').val(),
                },
                success: function (result) {
                    $(emissionSelector).html(''); //remove old divs before chart                    

                    if ((result.total_records).length > 0) {
                        var time = result.labels;

                        var options = {
                            series: [{
                                name: 'Emission',
                                data: result.emission
                            },  {
                                name: 'Total Records',
                                data: result.total_records
                            }],
                            colors: ['#2b80ff','#808080'],

                            chart: {
                                height: 265,
                                fontFamily: 'DM Sans',
                                toolbar: {
                                    show: false,
                                },
                                type: 'area'
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth'
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'light',
                                    type: "vertical",
                                    shadeIntensity: 0.5,
                                    inverseColors: false,
                                    opacityFrom: .8,
                                    opacityTo: .2,
                                    stops: [0, 50, 100],
                                    colorStops: []
                                }
                            },
                            grid: {
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                yaxis: {
                                    lines: {
                                        show: false
                                    }
                                }
                            },
                            xaxis: {
                                categories: time
                            },
                            tooltip: {
                                x: {
                                    format: 'HH:mm'
                                },
                            },
                        };
                        var chart = new ApexCharts(document.querySelector(emissionSelector), options);
                        chart.render();
                    } else {
                        $(emissionSelector).html('<img class="h-280" src="../images/icon/statistic-transparent.png">');
                    }
                }
            });
        }
    </script>
@stop